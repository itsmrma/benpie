<!DOCTYPE html>
<html lang="en">

    <head>
      <meta name="viewport" content="width=device-width, initial-scale=0.75">
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/95ae55bd9a.js" crossorigin="anonymous"></script>
        <!-- Material Icon -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <script type="importmap">
          {
            "imports": {
              "@material/web/": "https://esm.run/@material/web/"
            }
          }
        </script>
        <script type="module">
          import '@material/web/all.js';
          import {styles as typescaleStyles} from '@material/web/typography/md-typescale-styles.js';
      
          document.adoptedStyleSheets.push(typescaleStyles.styleSheet);
        </script>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/dark.css" id="themeCSS">
        <script src="js/index.js"></script>
        <script src="js/changeTheme.js"></script>
        
      </head>

      <body>
        
        <?php include 'code.html';?>
        

        <div class="main-container">
          <?php include 'test_db.php';?>
        </div>

        <script>
          // set active
          var active = document.getElementById('sidebar_update');
          active.classList.add('active');
        </script>

       </body>

</html>