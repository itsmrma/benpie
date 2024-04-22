<html>
    <body>


        <?php
            
            $conn = new mysqli("localhost","root","","sagre");
            
            if ($conn -> connect_error) {
                die("Errore di connessione ".$conn->connect_errno." ".$conn->connect_error);
            }

            $sql = "select * from evento where id=". $_COOKIE["idEvento"];
            
            $coordResult = $conn ->query($sql);

            foreach($coordResult as $row){
              echo print_r($row);
            }
        ?>
    </body>
</html>

