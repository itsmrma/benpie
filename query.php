<?php
$query = "SELECT evento.denom, CAST(evento.data_inizio AS date) as data_inizio, CAST(evento.data_fine AS date) as data_fine, evento.id, comune.nome AS nCom, provincia.nome AS nProv FROM evento INNER JOIN comune INNER JOIN provincia ON comune.id=evento.id_comune AND provincia.id = comune.id_prov ";

$dati_json = file_get_contents("php://input");
$dati = json_decode($dati_json);

$query .= $dati->query;

include 'conn.php';

$result = $conn->query($query);

$s = "<div class='mdc-data-table'>
<div class='mdc-data-table__table-container'>
  <table class='mdc-data-table__table' aria-label='Prossimi eventi'>
    <thead>
    <tr class='mdc-data-table__header-row'>
        <th class='mdc-data-table__header-cell' role='columnheader' scope='col'><span class='material-symbols-outlined'>description</span>NOME EVENTO</th>
        <th class='mdc-data-table__header-cell' role='columnheader' scope='col'><span class='material-symbols-outlined'>schedule</span>INIZIO</th>
        <th class='mdc-data-table__header-cell' role='columnheader' scope='col'><span class='material-symbols-outlined'>schedule</span>FINE</th>
        <th class='mdc-data-table__header-cell' role='columnheader' scope='col'><span class='material-symbols-outlined'>location_on</span>LUOGO</th>
      </tr>
    </thead>
    <tbody class='mdc-data-table__content'>";
foreach ($result->fetch_all(MYSQLI_ASSOC) as $row) {
    $s.= "<tr class='mdc-data-table__row'>
        <td class='mdc-data-table__cell'><a href='infoEvento.php?idEvento=" . $row['id'] . "' target='_blank' ><md-text-button>" . $row["denom"] . "</md-text-button></a></td>
        <td class='mdc-data-table__cell'>" . $row['data_inizio'] . "</td>
        <td class='mdc-data-table__cell'>" . $row['data_fine'] . "</td>
        <td class='mdc-data-table__cell'>" . $row['nCom'] . " (" . $row['nProv'] . ") </td>
    </tr>";
}

$s.="</tbody>
</table>";

echo $s;