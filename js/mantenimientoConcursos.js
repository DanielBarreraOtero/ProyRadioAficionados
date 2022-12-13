async function makeMantenimientoConcursos() {

    var tbody = document.getElementById('c-mant__table__body');
    var btnNew = document.querySelector('.c-mant__newBtn');

    btnNew.onclick = async () => {
        var modal = creaModal();

        const resp = await fetch("Vistas/Mantenimiento/formuConcurso.php");
        const formu = await resp.text();

        modal.innerHTML = formu;

        const form = document.querySelector('#c-card-formulario__form--concurso');
        const submit = form.elements['enviar'];

        rellenaBandas(form);
        rellenaModos(form);


        submit.onclick = async (ev) => {
            ev.preventDefault();
            // debugger;
            // si se ha insertado el usuario, recargamos la tabla y cerramos el modal
            if (await añadeConcurso(form)) {
                rellenaTablaConcursos(tbody);
                modal.remove();
            }
        };
    };

    rellenaTablaConcursos(tbody);
}





async function rellenaTablaConcursos(tbody) {
    tbody.innerHTML = "";
    const btnBorrar = document.querySelector('#c-mant__btnBorrar--concurso');
    const respuesta = await fetch("API/concursos.php");

    var concursos = await respuesta.json();

    concursos.forEach(concurso => {
        añadeFilaConc(tbody, concurso, btnBorrar);
    });
}

function añadeFilaConc(tbody, concurso, btnBorrar) {
    var tr = document.createElement('tr');
    var interactuables = [];
    tr.classList.add('c-mant__table__body-row');

    var nombre = document.createElement('td');
    interactuables.push(nombre);
    var desc = document.createElement('td');
    interactuables.push(desc);
    var fIn = document.createElement('td');
    interactuables.push(fIn);
    var fCon = document.createElement('td');
    interactuables.push(fCon);
    var nPar = document.createElement('td');
    interactuables.push(nPar);
    var nJu = document.createElement('td');
    interactuables.push(nJu);
    var borrar = document.createElement('td');

    interactuables.forEach(td => {
        td.onclick = async () => {
            var modal = creaModal();

            const resp = await fetch("Vistas/Mantenimiento/formuConcurso.php?modo=edita");
            const formu = await resp.text();

            modal.innerHTML = formu;

            const form = document.querySelector('#c-card-formulario__form--concurso');
            const submit = form.elements['enviar'];

            form.nombre.value = concurso.nombre;
            form.desc.value = concurso.desc;
            form.fIniInscrp.value = concurso.fechaIniInscrp.date.substr(0, 10);
            form.fIniCon.value = concurso.fechaIniCon.date.substr(0, 10);
            form.fFinInscrp.value = concurso.fechaFinInscrp.date.substr(0, 10);
            form.fFinCon.value = concurso.fechaFinCon.date.substr(0, 10);

            rellenaBandas(form, concurso);
            rellenaModos(form, concurso);
            rellenaJueces(form, concurso);
            rellenaDiplomas(form, concurso);

            submit.onclick = async (ev) => {
                ev.preventDefault();

                // si se ha editado el concurso, recargamos la tabla y cerramos el modal
                if (await editaConcurso(concurso.id, form, concurso)) {
                    rellenaTablaConcursos(tbody);
                    modal.remove();
                }
            };
        }
    });

    nombre.innerHTML = concurso.nombre;
    desc.innerHTML = concurso.desc;
    fIn.innerHTML = concurso.fechaIniInscrp.date.substr(0, 10) + '<br> - <br>' + concurso.fechaFinInscrp.date.substr(0, 10);
    fCon.innerHTML = concurso.fechaIniCon.date.substr(0, 10) + '<br> - <br>' + concurso.fechaFinCon.date.substr(0, 10);
    nPar.innerHTML = concurso.nParticipantes;
    nJu.innerHTML = concurso.nJueces;

    var clon = btnBorrar.cloneNode(true);
    borrar.appendChild(clon);
    clon.classList.add("c-mant__btnBorrar");
    clon.style.borderRadius = "4px";
    clon.style.display = "";


    clon.onclick = async () => {
        if (await borraConcurso(concurso.id)) {
            rellenaTablaConcursos(tbody);
        } else {
            alert('no se ha podido borrar el concurso: ' + concurso.nombre);
        }
    }

    tr.append(nombre, desc, fIn, fCon, nPar, nJu, borrar);
    tbody.append(tr);
}

async function añadeConcurso(formulario) {





    var idBandas = [];
    var idModos = [];

    for (let i = 0; i < formulario.bandas.selectedOptions.length; i++) {
        const banda = formulario.bandas.selectedOptions[i];
        idBandas.push(banda.value);
    }
    for (let i = 0; i < formulario.modos.selectedOptions.length; i++) {
        const modo = formulario.modos.selectedOptions[i];
        idModos.push(modo.value);
    }

    var concurso = {
        "nombre": formulario.nombre.value,
        "desc": formulario.desc.value,
        "fechaIniInscrp": formulario.fIniInscrp.value,
        "fechaFinInscrp": formulario.fFinInscrp.value,
        "fechaIniCon": formulario.fIniCon.value,
        "fechaFinCon": formulario.fFinCon.value,
        "idBandas": idBandas,
        "idModos": idModos,
        "idDiplomas": []
    };

    datos = new FormData();
    datos.append("concurso", JSON.stringify(concurso))


    var respuesta = await fetch("API/concursos.php", { method: "POST", body: datos })

    // si la respuesta de la api es 200 es que el modo ya existe
    // if (respuesta.status === 200) {
    //     erroNom.innerHTML = msgErroNom = "Este usuario ya existe."
    //     erroNom.style.display = "";

    // }


    if (respuesta.status === 201) {
        return true;
    } else {
        return false;
    }
}

async function borraConcurso(id) {
    var datos = { "id": id };
    var respuesta = await fetch("API/concursos.php", { method: "DELETE", headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(datos) });

    if (respuesta.status === 201) {
        return true;
    } else {
        return false;
    }
}


async function rellenaBandas(formulario, concurso = null) {
    const select = formulario.bandas;
    const respuesta = await fetch("API/bandas.php");

    var bandas = await respuesta.json();

    bandas.forEach(banda => {
        var opt = document.createElement('option');
        opt.value = banda.id;
        opt.innerHTML = banda.nombre;

        if (concurso !== null) {
            concurso.idBandas.includes(banda.id) ? opt.selected = true : opt.selected = false;
        }

        select.append(opt);
    });
}

async function rellenaModos(formulario, concurso = null) {
    select = formulario.modos;
    const respuesta = await fetch("API/modos.php");

    var modos = await respuesta.json();

    modos.forEach(modo => {
        var opt = document.createElement('option');
        opt.value = modo.id;
        opt.innerHTML = modo.nombre;

        if (concurso !== null) {
            concurso.idModos.includes(modo.id) ? opt.selected = true : opt.selected = false;
        }

        select.append(opt);
    });
}