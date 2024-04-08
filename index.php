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
    foreach ($json as $row) {
      echo "<tr>";
      
      if ($count==0) {
        foreach($row as $key => $value) {
          echo "<td>" . $key . "</td>";
        }
        $count++;
      }
      

      echo "</tr> <tr>";
      foreach($row as $key => $value) {
        if (is_object($value)) {
          foreach ($value as $key2 => $value2) {
            if (!is_object($value2)) {
              echo "<td>" . $value2 . "</td>"; 
            }
          }
        } else {
          if ($value=="") {
          echo "<td> NULL </td>";
          } else {
            echo "<td>" . $value . "</td>";
          }
        }
      }
      
      echo "</tr>";
    }
    echo "</table>";
    
  }




?>
