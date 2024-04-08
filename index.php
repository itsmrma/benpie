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
    
    echo "<table border=1px>";
    $count=0;
    foreach($json as $row){
      echo "<tr>";
      
      foreach($row as $key=> $value){
        if(!$count){
          echo "<td>".$key."</td>";
        }else{
          echo "<td>".$value."</td>";
        }
        
      }
      $count+=1;
      echo "</tr>";
    }
    echo "</table>";
    
  }




?>
