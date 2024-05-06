document.getElementById('nomeFiera').addEventListener('input', function() {
    fetch('search.php', {
        method: 'POST',
        body: JSON.stringify({ nomeFiera: document.getElementById('nomeFiera').value }), // Dati da inviare al server
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.text())
    .catch(error => {
        console.error('Si è verificato un errore:', error);
    });
    console.log(document.getElementById('nomeFiera').value);
});

document.getElementById('comune').addEventListener('input', function() {
    fetch('search.php', {
        method: 'POST',
        body: JSON.stringify({ comune: document.getElementById('comune').value }), // Dati da inviare al server
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.text())
    .catch(error => {
        console.error('Si è verificato un errore:', error);
    });
    console.log(document.getElementById('comune').value);
});



