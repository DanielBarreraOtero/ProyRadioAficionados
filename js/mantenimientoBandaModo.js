async function makeMantenimientoBandaModo() {

    const tbodyBandas = document.querySelector('#c-mant__table__body--bandas');
    const tbodyModos = document.querySelector('#c-mant__table__body--modos');
    var btnNewBanda = document.querySelector('#c-mant__newBtn--bandas');
    var btnNewModo = document.querySelector('#c-mant__newBtn--modos');


    btnNewBanda.onclick = async () => {
        var modal = creaModal();

        const resp = await fetch("Vistas/Mantenimiento/formuBanda.php");
        const formu = await resp.text();

        modal.innerHTML = formu;

        const form = document.querySelector('#c-card-formulario__form--banda');
        const submit = form.elements['enviar'];


        submit.onclick = async (ev) => {
            ev.preventDefault();

            // si se ha insertado la banda, recargamos la tabla y cerramos el modal
            if (await añadeBanda(form)) {
                rellenaTablaBandas(tbodyBandas);
                modal.remove();
            }
        };
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
    var btnBorrar = document.querySelector('#c-mant__btnBorrar--banda-modo');
    const respuesta = await fetch("API/bandas.php");

    var bandas = await respuesta.json();

    tbody.innerHTML = "";

    bandas.forEach(banda => {
        añadeFilaBanda(tbody, banda, btnBorrar);
    });
}

async function rellenaTablaModos(tbody) {
    var btnBorrar = document.querySelector('#c-mant__btnBorrar--banda-modo');
    const respuesta = await fetch("API/modos.php");

    var modos = await respuesta.json();

    tbody.innerHTML = "";

    modos.forEach(modo => {
        añadeFilaModo(tbody, modo, btnBorrar);
    });
}

function añadeFilaBanda(tbody, banda, btnBorrar) {
    var tr = document.createElement('tr');
    var interactuables = [];
    tr.classList.add('c-mant__table__body-row');

    var nombre = document.createElement('td');
    var dis = document.createElement('td');
    var rMax = document.createElement('td');
    var rMin = document.createElement('td');
    var borrar = document.createElement('td');

    nombre.innerHTML = banda.nombre;
    interactuables.push(nombre);
    dis.innerHTML = banda.distancia + ' metros';
    interactuables.push(dis);
    rMax.innerHTML = banda.rangoMax + ' kHz';
    interactuables.push(rMax);
    rMin.innerHTML = banda.rangoMin + ' kHz';
    interactuables.push(rMin);

    interactuables.forEach(td => {
        td.onclick = async () => {
            var modal = creaModal();

            const resp = await fetch("Vistas/Mantenimiento/formuBanda.php?modo=edita");
            const formu = await resp.text();

            modal.innerHTML = formu;

            const form = document.querySelector('#c-card-formulario__form--banda');
            form.nombre.value = banda.nombre;
            form.distancia.value = banda.distancia;
            form.rangoMin.value = banda.rangoMin;
            form.rangoMax.value = banda.rangoMax;
            const submit = form.elements['enviar'];

            submit.onclick = async (ev) => {
                ev.preventDefault();

                // si se ha editado la banda, recargamos la tabla y cerramos el modal
                if (await editaBanda(banda.id, form, banda)) {
                    rellenaTablaBandas(tbody);
                    modal.remove();
                }
            };
        }
    });

    var clon = btnBorrar.cloneNode(true);
    borrar.appendChild(clon);
    clon.classList.add("c-mant__btnBorrar");
    clon.style.borderRadius = "4px";
    clon.style.display = "";


    clon.onclick = async () => {
        if (await borraBanda(banda.id)) {
            rellenaTablaBandas(tbody);
        } else {
            alert('no se ha podido borrar la banda: ' + banda.nombre);
        }
    }

    tr.append(nombre, dis, rMin, rMax, borrar);
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


    clon.onclick = async () => {
        if (await borraModo(modo.id)) {
            rellenaTablaModos(tbody);
        } else {
            alert('no se ha podido borrar el modo: ' + modo.nombre);
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

async function añadeBanda(formulario) {
    // validamos
    var triggerError = false
    var erroNom = document.querySelector("#error-banda-nombre");
    var erroDis = document.querySelector("#error-banda-distancia");
    var erroRMin = document.querySelector("#error-banda-rangoMin");
    var erroRMax = document.querySelector("#error-banda-rangoMax");

    // validacion Nombre
    if (formulario.nombre.value === "") {
        triggerError = true;
        msgError = "El nombre no puede estar vacío."

    } else if (formulario.nombre.value.length > 45) {
        triggerError = true;
        msgError = "El nombre no puede superar los 45 caracteres."

    }

    if (triggerError) {
        erroNom.style.display = "";
        erroNom.innerHTML = msgError;
        return false;
    } else {
        erroNom.style.display = "none";
    }

    triggerError = false

    // validacion distancia
    if (formulario.distancia.value.length === 0) {
        triggerError = true;
        msgError = "La distancia no puede estar vacía."

    } else if (isNaN(formulario.distancia.value)) {
        triggerError = true;
        msgError = "La distancia debe ser un número."
    }

    if (triggerError) {
        erroDis.style.display = "";
        erroDis.innerHTML = msgError;
        return false;
    } else {
        erroDis.style.display = "none";
    }

    triggerError = false

    // validacion rangoMin
    if (formulario.rangoMin.value.length === 0) {
        triggerError = true;
        msgError = "El rango mínimo no puede estar vacío."

    } else if (isNaN(formulario.rangoMin.value)) {
        triggerError = true;
        msgError = "El rango mínimo debe ser un número."
    } else if (formulario.rangoMin.value >= formulario.rangoMax.value) {
        triggerError = true;
        msgError = "El rango mínimo debe ser menor que el máximo."
    }

    if (triggerError) {
        erroRMin.style.display = "";
        erroRMin.innerHTML = msgError;
        return false;
    } else {
        erroRMin.style.display = "none";
    }

    triggerError = false

    // validacion rangoMax
    if (formulario.rangoMax.value.length === 0) {
        triggerError = true;
        msgError = "El rango máximo no puede estar vacío."

    } else if (isNaN(formulario.rangoMax.value)) {
        triggerError = true;
        msgError = "El rango máximo debe ser un número."
    } else if (formulario.rangoMax.value <= formulario.rangoMin.value) {
        triggerError = true;
        msgError = "El rango máximo debe ser mayor que el mínimo."
    }

    if (triggerError) {
        erroRMax.style.display = "";
        erroRMax.innerHTML = msgError;
        return false;
    } else {
        erroRMax.style.display = "none";
    }

    var banda = {
        "nombre": formulario.nombre.value,
        "distancia": formulario.distancia.value,
        "rangoMin": formulario.rangoMin.value,
        "rangoMax": formulario.rangoMax.value
    };

    datos = new FormData();
    datos.append("banda", JSON.stringify(banda))

    var respuesta = await fetch("API/bandas.php", { method: "POST", body: datos })

    // si la respuesta de la api es 200 es que el modo ya existe
    if (respuesta.status === 200) {
        erroNom.innerHTML = msgErroNom = "Esta banda ya existe."
        erroNom.style.display = "";

    }


    if (respuesta.status === 201) {
        return true;
    } else {
        return false;
    }
}

async function editaBanda(id, formulario) {
    // validamos
    var triggerError = false
    var erroNom = document.querySelector("#error-banda-nombre");
    var erroDis = document.querySelector("#error-banda-distancia");
    var erroRMin = document.querySelector("#error-banda-rangoMin");
    var erroRMax = document.querySelector("#error-banda-rangoMax");

    // validacion Nombre
    if (formulario.nombre.value === "") {
        triggerError = true;
        msgError = "El nombre no puede estar vacío."

    } else if (formulario.nombre.value.length > 45) {
        triggerError = true;
        msgError = "El nombre no puede superar los 45 caracteres."

    }

    if (triggerError) {
        erroNom.style.display = "";
        erroNom.innerHTML = msgError;
        return false;
    } else {
        erroNom.style.display = "none";
    }

    triggerError = false

    // validacion distancia
    if (formulario.distancia.value.length === 0) {
        triggerError = true;
        msgError = "La distancia no puede estar vacía."

    } else if (isNaN(formulario.distancia.value)) {
        triggerError = true;
        msgError = "La distancia debe ser un número."
    }

    if (triggerError) {
        erroDis.style.display = "";
        erroDis.innerHTML = msgError;
        return false;
    } else {
        erroDis.style.display = "none";
    }

    triggerError = false

    // validacion rangoMin
    if (formulario.rangoMin.value.length === 0) {
        triggerError = true;
        msgError = "El rango mínimo no puede estar vacío."

    } else if (isNaN(formulario.rangoMin.value)) {
        triggerError = true;
        msgError = "El rango mínimo debe ser un número."
    } else if (formulario.rangoMin.value >= formulario.rangoMax.value) {
        triggerError = true;
        msgError = "El rango mínimo debe ser menor que el máximo."
    }

    if (triggerError) {
        erroRMin.style.display = "";
        erroRMin.innerHTML = msgError;
        return false;
    } else {
        erroRMin.style.display = "none";
    }

    triggerError = false

    // validacion rangoMax
    if (formulario.rangoMax.value.length === 0) {
        triggerError = true;
        msgError = "El rango máximo no puede estar vacío."

    } else if (isNaN(formulario.rangoMax.value)) {
        triggerError = true;
        msgError = "El rango máximo debe ser un número."
    } else if (formulario.rangoMax.value <= formulario.rangoMin.value) {
        triggerError = true;
        msgError = "El rango máximo debe ser mayor que el mínimo."
    }

    if (triggerError) {
        erroRMax.style.display = "";
        erroRMax.innerHTML = msgError;
        return false;
    } else {
        erroRMax.style.display = "none";
    }

    var banda = {
        "nombre": formulario.nombre.value,
        "distancia": formulario.distancia.value,
        "rangoMin": formulario.rangoMin.value,
        "rangoMax": formulario.rangoMax.value
    };

    var datos = { "id": id, "banda": banda };
    console.log(JSON.stringify(datos));
    var respuesta = await fetch("API/bandas.php", { method: "PUT", headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(datos) });

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
    var datos = { "id": id };
    var respuesta = await fetch("API/modos.php", { method: "DELETE", headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(datos) });

    if (respuesta.status === 201) {
        return true;
    } else {
        return false;
    }
}

async function borraBanda(id) {
    var datos = { "id": id };
    var respuesta = await fetch("API/bandas.php", { method: "DELETE", headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(datos) });

    if (respuesta.status === 201) {
        return true;
    } else {
        return false;
    }
}