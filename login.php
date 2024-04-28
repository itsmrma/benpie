<!doctype html>
<html lang="en">
  <head>
    <?php include 'head.html';?>
  </head>


  <body>

    <?php include 'code.html';?>

    
    <div class="main-container">
        <form method='post'>
          <br>Mail: <input type='text' name='email'>
          <?php 
            if(isset($_POST['mail'])){
              $conn = new mysqli("localhost","root","","sagre");
            
              if ($conn -> connect_error) {
                die("Errore di connessione ".$conn->connect_errno." ".$conn->connect_error);
              }
              
              $sql = "select email from utenti where email=".$_POST["email"];
              
              $result = $conn ->query($sql);
            }
          ?> 
          <input type='submit'>
        </form>
    </div>


    
    <script>
      // set active
      var active = document.getElementById('sidebar_map');
      active.classList.add('active');
    </script>



  </body>
</html>