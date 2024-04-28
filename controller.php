<?php 
    session_start();
    $con = mysqli_connect('localhost', 'root', '', 'sagre');
    $email = "";
    $name = "";
    $errors = array();

    //if user signup button
    if(isset($_POST['signup'])){
        $name = mysqli_real_escape_string($con, $_POST['nomeUtente']);
        $email =  mysqli_real_escape_string($con,$_POST['email']);
        $password =  mysqli_real_escape_string($con,$_POST['password']);
        $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
        if($password !== $cpassword){
            $errors['password'] = "Le password non corrispondo!";
        }
        $email_check = "SELECT * FROM utenti WHERE email = '$email'";
        $res = mysqli_query($con, $email_check);
        if(mysqli_num_rows($res) > 0){
            $errors['email'] = "L'email inserita è già associata ad un utente";
        }
        if(count($errors) === 0){
            $encpass = password_hash($password, PASSWORD_BCRYPT);
            $insert_data = "INSERT INTO utenti (nomeUtente, email, password)
                            values('$name', '$email', '$encpass')";
            $data_check = mysqli_query($con, $insert_data);
            if(!$data_check){
                $errors['db-error'] = "Inserimento delle credenziali fallito";
            }
        }

    }


    //if user click login button
    if(isset($_POST['login'])){
        $email =  mysqli_real_escape_string($con,$_POST['email']);
        $password =  mysqli_real_escape_string($con,$_POST['password']);
        $check_email = "SELECT * FROM utenti WHERE email = '$email'";
        $res = mysqli_query($con, $check_email);
        if(mysqli_num_rows($res) > 0){
            $fetch = mysqli_fetch_assoc($res);
            $fetch_pass = $fetch['password'];
            if(password_verify($password, $fetch_pass)){
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: index.php');
            }else{
                $errors['email'] = "credenziali errate";
            }
        }else{
            $errors['email'] = "Non sei registrato";
        }
    }


    
   //if login now button click
    if(isset($_POST['login-now'])){
        header('Location: login.php');
    }
?>