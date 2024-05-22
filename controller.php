<?php
session_start();
include 'conn.php';
$email = "";
$name = "";
$errors = array();

if (isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($conn, $_POST['nomeUtente']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    if ($password !== $cpassword) {
        $errors['password'] = "Le password non corrispondono!";
    }
    $email_check = "SELECT * FROM utenti WHERE email = '$email'";
    $res = mysqli_query($conn, $email_check);
    if (mysqli_num_rows($res) > 0) {
        $errors['email'] = "L'email inserita è già associata ad un utente";
    }
    if (count($errors) === 0) {
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $insert_data = "INSERT INTO utenti (nomeUtente, email, password)
            values('$name', '$email', '$encpass')";
        $data_check = mysqli_query($conn, $insert_data);
        if (!$data_check) {
            $errors['db-error'] = "Inserimento delle credenziali su db fallito";
        }
        header('Location: login.php');
    }

}

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $check_email = "SELECT * FROM utenti WHERE email = '$email'";
    $res = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        $fetch_pass = $fetch['password'];
        $fetch_id = $fetch['idUtente'];
        if (password_verify($password, $fetch_pass)) {
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $_SESSION['id'] = $fetch_id;
            header('location: login.php');
        } else {
            $errors['email'] = "credenziali errate";
        }
    } else {
        $errors['email'] = "Non sei registrato";
    }
}

if (isset($_POST['login-now'])) {
    header('Location: login.php');
}

