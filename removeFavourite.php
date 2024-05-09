<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "sagre");

    if ($conn->connect_error) {
        die("Errore di connessione " . $conn->connect_errno . " " . $conn->connect_error);
    }
    
    $sql = "delete from preferiti where preferiti.idUtente= ".$_SESSION["id"]." and preferiti.idEvento= ".$_COOKIE["idevent"];
    
    $result = $conn->query($sql) or die($conn->error);
    

?>