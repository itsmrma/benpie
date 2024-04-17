<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
    <style>
      .map {
        height: 400px;
        width: 100%;
      }
    </style>
    <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
    <title>OpenLayers example</title>
  </head>

  <body>

    <h2>My Map</h2>
    <div id="map" class="map"></div>

    <script type="text/javascript">

        var vectorLayer = new ol.layer.Vector({ // VectorLayer({
            source: new ol.source.Vector(),
        });
        
      var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.OSM()
          }), vectorLayer
        ],
        view: new ol.View({
          center: ol.proj.fromLonLat([37.41, 8.82]),
          zoom: 4
        })
      });

      map.on('click', function (evt) {
        console.log(ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326'));
        addMarker(evt.coordinate);
      });
      var vectorSource = vectorLayer.getSource();
    function addMarker(coordinates) {
        console.log(coordinates);
        var marker = new ol.Feature(new ol.geom.Point(coordinates));
        var zIndex = 1;
        marker.setStyle(new ol.style.Style({
        image: new ol.style.Icon(({
            anchor: [0.5, 36], 
            anchorXUnits: "fraction",
            anchorYUnits: "pixels",
            opacity: 1,
            src: "mapIcons/pinother.png", 
            zIndex: zIndex
        })),
        zIndex: zIndex
        }));
        vectorSource.addFeature(marker);
    }
    </script>
  </body>
</html>