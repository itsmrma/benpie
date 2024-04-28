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
          <br>Password: <input type='text' name='password'>
          <?php
            if(isset($_POST['mail'], $_POST['password'])){
              $conn = new mysqli("localhost","root","","sagre");
            
              if ($conn -> connect_error) {
                die("Errore di connessione ".$conn->connect_errno." ".$conn->connect_error);
              }

              $sql = "select email, password from utenti where email=".$_POST["email"];

              $result = $conn ->query($sql);
              $campi=$result->fetch_assoc();

              if(!isset($campi["email"])){
                echo "<br>Nome: <input type='text' name='nome'>
                <br>Cognome: <input type='text' name='cognome'>
                <br>Nome utente: <input type='text' name='userName'>";
                $password = $_POST['password'];
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "insert into utenti (utenti.nomeUtente, utenti.email, utenti.password, utenti.nome, utenti.cognome)
                values ()";

              }else if($_POST['email']==$campi["email"] && password_verify($_POST['password'],$campi["password"])){
                session_start();
                $_SESSION["utente"] = $campi;
                echo "login avvenuto con successo";
              }else{
                echo "<br>credenziali errate";
              }

            }
          ?> 
          <br><input type='submit' value="login">
        </form>
    </div>


    
    <script>
      // set active
      var active = document.getElementById('sidebar_login');
      active.classList.add('active');
    </script>



  </body>
</html>