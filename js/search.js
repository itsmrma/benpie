document.getElementById('cerca').addEventListener('input', function () {
    search();
});

$('#date-range-picker').on('apply.daterangepicker', function () {
    search();
});

function search() {
    let query = "";
    if (document.getElementById('nomeFiera').value !== "") {
        if (query === "") {
            query += "WHERE evento.denom LIKE '%" + document.getElementById('nomeFiera').value + "%'";
        } else {
            query += " AND evento.denom LIKE '%" + document.getElementById('nomeFiera').value + "%'";
        }
    }

    if (document.getElementById('comune').value !== "") {
        if (query === "") {
            query += "WHERE comune.cap='" + document.getElementById('comune').value + "'";
        } else {
            query += " AND comune.cap='" + document.getElementById('comune').value + "'";
        }
    }

    if (document.getElementById('date-range-picker').value !== "") {
        const picker = document.getElementById('date-range-picker').value;
        let dates = picker.split(" to ");
        let d1, m1, y1, d2, m2, y2;
        let data1 = dates[0].split("/");
        d1 = data1[0];
        m1 = data1[1];
        y1 = "20" + data1[2];

        let data2 = dates[1].split("/");
        d2 = data2[0];
        m2 = data2[1];
        y2 = "20" + data2[2];

        let startDate = y1 + "-" + m1 + "-" + d1;
        let endDate = y2 + "-" + m2 + "-" + d2;

        if (query === "") {
            query += "WHERE ('" + startDate + "' BETWEEN DATE(evento.data_inizio) AND DATE(evento.data_fine) OR '" + startDate + "' <= evento.data_inizio) AND ( '" + endDate + "' BETWEEN DATE(evento.data_inizio) AND DATE (evento.data_fine) OR DATE(evento.data_fine)<='" + endDate + "')";
        } else {
            query += " AND ('" + startDate + "' BETWEEN DATE(evento.data_inizio) AND DATE(evento.data_fine) OR '" + startDate + "' <= evento.data_inizio) AND ( '" + endDate + "' BETWEEN DATE(evento.data_inizio) AND DATE (evento.data_fine) OR DATE(evento.data_fine)<='" + endDate + "')";
        }
    }


    if (document.getElementById('order').value !== "") {
        let s="";
        switch (document.getElementById('order').value) {
            case '1':
                s = "evento.denom ASC";
                break;
            case '2':
                s = "evento.denom DESC";
                break;
            case '3':
                s = "evento.data_inizio ASC";
                break;
            case '4':
                s = "evento.data_inizio DESC";
                break;
        }
        query += " ORDER BY " + s;
    }

    console.log (query);
    
    var xhr = new XMLHttpRequest();

    xhr.open("POST", "query.php", true);

    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('list').innerHTML = xhr.responseText;
        }
    };

    console.log(query);
    var dati = JSON.stringify({ query: query });

    xhr.send(dati);
}