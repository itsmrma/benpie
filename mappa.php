<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v9.1.0/ol.css">
    <style>
      .map {
        height: 800px;
        width: 60%;
        
        margin-left: auto;
        margin-right: auto;
      }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/ol@v9.1.0/dist/ol.js">
     
    </script>
    
    
  </head>


  <body>

    
    <div id="map" class="map"></div>

    <?php 
        
        $conn = new mysqli("localhost","root","","sagre");
			
        // Check connection
        if ($conn -> connect_error) {
          die("Errore di connessione ".$conn->connect_errno." ".$conn->connect_error);
        }
        
        $sql = "select geo_x, geo_y from evento";
        

				if(($result = $conn ->query($sql))){
					echo "query corretta";
				}else{
					echo "query non corretta";
				}
				$coordinate = [];
        $j=0;

				foreach($result as $row){
          $i=0;
					foreach($row as $key => $value){
            $temp[$i] = $value;
            $i++;
					}
					$coordinate[$j] = $temp;
          $j++;
				}
        
        
    ?> 


    <script type="module">
      
      var coordinate =  <?php echo json_encode($coordinate); ?>; // inizializza le coordinate da php a js
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
          console.log(coordinate[i][0],coordinate[i][1]);
          iconFeature[j] = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.transform([coordinate[i][0], coordinate[i][1]], "EPSG:4326", "EPSG:3857")),
            name: 'Null Island',
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

      var vectorLayer = new ol.layer.Vector({ // VectorLayer({
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
          center: ol.proj.fromLonLat([37.41, 8.82]),
          zoom: 4
        })
      });

    
    </script>

  </body>
</html>