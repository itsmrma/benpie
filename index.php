<!DOCTYPE html>
<html lang="en">

    <head>
      <?php include 'head.html';?>
      <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
      <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
      <script src="js/snackbar.js" defer></script>
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
      <style>
        .mdc-data-table{
          width: 50%;
          margin:auto;
        }

      </style>
    </head>

    <body>
      
      <?php include 'code.html';?>

      

    <div class="main-container">
      
      <div class="mdc-data-table">
        <div class="mdc-data-table__table-container" >
          <table class="mdc-data-table__table" aria-label="Prossimi eventi">
            <thead>
              <tr class="mdc-data-table__header-row">
                <th class="mdc-data-table__header-cell" role="columnheader" scope="col">PROSSIMI EVENTI</th>
                <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric" role="columnheader" scope="col"><span class='material-symbols-outlined'>schedule</span>INIZIO</th>
              </tr>
            </thead>

            <tbody class="mdc-data-table__content">
              <?php 

                $currentDate = date('Y-m-d');
                $conn = new mysqli("localhost","root","","sagre");

                if ($conn -> connect_error) {
                  die("Errore di connessione ".$conn->connect_errno." ".$conn->connect_error);
                }

                $sql = "select id, denom, CAST(evento.data_inizio AS date) as data_inizio from evento where evento.data_inizio>='".$currentDate."'order by evento.data_inizio asc limit 10";

                $prossimiEventi = $conn ->query($sql);

                while($datiEventi = $prossimiEventi->fetch_assoc()){
                  echo "
                  <tr class='mdc-data-table__row'>
                    <th class='mdc-data-table__cell' scope='row'><a href='infoEvento.php?idEvento=".$datiEventi['id']."' target='_blank' ><md-text-button>".$datiEventi["denom"]."</md-text-button></a></th>
                    <td class='mdc-data-table__cell mdc-data-table__cell--numeric'>".$datiEventi['data_inizio']."</td>
                    
                  </tr>";
                }

              ?>


            </tbody>
          </table>
        </div>
      </div>
  
      





    </div>
    <div id="snackbar"></div>

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