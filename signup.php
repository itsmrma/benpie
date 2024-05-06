<?php require_once "controller.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Signup Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/page.css">
    <script src="js/checkPSW.js" defer></script>
    <?php include 'head.html'; ?>
</head>

<body>
    <?php include 'code.html'; ?>
    <div class="main-container">
        <div class="main">
            <div class="section flex-center-y">
                <div class="rounded-inner">
                    <form class="basic-form" action="signup.php" method="POST" autocomplete="">
                    <h1 class="firstTitle flex-center-x">Signup</h1>

                        <?php
                        if (count($errors) == 1) {
                            ?>
                            <div class="alert alert-danger text-center">
                                <?php
                                foreach ($errors as $showerror) {
                                    echo $showerror;
                                }
                                ?>
                            </div>
                            <?php
                        } else if (count($errors) > 1) {
                            ?>
                                <div class="alert alert-danger">
                                    <?php
                                    foreach ($errors as $showerror) {
                                        ?>
                                        <li><?php echo $showerror; ?></li>
                                    <?php
                                    }
                                    ?>
                                </div>
                            <?php
                        }
                        ?>
                        <div class="input-container">
                            <div class="material-textfield">
                                <input placeholder="" type="text" required name="nomeUtente">
                                <label>username</label>
                            </div>
                        </div>
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
                            </div>
                        </div>
                        <div class="input-container">
                            <!-- <div class="material-textfield">
                                <input placeholder="" type="password" required name="cpassword" id="cpassword">
                                <label>Conferma Password</label>
                            </div> -->
                            <md-outlined-text-field type="password" label="Conferma Password" name="cpassword" id="cpassword">

                            </md-outlined-text-field>
                        <br>
                            
                        </div>
                        <p class="firstSubtitle">Hai già un account?<a href="login.php" class="link"> Accedi</a>
                            </p>
                        <button class="btn filled submit-btn" type="submit" name="signup" value="signup">Registrati</a>
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