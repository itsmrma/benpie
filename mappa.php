<!doctype html>
<html lang="en">
  <head>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v9.1.0/ol.css">
    <style>
      .map {
        margin:auto;
        position: relative;        
        width: 80%;
        height: 70%;
        left: 20px;
        top: 20px;
        -moz-border-radius: 15px;
        border-radius: 15px;
        border: 1px solid black;
        overflow: hidden;

      }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/ol@v9.1.0/dist/ol.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php include 'head.html';?>
  </head>


  <body>
    <?php include 'code.html';?>

    
    <div class="main-container">
        <div id="map" class="map"><div id="popup"></div></div>
    </div>

    <?php 
        $conn = new mysqli("localhost","root","","sagre");
			
        if ($conn -> connect_error) {
          die("Errore di connessione ".$conn->connect_errno." ".$conn->connect_error);
        }
        
        $sql = "select geo_x, geo_y, denom, id from evento";
        

				$coordResult = $conn ->query($sql);
				$coordinate = [];
        $denominazioni = [];
        $id = [];
        $j=0;

				foreach($coordResult as $row){
          $i=0;
					foreach($row as $key => $value){
            if($key=="denom"){
              $denominazioni[$j] = $value;
            }else if($key=="id"){
              $id[$j] = $value;
            }else if($key=="geo_x" || $key== "geo_y"){
              $temp[$i] = $value;
              $i++;
            }
					}
					$coordinate[$j] = $temp;
          $j++;
				}
        
        
    ?> 
    
    <script>
      // set active
      var active = document.getElementById('sidebar_map');
      active.classList.add('active');
    </script>

    <script type="module">

      var coordinate =  <?php echo json_encode($coordinate); ?>; // inizializza le coordinate da php a js
      var nomiEventi = <?php echo json_encode($denominazioni); ?>; // inizializza nomi eventi da php a js
      var id = <?php echo json_encode($id); ?>; // inizializza id eventi da php a js

      const iconFeature = [];

      const iconStyle = new ol.style.Style({
        image: new ol.style.Icon({
          anchor: [0.5, 640],
          anchorXUnits: 'fraction',
          anchorYUnits: 'pixels',
          src: 'icona.png',
          scale: 0.06
        }),
      });

      for(var i=0, j=0; i<coordinate.length; i++){
        console.log(coordinate[i][0],coordinate[i][1]);
        if(coordinate[i][0]!=null && coordinate[i][1]!=null){
          iconFeature[j] = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.transform([coordinate[i][0], coordinate[i][1]], "EPSG:4326", "EPSG:3857")),
            name: nomiEventi[i],
            id: id[i],
          });
          iconFeature[j].setStyle(iconStyle);
          j++;
        }
      }

      const IconCollection = new ol.Collection(iconFeature);

      const vectorSourceLocation = new ol.source.Vector({
        features: IconCollection,
      });

      const vectorLayerLocation = new ol.layer.Vector({
        source: vectorSourceLocation,
      });

      var vectorLayer = new ol.layer.Vector({ 
          source: new ol.source.Vector(),
      });
      
      var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.XYZ({
              url: 'http://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}'
            })
          }),vectorLayerLocation
        ],
        view: new ol.View({
          center: [1077769.5466310475,5736453.760081485],
          extent: [944407.0434141352, 5570429.229433595, 1274103.8338330938,  5885413.565552787],
          zoom: 7,
        })
      });
      
      const element = document.getElementById('popup');

      const popup = new ol.Overlay({
        element: element,
        positioning: 'bottom-center',
        stopEvent: false,
      });
      map.addOverlay(popup);

      let popover;
      function disposePopover() {
        if (popover) {
          popover.dispose();
          popover = undefined;
        }
      }
      
      map.on('click', function (evt) {
        
        const feature = map.forEachFeatureAtPixel(evt.pixel, function (feature) {
          return feature;
        });

        disposePopover();
        if (!feature) {
          return;
        }
        popup.setPosition(evt.coordinate);
        popover = new bootstrap.Popover(element, {
          placement: 'top',
          html: true,
          content: "<a target='_blank' href='infoEvento.php?idEvento="+feature.get('id')+"'>"+feature.get('name')+"</a>"
        });
        popover.show();
      });

      map.on('movestart', disposePopover);

    </script>

  </body>
</html>
