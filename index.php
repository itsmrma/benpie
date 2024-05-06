<!DOCTYPE html>
<html lang="en">

    <head>
      <?php include 'head.html';?>
        
    </head>

    <body>
      
      <?php include 'code.html';?>

      <div class="main-container">
        
        <md-list style="max-width: 300px; max-height: 300px">
          <md-list-item>
            Cat
            <img slot="start" style="width: 56px" src="https://placekitten.com/112/112">
          </md-list-item>
          <md-divider></md-divider>
          <md-list-item>
            Kitty Cat
            <img slot="start" style="width: 56px" src="https://placekitten.com/114/114">
          </md-list-item>
          <md-divider></md-divider>
          <md-list-item>
            Cate
            <img slot="start" style="width: 56px" src="https://placekitten.com/116/116">
          </md-list-item>
        </md-list>

      </div>

      <script>
        // set active
        var active = document.getElementById('sidebar_home');
        active.classList.add('active');
      </script>

    </body>

</html>