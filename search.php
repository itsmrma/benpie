<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/maloss.css">
    <script src="js/cookie.js"></script>
    <?php include 'head.html'; ?>
</head>

<body>
    <?php include 'code.html'; ?>

    <div class="main-container">
        <div class="main">
            <form action="search.php" method="post" class="basic-form">
            

            <md-outlined-text-field label="Nome fiera" name="nomeFiera">
            </md-outlined-text-field>

                 <?php
                $conn = mysqli_connect('localhost', 'root', '', 'sagre');
                
                $select="<md-outlined-select label='Comune' name='comune'>";
                $query = "SELECT nome, cap FROM comune ORDER BY nome ASC";
                $result = mysqli_query($conn,$query);
                foreach($result->fetch_all(MYSQLI_ASSOC) as $row) {
                    $select .=  "<md-select-option value='" . $row['cap'] . "'><div slot='headline'>" . $row['nome'] . "</div></md-select-option>";
                }
                $select .= "</md-outlined-select>";
                echo $select;

                
                ?>

                <button class="btn filled submit-btn" type="submit" name="login" value="login">Ricerca</a></button>

            </form>

            <?php
            if (isset($_POST['comune'])) {
                $result = $conn->query("SELECT evento.denom, evento.id FROM evento INNER JOIN comune ON comune.id=evento.id_comune WHERE comune.cap='" . $_POST['comune'] . "' ORDER BY denom ASC");
                foreach ($result->fetch_all(MYSQLI_ASSOC) as $row) {
                    echo "<a target='_blank' href='infoEvento.php' onclick='setCookie(" . $row['id'] . ")'>" . $row['denom'] . "</a><br>";
                }
            }

            if (isset($_POST['nomeFiera'])) {
                $result = $conn->query("SELECT evento.denom, evento.id FROM evento WHERE evento.denom LIKE '%" . $_POST['nomeFiera'] . "%' ORDER BY denom ASC");
                foreach ($result->fetch_all(MYSQLI_ASSOC) as $row) {
                    echo "<a target='_blank' href='infoEvento.php' onclick='setCookie(" . $row['id'] . ")'>" . $row['denom'] . "</a><br>";
                }
            }
            ?>
                

           
        </div>
        

    </div>

    <script>
        // set active
        var active = document.getElementById('sidebar_search');
        active.classList.add('active');
    </script>
</body>

</html>