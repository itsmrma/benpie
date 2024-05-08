<?php
session_start();

$query = "SELECT evento.denom, evento.id FROM evento INNER JOIN comune ON comune.id=evento.id_comune ";

//print($_POST['query']);

print_r($_GET);

$query .= " ORDER BY denom DESC";

$_SESSION['query']=$query;

$conn = mysqli_connect('localhost', 'root', '', 'sagre');

$result = $conn->query($_SESSION['query']);

foreach ($result->fetch_all(MYSQLI_ASSOC) as $row) {
    echo "<a target='_blank' href='infoEvento.php' onclick='setCookie(" . $row['id'] . ")'>" . $row['denom'] . "</a><br>";
}