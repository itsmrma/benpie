<!doctype html>
<html lang="en">
  <head>

    <style>
      .map {
        height: 600px;
        width: 60%;
        
        margin-left: auto;
        margin-right: auto;
      }
    </style>


    <?php include 'head.html';?>
  </head>


  <body>
    <?php include 'code.html';?>

    
    <div class="main-container">
        
        <div id="map" class="map"><div id="popup"></div></div>
    </div>

    <?php 
        
        $conn = new mysqli("localhost","root","","sagre");
			
        if ($conn -> connect_error) {
          die("Errore di connessione ".$conn->connect_errno." ".$conn->connect_error);
        }
        
        $sql = "select geo_x, geo_y, denom, id from evento";
        

        $coordResult = $conn ->query($sql);

        
    ?> 
    
    <script>
      // set active
      var active = document.getElementById('sidebar_map');
      active.classList.add('active');
    </script>



  </body>
</html>