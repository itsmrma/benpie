<!DOCTYPE html>
<html lang="en">

    <head>
      <?php include 'head.html';?>
        
      </head>

      <body>
        
        <?php include 'code.html';?>

        <script>
          // set active
          var active = document.getElementById('sidebar_update');
          active.classList.add('active');
        </script>

        <div class="main-container">
          <?php include 'test_db.php';?>
        </div>

        

       </body>

</html>