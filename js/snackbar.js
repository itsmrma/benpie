// Percorso del file
const filePath = 'date.txt';

// Effettua una richiesta per recuperare il contenuto del file
fetch(filePath)
  .then(response => {
    if (!response.ok) {
      throw new Error('Errore nella richiesta del file');
    }
    return response.text();
  })
  .then(data => {
    // Converte la data in un oggetto JavaScript Date
    const dateFromFile = new Date(data.trim());
    console.log(data);
    // Ottieni la data di oggi
    const today = new Date();

    // Calcola la differenza in millisecondi tra le due date
    const timeDifference = today.getTime() - dateFromFile.getTime();

    // Converti la differenza in giorni
    const daysPassed = Math.floor(timeDifference / (1000 * 3600 * 24));

    console.log('Giorni passati:', daysPassed);
    
    if (daysPassed>=7) {
        showSnackbar();
    }
  })
  .catch(error => {
    console.error('Si è verificato un errore:', error);
  });


 

function showSnackbar() {
    // Inizializza lo snackbar
    var snackbar = document.getElementById("snackbar");

    // Opzioni dello snackbar
    var options = {
        duration: 5000, // Durata in millisecondi
        inDuration: 300, // Durata dell'animazione di ingresso
        outDuration: 200 // Durata dell'animazione di uscita
    };

    // Mostra lo snackbar
    M.toast({html: "Abbiamo notato che il database non è aggiornato. Aggiornamento in background...", ...options});
}