async function makeMantenimientoBandaModo() {

    const tbodyBandas = document.querySelector('#c-mant__table__body--bandas');
    const tbodyModos = document.querySelector('#c-mant__table__body--modos');
    var btnNewBanda = document.querySelector('#c-mant__newBtn--bandas');
    var btnNewModo = document.querySelector('#c-mant__newBtn--modos');
   

    btnNewBanda.onclick = async () => {
        var modal = creaModal();

        // const resp = await fetch("Vistas/Mantenimiento/formuConcurso.php");
        // const formu = await resp.text();

        // modal.innerHTML = formu;
    };

    btnNewModo.onclick = async () => {
        var modal = creaModal();

        const resp = await fetch("Vistas/Mantenimiento/formuModo.php");
        const formu = await resp.text();

        modal.innerHTML = formu;

        const form = document.querySelector('#c-card-formulario__form--modo');
        const submit = form.elements['enviar'];


        submit.onclick = async (ev) => {
            ev.preventDefault();

            // si se ha insertado el modo, recargamos la tabla y cerramos el modal
            if (await añadeModo(form)) {
                rellenaTablaModos(tbodyModos);
                modal.remove();
            }
        };
    };

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
    var btnBorrar = document.querySelector('#c-mant__btnBorrar--modos');
    const respuesta = await fetch("API/modos.php");

    var modos = await respuesta.json();

    tbody.innerHTML = "";

    modos.forEach(modo => {
        añadeFilaModo(tbody, modo, btnBorrar);
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
    dis.innerHTML = banda.distancia + ' metros';
    rMax.innerHTML = banda.rangoMax + ' kHz';
    rMin.innerHTML = banda.rangoMin + ' kHz';

    tr.append(nombre, dis, rMax, rMin);
    tbody.append(tr);
}

function añadeFilaModo(tbody, modo, btnBorrar) {
    var tr = document.createElement('tr');
    tr.classList.add('c-mant__table__body-row');

    var nombre = document.createElement('td');
    var borrar = document.createElement('td');

    nombre.innerHTML = modo.nombre;

    nombre.onclick = async () => {
        var modal = creaModal();

        const resp = await fetch("Vistas/Mantenimiento/formuModo.php?modo=edita");
        const formu = await resp.text();

        modal.innerHTML = formu;

        const form = document.querySelector('#c-card-formulario__form--modo');
        form.nombre.value = modo.nombre;
        const submit = form.elements['enviar'];

        submit.onclick = async (ev) => {
            ev.preventDefault();

            // si se ha editado el modo, recargamos la tabla y cerramos el modal
            if (await editaModo(modo.id, form, modo)) {
                rellenaTablaModos(tbody);
                modal.remove();
            }
        };
    };

    var clon = btnBorrar.cloneNode(true);
    borrar.appendChild(clon);
    clon.classList.add("c-mant__btnBorrar");
    clon.style.borderRadius = "4px";
    clon.style.display = "";
    

    clon.onclick= async () => {
        if (await borraModo(modo.id)) {
            rellenaTablaModos(tbody);
        } else {
            alert('no se ha podido borrar el concurso: '+modo.nombre);
        }
    }
    
    tr.append(nombre, borrar);
    tbody.append(tr);
}

async function añadeModo(formulario) {
    // validamos
    var nomInvalido = false
    var erroNom = document.querySelector("#error-modo-nombre");

    if (formulario.nombre.value === "") {
        nomInvalido = true;
        msgErroNom = "El nombre no puede estar vacío."
        
    } else if (formulario.nombre.value.length > 45) {
        nomInvalido = true;
        msgErroNom = "El nombre no puede superar los 45 caracteres."

    } 


    if (nomInvalido) {
        erroNom.style.display = "";
        erroNom.innerHTML = msgErroNom;
        return false;
    } else {
        erroNom.style.display = "none";
    }


    datos = new FormData();
    datos.append("nombre", formulario.nombre.value)

    var respuesta = await fetch("API/modos.php", { method: "POST", body: datos })

    // si la respuesta de la api es 200 es que el modo ya existe
    if (respuesta.status === 200) {
        erroNom.innerHTML = msgErroNom = "Este modo ya existe."
        erroNom.style.display = "";

    }


    if (respuesta.status === 201) {
        return true;
    } else {
        return false;
    }
}

async function editaModo(id, formulario, modoOriginal) {
    // validamos
    var nomInvalido = false
    var erroNom = document.querySelector("#error-modo-nombre");

    if (formulario.nombre.value === "") {
        nomInvalido = true;
        msgErroNom = "El nombre no puede estar vacío."
        
    } else if (formulario.nombre.value === modoOriginal.nombre) {
        nomInvalido = true;
        msgErroNom = "El nombre no puede ser el mismo."

    } else if (formulario.nombre.value.length > 45) {
        nomInvalido = true;
        msgErroNom = "El nombre no puede superar los 45 caracteres."

    } 

    if (nomInvalido) {
        erroNom.style.display = "";
        erroNom.innerHTML = msgErroNom;
        return false;
    } else {
        erroNom.style.display = "none";

    }

    var datos = { "id": id, nombre: formulario.nombre.value };
    var respuesta = await fetch("API/modos.php", { method: "PUT", headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(datos) });

    if (respuesta.status === 201) {
        return true;
    } else {
        return false;
    }
}


async function borraModo(id) {
    var datos = { "id": id};
    var respuesta = await fetch("API/modos.php", { method: "DELETE", headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(datos) });

    if (respuesta.status === 201) {
        return true;
    } else {
        return false;
    }
}