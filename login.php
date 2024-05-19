<?php require_once "controller.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/page_login.css">
    <?php include 'head.html'; ?>
    <script src="js/ShowPSW.js"></script>

    <script>
        function cambiaColoreCuore(id) {
            let bottone = document.getElementById(id);
            var coloreCuore = bottone.style.color;
            if(coloreCuore == "black"){
            bottone.style.color= "red";
            return "aggiunto";
            }else if(coloreCuore == "red"){
            bottone.style.color = "black";
            return "rimosso";
            }
        }
    
        function addRemoveFavorite(id, idEvento){
        var aggiuntoRimosso = cambiaColoreCuore(id);
        showNotificationRemove(aggiuntoRimosso);
        var numIdEvento = parseInt(idEvento);
        document.cookie =  "idevent=" + numIdEvento;
        switch(aggiuntoRimosso){
            case "aggiunto":
            sendAjaxRequest('addFavourite.php');
            break;
            case "rimosso":
            sendAjaxRequest('removeFavourite.php');
            break;
        }
        }

        function sendAjaxRequest(urlToSend) {
        $.ajax({
            type: "POST",
            url: urlToSend
        });
        }

        function showNotificationRemove(aggiuntoRimosso) {
                var options = {
                    duration: 8000, // Durata in millisecondi
                    inDuration: 300, // Durata dell'animazione di ingresso
                    outDuration: 200 // Durata dell'animazione di uscita
                };

                // Mostra lo snackbar
                M.Toast.dismissAll();
                M.toast({ html: "Evento "+aggiuntoRimosso +" dai preferiti.", ...options });
        }

        function switchContenuto(bottonePremuto){
            var commenti = document.getElementById("commentiScritti");
            var preferiti = document.getElementById("tabellaPreferiti");
            if(bottonePremuto=="messaggi"){
                commenti.style.display="block"
                preferiti.style.display="none"
            }else if(bottonePremuto=="preferiti"){
                commenti.style.display="none"
                preferiti.style.display="block"
            }
        }

    </script>

    <style>
        .main-container {
            height: max-content;
        }
        .grid-container {
            display: grid;
            grid-template-columns: auto 60% auto;
            grid-template-rows: 100px 200px auto;
            padding: 5%;
            width: 100%;
            height: 100%;
        }

        .commentContainer {
            margin:10px;
            width: 600px;
            height: 200px;
            -moz-border-radius: 20px;
            border-radius: 20px;
            overflow: hidden;
            background-color: #e6e0e9;
            position: relative;
        }

        .mdc-data-table {
            width: 100%;
            height: auto;
            margin:auto
        }

        .tabs{
            -moz-border-radius: 20px;
            border-radius: 20px;
            overflow: hidden;
            margin: auto;
        }

        .flex-container{
            display: flex;
        }
        
        .mdc-data-table {
            width: 100%;
            bottom:5%;
            height: 100%;
            -moz-border-radius: 15px;
            border-radius: 15px;
            overflow: hidden;
            margin:auto;
        }
        
    </style>

</head>

