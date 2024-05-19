<?php
    

    session_start();
        
    $conn = new mysqli("localhost","root","","sagre");

    if ($conn -> connect_error) {
        die("Errore di connessione ". $conn->connect_errno ." ".$conn->connect_error);
    }
    $testo =  $_POST["testo"];

    $date = date('Y-m-d\TH:i:sP');
    $sql = "insert into commento (testo, dataOraPubblicazione, idUtente, idEvento, idCommentoPadre) values ('".$testo."','".$date."',".$_SESSION["id"].",".$_SESSION["idEvento"].",".$_POST["idPadre"].")";

    $result = $conn -> query($sql);

    $sql = "select id from commento where dataOraPubblicazione ='".$date."' and idUtente = ".$_SESSION["id"];

    $result = $conn -> query($sql);
    $dati = $result->fetch_assoc();
    
    echo  $dati["id"].";". $date;

    
?>
