<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "sagre";

$conn = new mysqli($host, $user, $pass, $db);

$insert = "CREATE TABLE `sagre`.`main` ( `id` INT NOT NULL AUTO_INCREMENT , `denom` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";

$url = "https://www.dati.lombardia.it/resource/hs8z-dcey.json";
$filename = basename($url);
file_put_contents($filename, file_get_contents($url));

if (file_exists($filename)) {
    $data = file_get_contents($filename);
    $json = json_decode($data);

    $count=0;

    $nomi = array();

    foreach ($json as $row) {
        foreach($row as $key => $value) {
            if ($key!="location") {
                $nomi[$i++] = $key;
            }
        }
    }

}

?>