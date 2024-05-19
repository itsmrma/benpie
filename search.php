<!DOCTYPE html>
<html lang="en">

<head>
    <script src="js/cookie.js"></script>
    <script src="js/search.js" defer></script>
    <!-- <script src="js/date.js"></script> -->
    <?php include 'head.html'; ?>
    <link rel="stylesheet" href="css/page.css"></link>
</head>

<body>
    <?php include 'code.html'; ?>

    <div class="main-container" id="main-container">
        <div class="main">
            <form action="search.php" method="post" class="basic-form" id="cerca">


                <md-outlined-text-field label="Nome fiera" name="nomeFiera" id="nomeFiera">
                </md-outlined-text-field>

                <?php
                $conn = mysqli_connect('localhost', 'root', '', 'sagre');

                $select = "<md-outlined-select label='Comune' name='comune' id='comune'> <md-select-option aria-label='blank'></md-select-option>";
                $query = "SELECT nome, cap FROM comune ORDER BY nome ASC";
                $result = mysqli_query($conn, $query);
                foreach ($result->fetch_all(MYSQLI_ASSOC) as $row) {
                    $select .= "<md-select-option value='" . $row['cap'] . "'><div slot='headline'>" . $row['nome'] . "</div></md-select-option>";
                }
                $select .= "</md-outlined-select>";
                echo $select;


                ?>
                <input type="text" class="date-range-input" id="date-range-picker" />

                <md-outlined-select label="Ordinamento" name="order" id="order">
                    <md-select-option selected value="1">
                        <div slot="headline">
                            Nome (crescente)
                        </div>
                    </md-select-option>
                    <md-select-option value="2">
                        <div slot="headline">
                            Nome (decrescente)
                        </div>
                    </md-select-option>
                    <md-select-option value="3">
                        <div slot="headline">
                            Data (crescente)
                        </div>
                    </md-select-option>
                    <md-select-option value="4">
                        <div slot="headline">
                            Data (decrescente)
                        </div>
                    </md-select-option>
                </md-outlined-select>
            </form>
            <br><br>

            <div id="list" class="listaEventi">
            </div>
        </div>



    </div>

    <script>
        // Inizializza il date range picker
        $(document).ready(function () {
            $('#date-range-picker').daterangepicker({
                opens: 'left', // Opzioni di visualizzazione
                autoApply: true, // Applica automaticamente la selezione al momento della chiusura
                locale: {
                    format: 'DD/MM/YY', // Formato della data
                    separator: ' to ', // Separatore tra le due date
                    applyLabel: 'Apply', // Etichetta del pulsante "Applica"
                    cancelLabel: 'Cancel', // Etichetta del pulsante "Annulla"
                    customRangeLabel: 'Custom Range', // Etichetta per il range personalizzato
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'], // Giorni della settimana
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], // Nomi dei mesi
                    firstDay: 1 // Primo giorno della settimana (0 = Domenica, 1 = Lunedì, ecc.)
                },
                ranges: { // Range predefiniti
                    'Today': [moment(), moment()],
                    'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
                    'Next 7 Days': [moment(), moment().add(6, 'days')],
                    'Next Month': [moment().startOf('month').add(1, 'month'), moment().endOf('month').add(1, 'month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')]
                },
                startDate: moment(), // Inizializza con il range di default "Today"
                endDate: moment()
            });
        });
    </script>

    <script>
        // set active
        var active = document.getElementById('sidebar_search');
        active.classList.add('active');
    </script>
</body>

</html>