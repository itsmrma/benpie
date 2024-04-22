<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v9.1.0/ol.css">
    <style>
      .map {
        height: 400px;
        width: 100%;
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


    <script >
    
      var coordinate =  <?php echo json_encode($coordinate); ?>; // inizializza le coordinate da php a js

      const iconFeature = new ol.Feature({
        geometry: new ol.geom.Point([0, 0]),
        name: 'Null Island',
        population: 4000,
        rainfall: 500,
      });

      const iconStyle = new ol.Style({
        image: new ol.Style.Icon({
          anchor: [0.5, 46],
          anchorXUnits: 'fraction',
          anchorYUnits: 'pixels',
          src: 'data/icon.png',
        }),
      });

      iconFeature.setStyle(iconStyle);

      const vectorSourceLocation = new VectorSource({
        features: [iconFeature],
      });

      const vectorLayerLocation = new VectorLayer({
        source: vectorSourceLocation,
      });

      var vectorLayer = new ol.layer.Vector({ // VectorLayer({
          source: new ol.source.Vector(),
      });
      
      var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.OSM()
          }), vectorLayer, vectorLayerLocation
        ],
        view: new ol.View({
          center: ol.proj.fromLonLat([37.41, 8.82]),
          zoom: 4
        })
      });

    
    </script>

  </body>
</html>