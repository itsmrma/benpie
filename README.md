# Sagre in Lombardia 🎡

Un'applicazione web completa per la ricerca, visualizzazione e gestione delle sagre e delle fiere sul territorio lombardo.

<p align="center">
  <img src="readme/pages.png" alt="Sagre in Lombardia pages">
</p>

## 📖 Descrizione del Progetto

Questo sito permette agli utenti di scoprire facilmente gli eventi tradizionali e le fiere nella regione Lombardia. Attraverso un'interfaccia web e una mappa interattiva, è possibile esplorare le sagre, visualizzare informazioni di dettaglio e filtrare i risultati in base a criteri specifici (nome, data di svolgimento e località).

I dati degli eventi vengono popolati prelevando le informazioni dal portale **Open Data della Regione Lombardia**.

## ✨ Funzionalità Principali

*   **Esplorazione e Ricerca Avanzata**: 
    *   **Homepage**: Offre una tabella con le prossime fiere ordinate cronologicamente. Gli eventi salvati nei preferiti dall'utente avranno la priorità e verranno mostrati in cima alla lista.
    *   **Area di Ricerca**: Motore di ricerca interno con filtri combinati per nome, data e posizione geografica.
*   **Mappa Interattiva**: L'intera offerta di eventi è consultabile tramite mappa geografica. I pin rappresentano le posizioni esatte delle fiere: con un semplice click è possibile ottenere le prime info e accedere ai dettagli completi.
*   **Gestione Utenti e Area Personale**:
    *   Sistema di **registrazione e login** sicuro (hashing delle password tramite `bcrypt`).
    *   Gli utenti loggati possono aggiungere le fiere alla propria lista dei **Preferiti** e rilasciare **Commenti** nella pagina dell'evento.
*   **Dettaglio Evento e Download PDF**: Ogni sagra possiede una propria scheda descrittiva. È inoltre supportato il download di un comodo file PDF riassuntivo contenente le informazioni della fiera.
*   **Sincronizzazione Dati Automatica**: Script dedicato al fetch e parsing dei JSON delle API di Regione Lombardia per aggiornare il database. Un sistema di monitoraggio avvisa nella homepage qualora il DB non dovesse risultare aggiornato da più di una settimana.

## 🛠️ Stack Tecnologico

Il progetto è costruito affidandosi alle seguenti tecnologie:
*   **Backend**: PHP nativo, con gestione sicura delle sessioni (Authentication, Controller).
*   **Database**: MySQL / MariaDB (gestito tramite `mysqli`), con tabelle interconnesse per utenti, sagre, toponimi e province.
*   **Frontend**: HTML5, CSS, JavaScript.
*   **Integrazione Dati**: API REST [Open Data Lombardia](https://www.dati.lombardia.it/).
