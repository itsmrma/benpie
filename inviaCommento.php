<?php
    
    if(!strlen($_COOKIE["testo"])){
        return;
    }

    session_start();
        
    $conn = new mysqli("localhost","root","","sagre");

    if ($conn -> connect_error) {
        die("Errore di connessione ". $conn->connect_errno ." ".$conn->connect_error);
    }
    $testo = str_replace("&", "\n", $_COOKIE["testo"]);
    $date = date('Y-m-d\TH:i:sP');
    $sql = "insert into commento(testo, dataOraPubblicazione, idUtente, idEvento, idCommentoPadre) values ('".$testo."','".$date."',".$_SESSION["id"].",".$_SESSION["idEvento"].",".$_COOKIE["idCommentoPadre"].")";

    $result = $conn -> query($sql);

    

?>