<?php session_start(); ?>
<html>

<head>
    <?php
    include 'head.html';
    //error_reporting(0);
    ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v9.1.0/ol.css">

    <style>
        .main-container {
            height: max-content;
        }

        .flex-container {
            display: flex;
        }

        .map {
            width: 600px;
            height: 400px;
            -moz-border-radius: 15px;
            border-radius: 15px;
            overflow: hidden;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto auto;
            grid-template-rows: auto auto auto auto auto auto;
        }

        .item1 {
            grid-column: 2 / span 3;
            grid-row: 1;
        }

        .item2 {
            grid-row: 2;
            grid-column: 2 / span 3;
            padding: 20px;
            -moz-border-radius: 20px;
            border-radius: 20px;
            background-color: darkslateblue;
            display: grid;
            grid-template-columns: 150px 150px auto;
            grid-template-rows: auto auto auto auto;
        }

        .item3 {
            margin-top: 30px;
            grid-column: 2 / span 3;
            grid-row: 5/6;
        }

        .item4 {
            margin-top: 30px;
            grid-column: 2 / span 3;
            grid-row: 4;
        }

        .commentContainer {
            margin: 10px;
            width: 600px;
            height: 200px;
            -moz-border-radius: 20px;
            border-radius: 20px;
            overflow: hidden;
            background-color: #e6e0e9;
            position: relative;
        }

        .commentButton {
            height: 10px;
        }

        #commenti {
            -moz-border-radius: 20px;
            border-radius: 20px;
            background-color: thistle;
            padding-top: 20px;
            padding-bottom: 20px;
            margin-top: 20px
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/ol@v9.1.0/dist/ol.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        function cambiaColoreCuore(x) {
            let bottone = document.getElementById('cuore');
            bottone.style.color = x;
        }
    </script>

    <script defer>

        function showNotification() {
            cambiaColoreCuore('red');

            var options = {
                duration: 8000, // Durata in millisecondi
                inDuration: 300, // Durata dell'animazione di ingresso
                outDuration: 200 // Durata dell'animazione di uscita
            };

            // Mostra lo snackbar
            M.toast({ html: "Evento aggiunto ai preferiti.", ...options });
        }

        function showNotificationComment() {
            var options = {
                duration: 8000, // Durata in millisecondi
                inDuration: 300, // Durata dell'animazione di ingresso
                outDuration: 200 // Durata dell'animazione di uscita
            };

            // Mostra lo snackbar
            M.toast({ html: "Commento aggiunto.", ...options });
        }

    </script>

    <script>

        function sendAjaxRequest(element, urlToSend) {
            var clickedButton = element;
            $.ajax({
                type: "POST",
                url: urlToSend,
                data: { id: clickedButton.val(), access_token: $("#access_token").val() }
            });
        }

        $(document).ready(function () {
            $("#favourite").click(function (e) {
                e.preventDefault();
                sendAjaxRequest($(this), 'addFavourite.php');
            });
        });

        function downloadPdf(url) {
            window.open(url, "self");
        }

        function inviaCommento(idCommento) {
            showNotificationComment();
            var input = document.getElementById(idCommento).value;
            input = input.replaceAll("\n", "&");
            console.log(input);
            document.cookie = "testo=; Max-Age=0"
            document.cookie = "idCommentoPadre=; Max-Age=0"
            document.cookie = "testo=" + input;
            console.log(document.cookie);
            if (idCommento != "scriviCommento") {
                var tempId = parseInt(idCommento);
                document.cookie = "idCommentoPadre=" + tempId;
            } else {
                document.cookie = "idCommentoPadre=0"
            }
            $.ajax({
                type: "POST",
                url: "inviaCommento.php",
            });
        }

        function rispondi(idCommento) {
            var commento = document.getElementById("reply" + idCommento);
            if (commento.style.display == "none") {
                commento.style.display = "block";
            } else {
                commento.style.display = "none";
            }

        }

    </script>


</head>

