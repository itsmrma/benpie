<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "sagre";

$conn = new mysqli($host, $user, $pass, $db);

$url = "https://www.dati.lombardia.it/resource/hs8z-dcey.json";
$filename = basename($url);

if (file_exists($filename)) {
    $data = file_get_contents($url);
    $json = json_decode($data, true);

    $i=0;
    $count=0;
    $nomi = array();

    foreach ($json as $row) {
        if ($count==0) {
            foreach($row as $key => $value) {
              if ($key!="location" && $key!=":@computed_region_ttgh_9sm5" && $key!=":@computed_region_af5v_nc64") {
                $nomi[$i++] = $key;
              }
              
            }
            $count++;
        }
    }

    for ($i=0; $i<count($json); $i++) {
        // gestione province
        if (isset($json[$i]['prov'])) {

        } else {

        }


        // gestione comuni
        if (isset($json[$i]['cap'])) {
            $query_com = "SELECT id FROM comune WHERE cap = '" . $json[$i]['cap'] . "'";
            $result = $conn->query($query_com);
            if ($result->num_rows==0) {
                $query_com = "INSERT INTO `comune` (`id`, `nome`, `cap`, `id_prov`) VALUES (NULL, NULL, NULL, '') ";
            } else {

            }
        } else {

        }
        

        // gestione tipi
        if (isset($json[$i]['tipo'])) {

        } else {

        }

        // gestione toponimi
        if (isset($json[$i]['toponimo'])) {

        } else {

        }

        $query = "INSERT INTO `evento` (`id`, `denom`, `id_tipo`, `n_ediz`, `descrizione`, `data_inizio`, `ora_inizio`, `data_fine`, `ora_fine`, `anno`, `istat`, `id_comune`, `id_toponimo`, `civico`, `nome_org`, `url`, `geo_x`, `geo_y`) VALUES (NULL";

        for ($j=1; $j<count($nomi); $j++) {

            if (isset($json[$i][$nomi[$j]])) {
                $query .= ", '" . str_replace("'", " ", $json[$i][$nomi[$j]]) . "'";
            } else {
                $query .= ", 'NULL'";
            }
        }

        $query .= ")";

        print($query . "<br><br><br>");

        $conn->query($query);
    }

}
    

?>