var query = "";
document.getElementById('nomeFiera').addEventListener('input', function() {
    console.log(document.getElementById('nomeFiera').value);
    if (query==="") {
        query+="WHERE evento.denom LIEK '%"+document.getElementById('nomeFiera').value+"%'";
    } else {
        query+=" AND evento.denom LIKE '%"+document.getElementById('nomeFiera').value+"%'";
    }
});

document.getElementById('comune').addEventListener('input', function() {
    
    if (query==="") {
        query+="WHERE comune.cap='"+document.getElementById('comune').value+"'";
    } else {
        query+=" AND comune.cap='"+document.getElementById('comune').value+"'";
    }
    
});



