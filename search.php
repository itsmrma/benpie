<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/maloss.css">
    <script src="js/cookie.js"></script>
    <script src="js/search.js" defer></script>
    <!-- <script src="js/date.js"></script> -->
    <?php include 'head.html'; ?>
</head>

<body>
    <?php include 'code.html'; ?>

    <div class="main-container" id="main-container">
        <div class="main">
            <form action="search.php" method="post" class="basic-form">


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

                <!-- <label for="datepicker" class="mdc-text-field mdc-text-field--outlined">
                    <span class="mdc-notched-outline">
                        <span class="mdc-notched-outline__leading"></span>
                        <span class="mdc-notched-outline__notch">
                            <span class="mdc-floating-label">Select Date</span>
                        </span>
                        <span class="mdc-notched-outline__trailing"></span>
                    </span>
                    <input type="text" id="datepicker" class="mdc-text-field__input" readonly>
                    <div class="mdc-line-ripple"></div>
                </label>
 -->
                <button class="btn filled submit-btn" type="submit" name="login" value="login">Ricerca</a></button>

            </form>

            <?php
            if (isset($_POST["comune"])) {
                $data = json_decode(file_get_contents('php://input'), true);
                echo $data;
                $query = "SELECT evento.denom, evento.id FROM evento INNER JOIN comune ON comune.id=evento.id_comune ";
                if (isset($_POST['comune'])) {
                    $query .= "WHERE comune.cap='" . $_POST['comune'] . "'";

                }

                if (isset($_POST['nomeFiera'])) {
                    $query .= " AND evento.denom LIKE '%" . $_POST['nomeFiera'] . "%'";

                }

                $query .= " ORDER BY denom DESC";
                print ($query);
                $result = $conn->query($query);

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