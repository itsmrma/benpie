<?php
$query = "SELECT evento.denom, evento.id FROM evento INNER JOIN comune ON comune.id=evento.id_comune ";

$dati_json = file_get_contents("php://input");
$dati = json_decode($dati_json);

$query .= $dati->query;

$query .= " ORDER BY denom DESC";

$conn = mysqli_connect('localhost', 'root', '', 'sagre');

$result = $conn->query($query);

foreach ($result->fetch_all(MYSQLI_ASSOC) as $row) {
    echo "<a target='_blank' href='infoEvento.php?idEvento=" . $row['id'] . "'>" . $row['denom'] . "</a><br>";
}