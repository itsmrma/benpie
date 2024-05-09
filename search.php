<!DOCTYPE html>
<html lang="en">

<head>
    <script src="js/cookie.js"></script>
    <script src="js/search.js" defer></script>
    <!-- <script src="js/date.js"></script> -->
    <?php include 'head.html'; ?>
</head>

<body>
    <?php include 'code.html'; ?>

    <div class="main-container" id="main-container">
        <div class="main">
            <form action="search.php" method="post" class="basic-form" id="cerca">


                <md-outlined-text-field label="Nome fiera" name="nomeFiera" id=nomeFiera>
                </md-outlined-text-field>

                <?php
                $conn = mysqli_connect('localhost', 'root', '', 'sagre');

                $select = "<md-outlined-select label='Comune' name='comune' id='comune'>";
                $query = "SELECT nome, cap FROM comune ORDER BY nome ASC";
                $result = mysqli_query($conn, $query);
                foreach ($result->fetch_all(MYSQLI_ASSOC) as $row) {
                    $select .= "<md-select-option value='" . $row['cap'] . "'><div slot='headline'>" . $row['nome'] . "</div></md-select-option>";
                }
                $select .= "</md-outlined-select>";
                echo $select;


                ?>

            </form>

            <div id="list"></div>


        </div>


    </div>

    <script>
        // set active
        var active = document.getElementById('sidebar_search');
        active.classList.add('active');
    </script>
</body>

</html>