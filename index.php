<?php
  echo "Ciao mondo";
  echo "Hello World";

  $url = "https://www.dati.lombardia.it/resource/hs8z-dcey.json";
  $filename = basename($url);
  if (file_put_contents($filename, file_get_contents($url))) {
    echo "File downloaded.";
  } else {
    echo "Failed.";
  }

  if (file_exists($filename)) {
    $data = file_get_contents($filename);
    $json = json_decode($data);
    print_r($json);

    
  }


?>
