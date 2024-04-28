<?php require_once "controller.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

    <?php include 'head.html';?>
</head>
<body>
    <?php include 'code.html';?>
    <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4 form">
                    <form action="signup.php" method="POST" autocomplete="">
                        <h2 class="text-center">Signup</h2>
                        
                        <?php
                        if(count($errors) == 1){
                            ?>
                            <div class="alert alert-danger text-center">
                                <?php
                                foreach($errors as $showerror){
                                    echo $showerror;
                                }
                                ?>
                            </div>
                            <?php
                        }elseif(count($errors) > 1){
                            ?>
                            <div class="alert alert-danger">
                                <?php
                                foreach($errors as $showerror){
                                    ?>
                                    <li><?php echo $showerror; ?></li>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="form-group">
                            <input class="form-control" type="text" name="nomeUtente" placeholder="username" required value="<?php echo $name ?>">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="email" name="email" placeholder="Email Address" required value="<?php echo $email ?>">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="cpassword" placeholder="Confirm password" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control button" type="submit" name="signup" value="Signup">
                        </div>
                        <div class="link login-link text-center">Sei già registrato? <a href="login.php">Accedi</a></div>
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