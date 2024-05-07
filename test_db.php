<?php
//error_reporting(0);
$host = "localhost";
$user = "root";
$pass = "";
$db = "sagre";

$conn = new mysqli($host, $user, $pass, $db);


$data = file_get_contents('https://www.dati.lombardia.it/resource/hs8z-dcey.json?$limit=2544');
$json = json_decode($data, true);

$i = 0;
$count = 0;
$nomi = array();

$id_prov = 0;
$id_com = 0;
$id_tipo = 0;
$id_toponimo = 0;

foreach ($json as $row) {
    if ($count == 0) {
        foreach ($row as $key => $value) {
            if ($key != "location" && $key != ":@computed_region_ttgh_9sm5" && $key != ":@computed_region_af5v_nc64" && $key != "comune" && $key != "prov" && $key != "toponimo" && $key != "tipo" && $key != "cap" && $key != "indirizzo" && $key != "somminis" && $key != "gen_automatica_programma") {
                $nomi[$i++] = $key;
            }

        }
        $count++;
    }
}


for ($i = 0; $i < count($json); $i++) {
    // gestione province
    if (isset($json[$i]['prov'])) {
        $query_prov = "SELECT id FROM provincia WHERE nome='" . $json[$i]['prov'] . "'";

        $result = $conn->query($query_prov);
        if ($result->num_rows == 0) {

            $query_prov = "INSERT INTO `provincia` (`id`, `nome`) VALUES (NULL, '" . $json[$i]['prov'] . "')";
            $conn->query($query_prov);
            $query_prov = "SELECT id FROM provincia WHERE nome='" . $json[$i]['prov'] . "'";
            $result = $conn->query($query_prov);

            foreach ($result->fetch_all(MYSQLI_ASSOC) as $prov_row) {
                foreach ($prov_row as $key => $value) {
                    if ($key == "id") {
                        $id_prov = $value;
                    }
                }
            }

        } else {
            $query_prov = "SELECT id FROM provincia WHERE nome='" . $json[$i]['prov'] . "'";
            $result = $conn->query($query_prov);

            foreach ($result->fetch_all(MYSQLI_ASSOC) as $prov_row) {
                foreach ($prov_row as $key => $value) {
                    if ($key == "id") {
                        $id_prov = $value;
                    }
                }
            }
        }
    } else {
        $id_prov = 1;
    }


    // gestione comuni
    if (isset($json[$i]['cap'])) {
        $query_com = "SELECT id FROM comune WHERE cap = '" . $json[$i]['cap'] . "'";
        $result = $conn->query($query_com);
        if ($result->num_rows == 0) {
            $query_com = "INSERT INTO `comune` (`id`, `nome`, `cap`, `id_prov`) VALUES (NULL, '" . $json[$i]['comune'] . "', '" . $json[$i]['cap'] . "', '" . $id_prov . "')";
            $conn->query($query_com);
            $query_com = "SELECT id FROM comune WHERE cap='" . $json[$i]['cap'] . "'";
            $result = $conn->query($query_com);
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $com_row) {
                foreach ($com_row as $key => $value) {
                    if ($key == "id") {
                        $id_com = $value;
                    }
                }
            }
        } else {
            $query_com = "SELECT id FROM comune WHERE cap='" . $json[$i]['cap'] . "'";
            $result = $conn->query($query_com);
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $com_row) {
                foreach ($com_row as $key => $value) {
                    if ($key == "id") {
                        $id_com = $value;
                    }
                }
            }
        }

    } else {
        $id_com = 1;
    }


    // gestione tipi
    if (isset($json[$i]['tipo'])) {
        $query_tipo = "SELECT id FROM tipo WHERE nome = '" . $json[$i]['tipo'] . "'";
        $result = $conn->query($query_tipo);
        if ($result->num_rows == 0) {
            $query_tipo = "INSERT INTO `tipo` (`id`, `nome`) VALUES (NULL, '" . $json[$i]['tipo'] . "')";
            $conn->query($query_tipo);
            $query_tipo = "SELECT id FROM tipo WHERE nome='" . $json[$i]['tipo'] . "'";
            $result = $conn->query($query_tipo);
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $tipo_row) {
                foreach ($tipo_row as $key => $value) {
                    if ($key == "id") {
                        $id_tipo = $value;
                    }
                }
            }
        } else {
            $query_tipo = "SELECT id FROM tipo WHERE nome='" . $json[$i]['tipo'] . "'";
            $result = $conn->query($query_tipo);
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $tipo_row) {
                foreach ($tipo_row as $key => $value) {
                    if ($key == "id") {
                        $id_tipo = $value;
                    }
                }
            }
        }
    } else {
        $id_tipo = 1;
    }

    // gestione toponimi
    if (isset($json[$i]['toponimo'])) {
        $query_topon = "SELECT id FROM toponimo WHERE nome = \"" . $json[$i]['toponimo'] . "\"";
        $result = $conn->query($query_topon);
        if ($result->num_rows == 0) {
            $query_topon = "INSERT INTO `toponimo` (`id`, `nome`) VALUES (NULL, \"" . $json[$i]['toponimo'] . "\")";
            $conn->query($query_topon);
            $query_topon = "SELECT id FROM toponimo WHERE nome=\"" . $json[$i]['toponimo'] . "\"";
            $result = $conn->query($query_topon);
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $topon_row) {
                foreach ($topon_row as $key => $value) {
                    if ($key == "id") {
                        $id_toponimo = $value;
                    }
                }
            }
        } else {
            $query_topon = "SELECT id FROM toponimo WHERE nome=\"" . $json[$i]['toponimo'] . "\"";
            $result = $conn->query($query_topon);
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $topon_row) {
                foreach ($topon_row as $key => $value) {
                    if ($key == "id") {
                        $id_toponimo = $value;
                    }
                }
            }
        }
    } else {
        $id_toponimo = 1;
    }

    $query = "SELECT url FROM evento WHERE url='" . $json[$i]['url_programma']['url'] . "'";
    $sel_res = $conn->query($query);
    if ($sel_res->num_rows == 0) {
        $query = "INSERT INTO `evento` (`id`, `denom`, `id_tipo`, `n_ediz`, `descrizione`, `data_inizio`, `ora_inizio`, `data_fine`, `ora_fine`, `anno`, `istat`, `id_comune`, `id_toponimo`, `civico`, `nome_org`, `url`, `geo_x`, `geo_y`) VALUES (NULL";

        for ($j = 1; $j < count($nomi); $j++) {

            if ($nomi[$j] == "civico") {
                $query .= ", '" . $id_com . "'";
            }

            if ($nomi[$j] == "civico") {
                $query .= ", '" . $id_toponimo . "'";
            }

            if ($nomi[$j] == "n_ediz") {
                $query .= ", '" . $id_tipo . "'";
            }

            if (isset($json[$i][$nomi[$j]])) {
                if ($nomi[$j] == "url_programma") {
                    $query .= ", '" . $json[$i][$nomi[$j]]['url'] . "'";
                } else {
                    $query .= ", '" . $json[$i][$nomi[$j]] . "'";
                }

            } else {
                $query .= ", NULL";
            }
        }

        $query .= ")";

        $abc = $conn->query($query);
        if ($abc->num_rows == 0) {
            echo "Errore query " . $query;
        }
    } else {
        //print("Fiera " . $json[$i]['denom'] . " già presente <br>");
    }


}


#header("location: ./index.php");

$conn->close();

$dataOraCorrente = date("Y-m-d H:i:s");

$percorsoFile = "date.txt";

$file = fopen($percorsoFile, "w");

fwrite($file, $dataOraCorrente);

fclose($file);