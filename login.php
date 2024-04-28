<?php require_once "controller.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

    <?php include 'head.html';?>
</head>

<body>

    <?php include 'code.html';?>

    <div class="main-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 offset-md-4 form login-form">
                        <form action="login.php" method="POST" autocomplete="">
                            <h2 class="text-center">Login</h2>
                            <?php
                            if(count($errors) > 0){
                                ?>
                                <div class="alert alert-danger text-center">
                                    <?php
                                    foreach($errors as $showerror){
                                        echo $showerror;
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="Email Address" required value="<?php echo $email ?>">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" name="password" placeholder="Password" required>
                            </div>
                            
                            <div class="form-group">
                                <input class="form-control button" type="submit" name="login" value="Login">
                            </div>
                            <div class="link login-link text-center">Non sei registrato? <a href="signup.php">Registrati ora</a></div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    
    <script>
      // set active
      var active = document.getElementById('sidebar_login');
      active.classList.add('active');
    </script>


</body>
</html>