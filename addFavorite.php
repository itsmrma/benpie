<?php
    session_start();
    $conn = new mysqli("localhost","root","","sagre");
    
    if ($conn -> connect_error) {
        die("Errore di connessione ". $conn->connect_errno ." ".$conn->connect_error);
    }

    $sql = "select idUtente  from utenti where email=".$_SESSION["email"];
    
    $result = $conn -> query($sql);
    $array=$coordResult->fetch_assoc();
    $idUtente=$array['idUtente'];

    $sql = "insert into utenti (idUtente, idEvento) values (".$idUtente.",".$_SESSION["idEvento"].")";
    $result = $conn -> query($sql);
    
?>
