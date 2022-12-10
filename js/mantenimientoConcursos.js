async function makeMantenimientoConcursos() {
    
    var tbody = document.getElementById('c-mant__table__body');
    var btnNew = document.querySelector('.c-mant__newBtn');

    btnNew.onclick = async () => {
        var modal = creaModal();

        const resp = await fetch("Vistas/Mantenimiento/formuConcurso.php");
        const formu = await resp.text();

        modal.innerHTML = formu;
    };

    rellenaTablaConcursos(tbody);
}





async function rellenaTablaConcursos(tbody) {
    const respuesta = await fetch("API/concursos.php");

    var concursos = await respuesta.json();

    concursos.forEach(concurso => {
        añadeFilaConc(tbody, concurso);
    });
}

function añadeFilaConc(tbody, concurso) {
    var tr = document.createElement('tr');
    tr.classList.add('c-mant__table__body-row');

    var nombre = document.createElement('td');
    var desc = document.createElement('td');
    var fIn = document.createElement('td');
    var fCon = document.createElement('td');
    var nPar = document.createElement('td');
    var nJu = document.createElement('td');

    nombre.innerHTML = concurso.nombre;
    desc.innerHTML = concurso.desc;
    fIn.innerHTML = concurso.fechaIniInscrp.date.substr(0, 19) + '<br> - <br>' + concurso.fechaFinInscrp.date.substr(0, 19);
    fCon.innerHTML = concurso.fechaIniCon.date.substr(0, 19) + '<br> - <br>' + concurso.fechaFinCon.date.substr(0, 19);
    nPar.innerHTML = concurso.nParticipantes;
    nJu.innerHTML = concurso.nJueces;

    tr.append(nombre, desc, fIn, fCon, nPar, nJu);
    tbody.append(tr);
}