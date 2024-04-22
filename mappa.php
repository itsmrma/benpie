<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v9.1.0/ol.css">
    <style>
      .map {
        height: 800px;
        width: 60%;
        
        margin-left: auto;
        margin-right: auto;
      }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/ol@v9.1.0/dist/ol.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    

  </head>


  <body>

    
    <div id="map" class="map"><div id="popup"></div></div>

    <?php 
        session_start();
        $conn = new mysqli("localhost","root","","sagre");
			
        // Check connection
        if ($conn -> connect_error) {
          die("Errore di connessione ".$conn->connect_errno." ".$conn->connect_error);
        }
        
        $sql = "select geo_x, geo_y, denom, id from evento";
        

				if(($coordResult = $conn ->query($sql))){
					echo "query corretta";
				}else{
					echo "query non corretta";
				}
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
            }else{
              $temp[$i] = $value;
              $i++;
            }
					}
					$coordinate[$j] = $temp;
          $j++;
				}
        
        
    ?> 


    <script type="module">
      var coordinate =  <?php echo json_encode($coordinate); ?>; // inizializza le coordinate da php a js
      var nomiEventi = <?php echo json_encode($denominazioni); ?>; // inizializza nomi eventi da php a js
      var id = <?php echo json_encode($id); ?>;

      console.log(coordinate[0][0],coordinate[0][1]);
      const iconFeature = [];

      const iconStyle = new ol.style.Style({
        image: new ol.style.Icon({
          anchor: [0.5, 50],
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
            name: nomiEventi[j],
            id: id[j],
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
          center: [45.553139, 9.599792],
         
          zoom: 3
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

        document.cookie = "idEvento = "+feature.get('id');
        <?php $_SESSION["idEvento"]= $_COOKIE["idEvento"]; ?>

        disposePopover();
        if (!feature) {
          return;
        }
        popup.setPosition(evt.coordinate);
        popover = new bootstrap.Popover(element, {
          placement: 'top',
          html: true,
          content: "<a href='infoEvento.php'>"+feature.get('name')+"</a>"
        });
        popover.show();
      });

      map.on('movestart', disposePopover);

    
    </script>

  </body>
</html>