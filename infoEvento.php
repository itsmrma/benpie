<html>

    <head>
    <?php include 'head.html';?>
    </head>
    <body>

        <?php include 'code.html';?>

        <div class="main-container">
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

                    $sql = "select * from evento where id=". $_COOKIE["idEvento"];
                    
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
                ?>
            </div>
            
        </div>

        <script>
            // set active
            var active = document.getElementById('sidebar_search');
            active.classList.add('active');
        </script>

        <script src="js/ripple.js"></script>
        
    </body>
</html>

