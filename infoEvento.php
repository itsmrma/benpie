<html>
    <body>


        <?php
            
            $conn = new mysqli("localhost","root","","sagre");
            
            // Check connection
            if ($conn -> connect_error) {
                die("Errore di connessione ".$conn->connect_errno." ".$conn->connect_error);
            }

            $sql = "select * from evento where id=". $_COOKIE["idEvento"];
            

            if(($coordResult = $conn ->query($sql))){
                echo "query corretta";
            }else{
                echo "query non corretta";
            }

            foreach($coordResult as $row){
              echo print_r($row);
            }
        ?>
    </body>
</html>

