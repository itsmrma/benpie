<?php session_start(); 
$ids = array();
$count=0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'head.html'; ?>
  <style>
       
    .main-container {
    	height: max-content;
    }

  </style>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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
            M.Toast.dismissAll();
            switch(aggiuntoRimosso){
                case "aggiunto":
                    M.toast({ html: "Evento aggiunto ai preferiti.", ...options });
                break;
                case "rimosso":
                    M.toast({ html: "Evento rimosso dai preferiti.", ...options });
                break;
            }
    }

  </script>

  <script src="js/checkDate.js"></script>

</head>

<body>

  <?php include 'code.html'; ?>

  <div class="main-container">

    <h1 style="font-size: 40px;">🎟️ PORTALE DELLE FIERE DELLA LOMBARDIA 🎟️</h1>
    <div class="mdc-data-table">
      <div class="mdc-data-table__table-container">
        <table class="mdc-data-table__table" aria-label="Prossimi eventi">
          <thead>
            <tr class="mdc-data-table__header-row">
              <th class="mdc-data-table__header-cell" role="columnheader" scope="col" width="60px"></th>
              <th class="mdc-data-table__header-cell" role="columnheader" scope="col">PROSSIMI EVENTI</th>
              <th class="mdc-data-table__header-cell" role="columnheader" scope="col">DESCRIZIONE</th>
              <th class="mdc-data-table__header-cell" role="columnheader" scope="col"><span class='material-symbols-outlined'>schedule</span>INIZIO</th>
              <th class="mdc-data-table__header-cell" role="columnheader" scope="col"><span class='material-symbols-outlined'>schedule</span>FINE</th>
            </tr>
          </thead>

          <tbody class="mdc-data-table__content">
            <?php
            
            $currentDate = date('Y-m-d');
            $conn = new mysqli("localhost", "root", "", "sagre");

            if ($conn->connect_error) {
              die("Errore di connessione " . $conn->connect_errno . " " . $conn->connect_error);
            }
            
            if(isset($_SESSION["email"], $_SESSION["id"])){
              
              $sql = "select DISTINCT evento.denom, idEvento, CAST(evento.data_inizio AS date)  as data_inizio, CAST(evento.data_fine AS date)  as data_fine,descrizione from preferiti inner join evento on evento.id = preferiti.idEvento where preferiti.idUtente =".$_SESSION['id'];
              
              $prossimiEventi = $conn->query($sql) or die($conn->error);
              $idEventiPreferiti ="(";
              while ($datiEventi = $prossimiEventi->fetch_assoc()) {
                $idEventiPreferiti.= $datiEventi['idEvento'].",";
                ?>

                    <tr class='mdc-data-table__row'>
                      <td class='mdc-data-table__cell mdc-data-table__cell--numeric'>
                        <md-icon-button id="favourite" onclick="addRemoveFavorite('<?php $ids[$count]="fav".$count; echo $ids[$count] . "', '" . $datiEventi['idEvento'];?>')" >
                          <span class='material-symbols-outlined' id='<?php echo $ids[$count++]; ?>' style="color: red">
                            favorite
                          </span>
                        </md-icon-button>
                      </td>
              <?php  
                    echo "
                      <td class='mdc-data-table__cell'><a href='infoEvento.php?idEvento=" . $datiEventi['idEvento'] . "' target='_blank' ><md-text-button>" . $datiEventi["denom"] . "</md-text-button></a></td>
                      <td class='mdc-data-table__cell'><marquee behavior='scroll' direction='left'>".$datiEventi['descrizione']."</marquee></td>
                      <td class='mdc-data-table__cell'>" . $datiEventi['data_inizio'] . "</td>
                      <td class='mdc-data-table__cell'>" . $datiEventi['data_fine'] . "</td>
                    </tr>";
              }
            }else{
              $idEventiPreferiti = "(-1)";
            }
            
            if($idEventiPreferiti=="("){
              $idEventiPreferiti = "(-1)";
            }else{
              $idEventiPreferiti[strlen($idEventiPreferiti)-1] = ")";
            }
           
            $sql = "select descrizione, id, denom, CAST(evento.data_inizio AS date) as data_inizio, CAST(evento.data_fine AS date) as data_fine from evento where evento.id not in ".$idEventiPreferiti." and '". $currentDate. "' between evento.data_inizio and evento.data_fine order by evento.data_fine asc";
        
            $prossimiEventi = $conn->query($sql);

            while ($datiEventi = $prossimiEventi->fetch_assoc()) {

              echo "
                  <tr class='mdc-data-table__row'>
                    <td class='mdc-data-table__cell'></td>
                    <td class='mdc-data-table__cell'><a href='infoEvento.php?idEvento=" . $datiEventi['id'] . "' target='_blank' ><md-text-button>" . $datiEventi["denom"] . "</md-text-button></a></td>
                    <td class='mdc-data-table__cell' ><marquee behavior='scroll' direction='left'>".$datiEventi['descrizione']."</marquee></td>
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