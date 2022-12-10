async function makeMantenimientoBandaModo() {

    const tbodyBandas = document.querySelector('#c-mant__table__body--bandas');
    const tbodyModos = document.querySelector('#c-mant__table__body--modos');
    
    rellenaTablaBandas(tbodyBandas);
    rellenaTablaModos(tbodyModos);
}

async function rellenaTablaBandas(tbody) {
    const respuesta = await fetch("API/bandas.php");

    var bandas = await respuesta.json();

    bandas.forEach(banda => {
        añadeFilaBanda(tbody, banda);
    });
}

async function rellenaTablaModos(tbody) {
    const respuesta = await fetch("API/modos.php");

    var modos = await respuesta.json();

    modos.forEach(modo => {
        añadeFilaModo(tbody, modo);
    });
}

function añadeFilaBanda(tbody, banda) {
    var tr = document.createElement('tr');
    tr.classList.add('c-mant__table__body-row');

    var nombre = document.createElement('td');
    var dis = document.createElement('td');
    var rMax = document.createElement('td');
    var rMin = document.createElement('td');

    nombre.innerHTML = banda.nombre;
    dis.innerHTML = banda.distancia+' metros';
    rMax.innerHTML = banda.rangoMax+' kHz';
    rMin.innerHTML = banda.rangoMin+' kHz';

    tr.append(nombre, dis, rMax, rMin);
    tbody.append(tr);
}

function añadeFilaModo(tbody, modo) {
    var tr = document.createElement('tr');
    tr.classList.add('c-mant__table__body-row');

    var nombre = document.createElement('td');

    nombre.innerHTML = modo.nombre;

    tr.append(nombre);
    tbody.append(tr);
}