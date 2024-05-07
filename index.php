<!DOCTYPE html>
<html lang="en">

    <head>
      <?php include 'head.html';?>

    </head>

    <body>
      
      <?php include 'code.html';?>

      <div class="main-container">
        


        <md-list style="max-width: 300px;">

          <?php 

            $currentDate = date('Y-m-d');
            $conn = new mysqli("localhost","root","","sagre");

            if ($conn -> connect_error) {
              die("Errore di connessione ".$conn->connect_errno." ".$conn->connect_error);
            }

            $sql = "select id, denom from evento where evento.data_inizio>='".$currentDate."'order by evento.data_inizio asc limit 10";
            
            $prossimiEventi = $conn ->query($sql);

            while($datiEventi = $prossimiEventi->fetch_assoc()){
             
                echo "
                <md-list-item>
                <a href='infoEvento.php?idEvento=".$datiEventi["id"]."' target='_blank'  ciao='employeeLink'>".$datiEventi["denom"]."</a>
                <img slot='start' style='width: 56px' >
                </md-list-item>
                ";

            }

          ?>

        </md-list>



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