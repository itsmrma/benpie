<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'head.html'; ?>
  <style>
    .mdc-data-table {
      width: 50%;
      position:absolute;
      bottom:0;
      height: 80%;
    }
    
    div::-webkit-scrollbar
    {
    height:7px;

    }
    div::-webkit-scrollbar-track
    {
        border-radius: 10px;

        webkit-box-shadow: inset 0 0 6px rgba(255,255,255,255);
    }
    div::-webkit-scrollbar-thumb
    {
        background-color: a6c53b;


        webkit-box-shadow: inset 0 0 6px rgba(255,255,255,255);
    }
  </style>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <script>
    function removeFavorite(idEvento){
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

  <script src="js/snackbar.js"></script>

</head>

<body>

  <?php include 'code.html'; ?>

  <div class="main-container">

    <div class="mdc-data-table">
      <div class="mdc-data-table__table-container">
        <table class="mdc-data-table__table" aria-label="Prossimi eventi">
          <thead>
            <tr class="mdc-data-table__header-row">
              <th class="mdc-data-table__header-cell" role="columnheader" scope="col" width="60px"></th>
              <th class="mdc-data-table__header-cell" role="columnheader" scope="col">PROSSIMI EVENTI</th>
              <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric" role="columnheader"
                scope="col"><span class='material-symbols-outlined'>schedule</span>INIZIO</th>
            </tr>
          </thead>

          <tbody class="mdc-data-table__content">
            <?php
            
            $currentDate = date('Y-m-d');
            $conn = new mysqli("localhost", "root", "", "sagre");

            if ($conn->connect_error) {
              die("Errore di connessione " . $conn->connect_errno . " " . $conn->connect_error);
            }
            
            if(isset($_SESSION["email"],$_SESSION["id"])){
              
              $sql = "select DISTINCT evento.denom, idEvento, CAST(evento.data_inizio AS date)  as data_inizio from preferiti inner join evento on evento.id = preferiti.idEvento where preferiti.idUtente =".$_SESSION['id'];
              
              $prossimiEventi = $conn->query($sql) or die($conn->error);
              
              while ($datiEventi = $prossimiEventi->fetch_assoc()) {?>
                
                    <tr class='mdc-data-table__row'>
                      <td class='mdc-data-table__cell mdc-data-table__cell--numeric'>
                        <md-icon-button id='favourite' onclick="removeFavorite('<?php echo $datiEventi['idEvento']?>')" >
                          <span class='material-symbols-outlined'>
                            favorite
                          </span>
                        </md-icon-button>
                      </td>
              <?php  
                    echo "
                      <th class='mdc-data-table__cell' scope='row'><a href='infoEvento.php?idEvento=" . $datiEventi['idEvento'] . "' target='_blank' ><md-text-button>" . $datiEventi["denom"] . "</md-text-button></a></th>
                      <td class='mdc-data-table__cell mdc-data-table__cell--numeric'>" . $datiEventi['data_inizio'] . "</td>
                    </tr>";
              }
            }
            
            $sql = "select id, denom, CAST(evento.data_inizio AS date) as data_inizio from evento where evento.data_inizio>='" . $currentDate . "'order by evento.data_inizio asc limit 10";

            $prossimiEventi = $conn->query($sql);

            while ($datiEventi = $prossimiEventi->fetch_assoc()) {

              echo "
                  <tr class='mdc-data-table__row'>
                    <td class='mdc-data-table__cell mdc-data-table__cell--numeric'></td>
                    <th class='mdc-data-table__cell' scope='row'><a href='infoEvento.php?idEvento=" . $datiEventi['id'] . "' target='_blank' ><md-text-button>" . $datiEventi["denom"] . "</md-text-button></a></th>
                    <td class='mdc-data-table__cell mdc-data-table__cell--numeric'>" . $datiEventi['data_inizio'] . "</td>
                  
                  </tr>";

            }

            ?>


          </tbody>
        </table>
      </div>
    </div>


  </div>



  <script>
    // set active
    var active = document.getElementById('sidebar_home');
    active.classList.add('active');
  </script>

  <script>
    infoEventi = <?php echo json_encode($prossimiEventi); ?>; 
  </script>

</body>

</html>