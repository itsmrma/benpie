<?php require_once "controller.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/page.css">
    <?php include 'head.html'; ?>
    <script src="js/ShowPSW.js"></script>

    <script>
            function removeFavorite(idEvento){
                showNotificationRemove();
                var numIdEvento = parseInt(idEvento);
                console.log(numIdEvento);
                document.cookie =  "idevent=" + numIdEvento;
                sendAjaxRequest('removeFavourite.php');
            }

            function sendAjaxRequest(urlToSend) {
                $.ajax({
                    type: "POST",
                    url: urlToSend
                });
            }
    </script>

</head>

<body>

    <?php include 'code.html'; ?>

        <div class="main-container">


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
        <?php } else {
            $conn = mysqli_connect('localhost', 'root', '', 'sagre');
            $sql = "SELECT nomeUtente FROM utenti WHERE email='" . $_SESSION['email'] . "'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo "Ciao " . $row['nomeUtente'] . "<br> Lista preferiti <br>";?>

            <table class="mdc-data-table__table" aria-label="Prossimi eventi">
                <thead>
                    <tr class="mdc-data-table__header-row">
                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col" width="60px"></th>
                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">EVENTI PREFERITI</th>
                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">DESCRIZIONE</th>
                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col"><span class='material-symbols-outlined'>schedule</span>INIZIO</th>
                    </tr>
                </thead>

                <tbody class="mdc-data-table__content">

            <?php
                $sql = "select DISTINCT evento.denom, idEvento, CAST(evento.data_inizio AS date)  as data_inizio from preferiti inner join evento on evento.id = preferiti.idEvento where preferiti.idUtente =".$_SESSION['id'];
              
                $prossimiEventi = $conn->query($sql) or die($conn->error);
            
                while ($datiEventi = $prossimiEventi->fetch_assoc()) {?>
              
                  <tr class='mdc-data-table__row' aria-label="Prossimi eventi">
                    <td class='mdc-data-table__cell mdc-data-table__cell--numeric'>
                      <md-icon-button id='favourite' onclick="removeFavorite('<?php echo $datiEventi['idEvento']?>')" >
                        <span class='material-symbols-outlined'>
                          favorite
                        </span>
                      </md-icon-button>
                    </td>
            <?php  
                  echo "
                    <td class='mdc-data-table__cell'><a href='infoEvento.php?idEvento=" . $datiEventi['idEvento'] . "' target='_blank' ><md-text-button>" . $datiEventi["denom"] . "</md-text-button></a></td>
                    <td class='mdc-data-table__cell'> </td>
                    <td class='mdc-data-table__cell'>" . $datiEventi['data_inizio'] . "</td>
                  </tr>";
                }
            ?>
                </tbody>;
            </table>
            


             

            

        <?php } ?>
    </div>


    <script>
        // set active
        var active = document.getElementById('sidebar_login');
        active.classList.add('active');
    </script>



</body>

</html>