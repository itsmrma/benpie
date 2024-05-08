document.getElementById('cerca').addEventListener('input', function() {
    let query="";
    if (document.getElementById('nomeFiera').value!=="") {
        if (query==="") {
            query+="WHERE evento.denom LIKE '%"+document.getElementById('nomeFiera').value+"%'";
        } else {
            query+=" AND evento.denom LIKE '%"+document.getElementById('nomeFiera').value+"%'";
        }
    }
    
    if (document.getElementById('comune').value!=="") {
        if (query==="") {
            query+="WHERE comune.cap='"+document.getElementById('comune').value+"'";
        } else {
            query+=" AND comune.cap='"+document.getElementById('comune').value+"'";
        }
    }

    var xhr = new XMLHttpRequest();
    
    xhr.open("POST", "query.php", true);
    
    // Imposta l'intestazione della richiesta per indicare che stai inviando dati di tipo JSON
    xhr.setRequestHeader("Content-Type", "application/json");
    
    // Definisci cosa fare quando ricevi una risposta dal server
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Gestisci la risposta dal server
            console.log(xhr.responseText);
            document.getElementById('list').innerHTML = xhr.responseText;
        }
    };

    var dati = JSON.stringify({ query: query });
    
    // Invia i dati al server
    xhr.send(dati);
});