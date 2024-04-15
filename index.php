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
    echo "<table border=1px>";
    $count=0;
    
    $nomi = array(24);
    foreach ($json as $row) {
      echo "<tr>";
      $i=0;  
      if ($count==0) {
        foreach($row as $key => $value) {
          if ($key!="location") {
            echo "<td>" . $key . "</td>";
            $nomi[$i] = $key;
            $i++;
          }
          
          
        }
        $count++;
      }
      
      $i=0;
      
      echo "</tr> <tr>";
      foreach($row as $key => $value) {
        if ($key != "location" ) {
          while($key!=$nomi[$i] && $i<24){
            $i++;
            echo "<td> NULL </td>";
          }
          if (is_object($value)) {
            foreach ($value as $key2 => $value2) {
              if (!is_object($value2)) {
                echo "<td>" . $value2 . "</td>"; 
              }
            }
          } else{
            echo "<td>" . $value . "</td>";
          }
          $i++;
        }
        
      }
      
      echo "</tr>";
    }
    echo "</table>";
    
  }




?>