<body>

    <?php include 'code.html'; ?>

        <div class="main-container">

        <?php
            if (isset($_GET['logout'])) {
                if ($_GET['logout']==1) {
                    echo "<script>showNotification('Logout effettuato.');</script>";
                }
            }
        ?>


        <?php if (!isset($_SESSION["email"], $_SESSION["password"])) { ?>
            <div class="main">

                <div class="section flex-center-y">
                    <div class="rounded-inner">
                        <form class="basic-form" method="POST" action="login.php">
                            <h1 class="firstTitle flex-center-x">Accedi</h1>
                            <?php
                            if (count($errors) > 0) { ?>

                                <div class="alert alert-danger">
                                    <?php
                                    foreach ($errors as $showerror) {
                                        ?>
                                        <li><?php echo $showerror; ?></li>
                                        <?php
                                    }
                                    ?>
                                </div>

                            <?php }
                            ?>
                            <div class="input-container">
                                <div class="material-textfield">
                                    <input placeholder="" type="email" required name="email">
                                    <label>Email</label>
                                </div>
                            </div>
                            <div class="input-container">
                                <div class="material-textfield">
                                    <input placeholder="" type="password" required name="password" id="password">
                                    <label>Password</label>
                                    <span id="PSWShowHideIcon" onclick="ShowPSW()"><i
                                            class="fa-solid fa-eye-slash"></i></span>
                                </div>
                                <br>
                                <p class="firstSubtitle">Non hai un account?<a href="signup.php" class="link">
                                        Registrati</a>
                                </p>
                            </div>
                            <button class="btn filled submit-btn" type="submit" name="login" value="login">Accedi</a>
                        </form>
                    </div>
                </div>
            </div>

        <?php } else{ ?>
            <div class="grid-container">
            <?php
            $conn = mysqli_connect('localhost', '5biin-02', '5biin-02', '5biin-02');
            $sql = "SELECT nomeUtente FROM utenti WHERE email='" . $_SESSION['email'] . "'";
            $result = $conn->query($sql);
            $nomeUser = $result->fetch_assoc();
            echo "<h1 style='grid-column: 2; grid-row: 1;'>Ciao " . $nomeUser['nomeUtente']."</h1>";
            ?>

            <div  style="grid-column:3; grid-row: 1; right:0;">
            <md-filled-tonal-icon-button href="logout.php">
                <span class="material-symbols-outlined">
                    logout
                </span>
                Logout
            </md-filled-tonal-icon-button>
            </div>
           
            <md-tabs class="tabs" id="tabs" style="grid-column: 2; grid-row: 2; width:100%;" >
               <md-primary-tab  onclick="switchContenuto('preferiti')">Preferiti</md-primary-tab>
                <md-primary-tab onclick="switchContenuto('messaggi')">Commenti</md-primary-tab>
            </md-tabs>
            

            <md-list id="commentiScritti" style="grid-column: 2; grid-row: 3; background-color:burlywood;-moz-border-radius: 20px;border-radius: 20px;
            overflow: hidden; width:fit-content; display:none; margin:auto">

                <?php
                    $sql = "select * from commento where idUtente=".$_SESSION["id"]." order by dataOraPubblicazione desc";
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
                                case 5:
                                    $idEvento = $value;
                            }
                        }
                ?>
                <md-list-item style="margin:auto;"
                    type="link"
                    href="infoEvento.php?idEvento=<?php echo  $idEvento;?>&idComment=<?php echo  $idCommento;?>"
                    target="_blank">
                    <div slot="headline">
                        <div class="commentContainer" >
                            <div class="flex-container">
                                <span class="material-symbols-outlined" style="margin:10px;color:black;">account_circle</span>
                                    <div style="color:black; margin: 10px;"><?php echo $nomeUser['nomeUtente'] ?></div>
                                    <div style="color:black; right:0; margin-left: 40%"><?php echo $dataOraPubblicazione ?></div>
                                </div>
                            <div height="40%" width="100%" style="color:black; margin-left: 10px"><?php echo $contenutoCommento ?></div>
                        </div>
                    </div>
               
                </md-list-item>
                <md-divider></md-divider>
                <?php } ?>

            </md-list>




            <div class="mdc-data-table" id="tabellaPreferiti"  style="grid-column: 2; grid-row: 3; display:block;">
            <div class="mdc-data-table__table-container">
            <table class="mdc-data-table__table" aria-label="Prossimi eventi">
                <thead>
                    <tr class="mdc-data-table__header-row">
                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col" width="60px"></th>
                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">EVENTI PREFERITI</th>
                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">DESCRIZIONE</th>
                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col"><span class='material-symbols-outlined'>schedule</span>INIZIO</th>
                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col"><span class='material-symbols-outlined'>schedule</span>FINE</th>
                    </tr>
                </thead>

                <tbody class="mdc-data-table__content">

                <?php
                $sql = "select DISTINCT evento.denom, idEvento, CAST(evento.data_inizio AS date)  as data_inizio, CAST(evento.data_fine AS date)  as data_fine, descrizione from preferiti inner join evento on evento.id = preferiti.idEvento where preferiti.idUtente =".$_SESSION['id'];
              
                $prossimiEventi = $conn->query($sql) or die($conn->error);
            
                while ($datiEventi = $prossimiEventi->fetch_assoc()) {?>
              
                  <tr class='mdc-data-table__row' aria-label="Prossimi eventi">
                    <td class='mdc-data-table__cell mdc-data-table__cell--numeric'>
                      <md-icon-button  onclick="addRemoveFavorite('favourite', <?php echo $datiEventi['idEvento']?>)" >
                        <span class='material-symbols-outlined' style="color: red;" id='favourite'>
                          favorite
                        </span>
                      </md-icon-button>
                    </td>
                <?php  
                  echo "
                    <td class='mdc-data-table__cell'><a href='infoEvento.php?idEvento=" . $datiEventi['idEvento'] ."'target='_blank' ><md-text-button>" . $datiEventi["denom"] . "</md-text-button></a></td>
                    <td class='mdc-data-table__cell'><marquee behavior='scroll' direction='left'>".$datiEventi['descrizione']."</marquee></td>
                    <td class='mdc-data-table__cell'>" . $datiEventi['data_inizio'] . "</td>
                    <td class='mdc-data-table__cell'>" . $datiEventi['data_fine'] . "</td>
                  </tr>";
                }
            ?>
                </tbody>
            </table>
            </div>
            </div>

        </div>

            

        <?php } ?>
    </div>


    <script>
        // set active
        var active = document.getElementById('sidebar_login');
        active.classList.add('active');
    </script>



</body>

</html>