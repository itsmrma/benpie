<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "sagre";

$conn = new mysqli($host, $user, $pass, $db);

$url = "https://www.dati.lombardia.it/resource/hs8z-dcey.json";
$filename = basename($url);
file_put_contents($filename, file_get_contents($url));

if (file_exists($filename)) {
    $data = file_get_contents($filename);
    $json = json_decode($data);

    $count=0;

    $nomi = array();

    foreach ($json as $row) {
        if ($count==0) {
            foreach($row as $key => $value) {
              if ($key!="location") {
                $nomi[$i++] = $key;
              }
              
            }
            $count++;
        }

        
        $i=0;
        $insert = array();

        foreach ($row as $key => $value) {
            
            if ($key!="location") {
                if (is_object($value)) {
                    foreach ($value as $key2 => $value2) {
                        if (!is_object($value2)) {
                            $insert[$nomi[$i++]] = $value2;
                        }
                    }
                } else {
                        $insert[$nomi[$i++]] = $value;
                }
            }
            print_r($insert);
            echo "<br>";
        }
          
    }

}

?>