<body>

    <?php include 'code.html'; ?>



    <div class="main-container">

        <div class="grid-container">

            <div class="item1">
                <?php

                $opts = [
                    'http' => [
                        'method' => "GET",
                        // Use newline \n to separate multiple headers
                        'header' => "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7\nAccept-Encoding:gzip, deflate, br, zstd\nAccept-Language:it-IT,it;q=0.9,en-US;q=0.8,en;q=0.7",
                    ]
                ];

                $conn = new mysqli("localhost", "root", "", "sagre");

                if ($conn->connect_error) {
                    die("Errore di connessione " . $conn->connect_errno . " " . $conn->connect_error);
                }
                $_SESSION["idEvento"] = $_GET["idEvento"];
                $sql = "select * from evento where id=" . $_GET["idEvento"];

                $coordResult = $conn->query($sql);
                $array = $coordResult->fetch_assoc();


                echo "<h1> " . $array['denom'] . "</h1><br>";
                ?>
            </div>

            <div class="item2">

                <?php
                echo "<div style='grid-column: 3; grid-row: 1/5;' id='map' class='map'><div id='popup'></div></div>";
                echo "<h3 style='grid-column: 1/2; grid-row: 1/2; margin:10px; margin-top:20px;'>" . $array['descrizione'] . "</h3><br>";

                $date = date_create($array['data_inizio']);
                $date1 = date_format($date, "Y/m/d");
                $date = date_create($date1 . $array['ora_inizio']);
                $start = date_format($date, "Y/m/d H:i");

                $date = date_create($array['data_fine']);
                $date1 = date_format($date, "Y/m/d");
                $date = date_create($date1 . $array['ora_fine']);
                $end = date_format($date, "Y/m/d H:i");

                echo "<span style='grid-column: 1/2; grid-row: 3;' class='material-symbols-outlined'>schedule</span><div style='grid-column: 1/2; grid-row: 3; margin-left:40px'>" . $start .
                    "</div><span style='grid-column: 1/2; grid-row: 4;' class='material-symbols-outlined'>sports_score</span><div style='grid-column: 1/2; grid-row: 4;margin-left:40px'>" . $end .
                    "</div><br><br><br>";
                ?>

                <md-filled-tonal-icon-button style='grid-column: 1; grid-row: 5;' id='download'
                    onclick="downloadPdf('<?php echo $array['url'] ?>')">
                    <span class='material-symbols-outlined'>
                        download
                    </span>
                </md-filled-tonal-icon-button>

                <br>
                <?php if (isset($_SESSION["email"])) {
                    $_SESSION["idEvento"] = $array['id']; ?>
                    <md-filled-tonal-icon-button style='grid-column: 1; grid-row: 5; margin-left: 50px;' id='favourite' onclick="showNotification()">
                        <span class='material-symbols-outlined' id="cuore">
                            favorite
                        </span>
                    </md-filled-tonal-icon-button>
                <?php }

                $geo_x = $array["geo_x"];
                $geo_y = $array["geo_y"];
                $nomeEvento = $array["denom"];

                $sql="SELECT idEvento FROM preferiti WHERE preferiti.idUtente = ".$_SESSION['id'];
                $result = $conn->query($sql);
                foreach ($result->fetch_all(MYSQLI_ASSOC) as $row) {
                    if ($row['idEvento']==$_SESSION['idEvento']) {
                        echo "<script>cambiaColoreCuore('red');</script>";
                    }
                }
                
                ?>

            </div>

            <div class="item4">
                <h1>SEZIONE COMMENTI</h1>
            </div>

            <div class="item3">

                <div class="commentContainer">
                    <md-filled-text-field class="commenta" id="scriviCommento" --md-sys-color-primary: #006a6a; type="textarea" rows="4" style="resize:none; width: 100%; height:  75%;">
                    </md-filled-text-field>
                    <md-filled-tonal-button class="commentButton" onclick="inviaCommento('scriviCommento')">
                        Commenta
                    </md-filled-tonal-button>
                </div>


                <div id="commenti">
                    <?php

                    $conn = new mysqli("localhost", "root", "", "sagre");

                    if ($conn->connect_error) {
                        die("Errore di connessione " . $conn->connect_errno . " " . $conn->connect_error);
                    }

                    $sql = "select * from commento where idEvento=" . $_SESSION["idEvento"] . " order by dataOraPubblicazione desc";
                    $result = $conn->query($sql);
                    $dati = $result->fetch_all();

                    $nomeUtente = "";
                    $contenutoCommento = "";
                    $dataOraPubblicazione = "";
                    $idCommento = "";

                    foreach ($dati as $row) {
                        foreach ($row as $key => $value) {
                            switch ($key) {
                                case 1:
                                    $contenutoCommento = $value;
                                    break;
                                case 2:
                                    $dataOraPubblicazione = $value;
                                    break;
                                case 3:
                                    $nomeUtente = $value;
                                    break;
                                case 0:
                                    $idCommento = $value;
                                    break;
                            }
                        }
                        $sql = "select nomeUtente from utenti where idUtente=" . $nomeUtente;
                        $result2 = $conn->query($sql);
                        $nomeUser = $result2->fetch_assoc();
                        $nomeUtente = $nomeUser["nomeUtente"];

                        $sql = "select id from commento where idCommentoPadre=" . $idCommento . " order by dataOraPubblicazione desc";
                        $result2 = $conn->query($sql);
                        $commentiFiglio = $result2->fetch_all();

                        $associazioni = array();
                        $associazioni[0] = $idCommento;
                        $i = 1;
                        foreach ($commentiFiglio as $row2) {
                            foreach ($row2 as $key => $value) {
                                $associazioni[$i] = $value;
                            }
                            $i++;
                        }
                        ?>


                        <div class="bloccoCommenti" id="bloccoCommenti<?php echo $idCommento ?>" style="margin-left:30px;">
                            <div class="commentContainer" style="margin-top:20px;">
                                <div class="flex-container">
                                    <span class="material-symbols-outlined"
                                        style="margin:10px;color:black;">account_circle</span>
                                    <div style="color:black; margin: 10px;"><?php echo $nomeUtente ?></div>
                                    <div style="color:black; right:0; margin-left: 40%"><?php echo $dataOraPubblicazione ?>
                                    </div>
                                </div>
                                <div height="40%" width="100%" style="color:black; margin-left: 10px">
                                    <?php echo $contenutoCommento ?></div>
                                <md-filled-tonal-button height="20px" width="10px" style="bottom: 0; position: absolute;"
                                    onclick="rispondi(<?php echo $idCommento ?>)">
                                    Rispondi
                                </md-filled-tonal-button>
                                <md-filled-tonal-button height="20px" width="10px"
                                    style="left: 130; bottom: 0; position: absolute;"
                                    onclick="mostraRisposte(<?php echo $idCommento ?>)">
                                    Risposte
                                </md-filled-tonal-button>
                            </div>

                            <div id="<?php echo "reply" . $idCommento ?>" style="display:none; margin-top:20px;">
                                <div class="commentContainer">
                                    <md-filled-text-field class="commenta" id="<?php echo $idCommento ?>"
                                        --md-sys-color-primary: #006a6a; type="textarea"
                                        style="resize: none; width: 100%; height: 60%;">
                                    </md-filled-text-field>
                                    <md-filled-tonal-button class="commentButton"
                                        onclick="inviaCommento('<?php echo $idCommento ?>')">
                                        Commenta
                                    </md-filled-tonal-button>
                                </div>
                            </div>

                        </div>


                        <script>
                            var associazioni = <?php echo json_encode($associazioni); ?>;
                            for (j = 1; j < associazioni.length; j++) {
                                document.getElementById('bloccoCommenti' + associazioni[0]).append(document.getElementById('bloccoCommenti' + associazioni[j]));
                            }
                        </script>

                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // set active
        var active = document.getElementById('sidebar_search');
        active.classList.add('active');
    </script>

    <script src="js/ripple.js"></script>

    <script type="module">

        var geo_x = <?php echo json_encode($geo_x); ?>; // inizializza le coordinate da php a js
        var geo_y = <?php echo json_encode($geo_y); ?>; // inizializza nomi eventi da php a js
        var nomeEvento = <?php echo json_encode($nomeEvento); ?>;

        console.log(geo_x, geo_y);
        const iconFeature = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.transform([geo_x, geo_y], "EPSG:4326", "EPSG:3857")),
            nome: nomeEvento,
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

        if (geo_x != null && geo_y != null) {
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
                }), vectorLayerLocation
            ],
            view: new ol.View({
                center: ol.proj.transform([geo_x, geo_y], "EPSG:4326", "EPSG:3857"),
                extent: [944407.0434141352, 5570429.229433595, 1274103.8338330938, 5885413.565552787],
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

    </script>

    <?php
        if(isset($_GET["idComment"])){
        ?>
            <script>
                console.log("ciao");
                document.getElementById('bloccoCommenti'+<?php echo $_GET["idComment"] ?>).scrollIntoView();
            </script>
        <?php }
    ?>


</body>

</html>