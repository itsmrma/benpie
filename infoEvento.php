<html>

    <head>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v9.1.0/ol.css">
        <style>
        .map {
            height: 40%;
            width: 40%;
            
            margin-left: auto;
            margin-right: auto;
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

            <div class="infoEvento">
                <?php
                    $opts = [
                        'http' => [
                          'method' => "GET",
                          // Use newline \n to separate multiple headers
                          'header' => "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7\nAccept-Encoding:gzip, deflate, br, zstd\nAccept-Language:it-IT,it;q=0.9,en-US;q=0.8,en;q=0.7",
                        ]
                      ];

                    $conn = new mysqli("localhost","root","","sagre");
                    
                    if ($conn -> connect_error) {
                        die("Errore di connessione ". $conn->connect_errno ." ".$conn->connect_error);
                    }

                    $sql = "select * from evento where id=".$_COOKIE["idEvento"];
                    
                    $coordResult = $conn -> query($sql);
                    $array=$coordResult->fetch_assoc();

                    
                    echo "<h1> ". $array['denom'] . "</h1><br>";
                    echo "<h3>" . $array['descrizione'] . "</h3><br>";

                    $date=date_create($array['data_inizio']);
                    $date1 = date_format($date, "Y/m/d");
                    $date = date_create($date1 . $array['ora_inizio']);
                    $start = date_format($date,"Y/m/d H:i");

                    $date=date_create($array['data_fine']);
                    $date1 = date_format($date, "Y/m/d");
                    $date = date_create($date1 . $array['ora_fine']);
                    $end = date_format($date,"Y/m/d H:i");

                    echo "<span class='material-symbols-outlined'>schedule</span>" . $start . "<span class='material-symbols-outlined'>sports_score</span>" . $end . "<br><br><br>";

                    echo "<div id='feedback-recruiting'><div class='grid-center-2col'><a class='card-1' href='". $array['url'] . "'><i class='fas fa-comment'></i><h4 style='margin: 0;'>PDF</h4></a></div></div>";
                                        
    
                    print_r($array);
                    
                    $geo_x = $array["geo_x"];
                    $geo_y = $array["geo_y"];
                    $idEvento = $array["id"];

                ?>
            </div>

            
            
        </div>

        <script>
            // set active
            var active = document.getElementById('sidebar_search');
            active.classList.add('active');
        </script>

        <script src="js/ripple.js"></script>
    
        <script type="module">

            var geo_x =  <?php echo json_encode($geo_x); ?>; // inizializza le coordinate da php a js
            var geo_y = <?php echo json_encode($geo_y); ?>; // inizializza nomi eventi da php a js
            var idEvento = <?php echo json_encode($idEvento); ?>;
            console.log(geo_x, geo_y, idEvento);

            const iconFeature = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.transform([geo_x, geo_y], "EPSG:4326", "EPSG:3857")),
                id: idEvento,
            });

            const iconStyle = new ol.style.Style({
                image: new ol.style.Icon({
                    anchor: [0.5, 640],
                    anchorXUnits: 'fraction',
                    anchorYUnits: 'pixels',
                    src: 'icona.png',
                    scale: 0.06
                }),
            });

            if(geo_x!=null && geo_y!=null){
                iconFeature.setStyle(iconStyle);
            }

            const vectorSourceLocation = new ol.source.Vector({
                features: [iconFeature],
            });

            const vectorLayerLocation = new ol.layer.Vector({
                source: vectorSourceLocation,
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
                    center: ol.proj.transform([geo_x, geo_y], "EPSG:4326", "EPSG:3857"),
                    extent: [944407.0434141352, 5570429.229433595, 1274103.8338330938,  5885413.565552787],
                    zoom: 14,
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

                disposePopover();
                if (!feature) {
                    return;
                }
                popup.setPosition(evt.coordinate);
                popover = new bootstrap.Popover(element, {
                    placement: 'top',
                    html: true,
                    content: "<a target='_blank' href='infoEvento.php'>"+feature.get('name')+"</a>"
                });
                popover.show();
            });

            map.on('movestart', disposePopover);

        </script>
        
    </body>
</html>

