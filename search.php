<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'head.html'; ?>
</head>

<body>
    <?php include 'code.html'; ?>

    <div class="main-container">
        <md-outlined-select label="Comune">
            

        <?php
        $conn = mysqli_connect('localhost', 'root', 'admin', 'sagre');
        $select="";
        $query = "SELECT nome, cap FROM comune ORDER BY nome ASC";
        $result = mysqli_query($conn,$query);
        foreach($result->fetch_all(MYSQLI_ASSOC) as $row) {
            $select .=  "<md-select-option value='" . $row['cap'] . "'><div slot='headline'>" . $row['nome'] . "</div></md-select-option>";
        }
        echo $select;
        ?>
        </md-outlined-select>

    </div>

    <script>
        // set active
        var active = document.getElementById('sidebar_search');
        active.classList.add('active');
    </script>
</body>

</html>