<?php require_once "controller.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/page.css">
    <?php include 'head.html'; ?>
    <script src="js/ShowPSW.js"></script>

</head>

<body>

    <?php include 'code.html'; ?>

    <div class="main-container" style>

        <div class="main">

            <div class="section flex-center-y">
                <div class="rounded-inner">
                    <form class="basic-form" method="POST" action="login.php">
                        <h1 class="firstTitle flex-center-x">Accedi</h1>
                        <?php
                            if(count($errors) > 0){?>

                                <div class="alert alert-danger">
                                    <?php
                                    foreach ($errors as $showerror) {
                                        ?>
                                        <li><?php echo $showerror; ?></li>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <?php   }
                        ?>
                        <div class="input-container">
                            <div class="material-textfield">
                                <input placeholder="" type="email" required name="email">
                                <label>Email</label>
                            </div>
                        </div>
                        <div class="input-container">
                            <div class="material-textfield">
                                <input placeholder="" type="password" required name="password" id="password">
                                <label>Password</label>
                                <span id="PSWShowHideIcon" onclick="ShowPSW()"><i class="fa-solid fa-eye-slash"></i></span>
                            </div>
                            <br>
                            <p class="firstSubtitle">Non hai un account?<a href="signup.php" class="link"> Registrati</a>
                            </p>
                        </div>
                        <button class="btn filled submit-btn" type="submit" name="login" value="login">Accedi</a>
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