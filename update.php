<!DOCTYPE html>
<html lang="en">

    <head>
      <?php include 'head.html';?>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script>
      $(document).ready(function() {
          // Questa funzione verrà eseguita dopo il caricamento completo della pagina
          $.ajax({
              url: 'test_db.php',
              type: 'GET',
              dataType: 'html',
              success: function(response) {
                  // Gestisci la risposta qui
                  console.log(response);
                  window.location.replace("index.php");
              },
              error: function(xhr, status, error) {
                  // Gestione degli errori qui
                  console.error(error);
              }
          });
      });
      </script>
        
      <link rel="stylesheet" href="css/loading.css">
      </head>

      <body>
        
        <?php include 'code.html';?>

        <script>
          // set active
          var active = document.getElementById('sidebar_update');
          active.classList.add('active');
        </script>

        <div class="main-container">
          <p>
            Dati in aggiornamento. Si prega di attendere... <br>
            Al termine verrete reindirizzati alla home page. <br>
            <div class="wrapper">
              <div class="blue ball"></div>
              <div class="red ball"></div>  
              <div class="yellow ball"></div>  
              <div class="green ball"></div>
            </div>
          </p>
          
            
        </div>

        

       </body>

</html>