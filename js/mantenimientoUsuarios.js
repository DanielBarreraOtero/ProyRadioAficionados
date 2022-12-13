async function makeMantenimientoUsuario() {
    
    var tbody = document.getElementById('c-mant__table__body');
    var btnNew = document.querySelector('.c-mant__newBtn');

    btnNew.onclick = async () => {
        var modal = creaModal();

        const resp = await fetch("Vistas/Mantenimiento/formuUsuario.php");
        const formu = await resp.text();

        modal.innerHTML = formu;

        const form = document.querySelector('#c-card-formulario__form--usuario');
        const submit = form.elements['enviar'];


        submit.onclick = async (ev) => {
            ev.preventDefault();

            // si se ha insertado el usuario, recargamos la tabla y cerramos el modal
            if (await añadeUsuario(form)) {
                rellenaTablaUsuarios(tbody);
                modal.remove();
            }
        };
    };

    rellenaTablaUsuarios(tbody);
}





async function rellenaTablaUsuarios(tbody) {
    const respuesta = await fetch("API/usuarios.php");
    const btnBorrar = document.querySelector("#c-mant__btnBorrar--usuario");

    var usuarios = await respuesta.json();
    tbody.innerHTML = "";

    usuarios.forEach(usuario => {
        añadeFilaUsu(tbody, usuario, btnBorrar);
    });
}

function añadeFilaUsu(tbody, usuario, btnBorrar) {
    var tr = document.createElement('tr');
    var interactuables = [];
    tr.classList.add('c-mant__table__body-row');

    var indicativo = document.createElement('td');
    var nombre = document.createElement('td');
    var apellidos = document.createElement('td');
    var email = document.createElement('td');
    var rol = document.createElement('td');
    var borrar = document.createElement('td');
    
    indicativo.innerHTML = usuario.indicativo;
    interactuables.push(indicativo);
    nombre.innerHTML = usuario.nombre;
    interactuables.push(nombre);
    apellidos.innerHTML = usuario.apellido1 + " " + usuario.apellido2;
    interactuables.push(apellidos);
    email.innerHTML = usuario.email;
    interactuables.push(email);
    rol.innerHTML = usuario.rol;
    interactuables.push(rol);

    interactuables.forEach(td => {
        td.onclick = async () => {
            var modal = creaModal();

            const resp = await fetch("Vistas/Mantenimiento/formuUsuario.php?modo=edita");
            const formu = await resp.text();

            modal.innerHTML = formu;

            const form = document.querySelector('#c-card-formulario__form--usuario');
            const parBox = document.querySelector('.c-card-formulario__participaciones-box');
            form.indicativo.value = usuario.indicativo;
            form.nombre.value = usuario.nombre;
            form.apellido1.value = usuario.apellido1;
            form.apellido2.value = usuario.apellido2;
            form.email.value = usuario.email;
            form.rol.value = usuario.rol;


            usuario.participaciones.forEach(participacion => {
                for (let index = 0; index < 15; index++) {
                    var nom = document.createElement('div');
                    nom.style.textAlign = "center";
                    var btnElim = document.createElement('div');
                    btnElim.style.userSelect = "none";
    
                    nom.innerHTML = participacion.concurso.nombre;
                    btnElim.innerHTML = '❌';
    
                    parBox.append(nom, btnElim);
                }
            });

            const submit = form.elements['enviar'];

            submit.onclick = async (ev) => {
                ev.preventDefault();

                // si se ha editado la banda, recargamos la tabla y cerramos el modal
                if (await editaUsuario(usuario.id, form, usuario)) {
                    rellenaTablaUsuarios(tbody);
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
        if (await borraUsuario(usuario.id)) {
            rellenaTablaUsuarios(tbody);
        } else {
            alert('no se ha podido borrar el usuario: ' + usuario.indicativo);
        }
    }

    tr.append(indicativo, nombre, apellidos, email, rol, borrar);
    tbody.append(tr);
}


async function añadeUsuario(formulario) {
    // // validamos
    // var triggerError = false
    // var erroNom = document.querySelector("#error-banda-nombre");
    // var erroDis = document.querySelector("#error-banda-distancia");
    // var erroRMin = document.querySelector("#error-banda-rangoMin");
    // var erroRMax = document.querySelector("#error-banda-rangoMax");

    // // validacion Nombre
    // if (formulario.nombre.value === "") {
    //     triggerError = true;
    //     msgError = "El nombre no puede estar vacío."

    // } else if (formulario.nombre.value.length > 45) {
    //     triggerError = true;
    //     msgError = "El nombre no puede superar los 45 caracteres."

    // }

    // if (triggerError) {
    //     erroNom.style.display = "";
    //     erroNom.innerHTML = msgError;
    //     return false;
    // } else {
    //     erroNom.style.display = "none";
    // }

    // triggerError = false

    // // validacion distancia
    // if (formulario.distancia.value.length === 0) {
    //     triggerError = true;
    //     msgError = "La distancia no puede estar vacía."

    // } else if (isNaN(formulario.distancia.value)) {
    //     triggerError = true;
    //     msgError = "La distancia debe ser un número."
    // }

    // if (triggerError) {
    //     erroDis.style.display = "";
    //     erroDis.innerHTML = msgError;
    //     return false;
    // } else {
    //     erroDis.style.display = "none";
    // }

    // triggerError = false

    // // validacion rangoMin
    // if (formulario.rangoMin.value.length === 0) {
    //     triggerError = true;
    //     msgError = "El rango mínimo no puede estar vacío."

    // } else if (isNaN(formulario.rangoMin.value)) {
    //     triggerError = true;
    //     msgError = "El rango mínimo debe ser un número."
    // } else if (formulario.rangoMin.value >= formulario.rangoMax.value) {
    //     triggerError = true;
    //     msgError = "El rango mínimo debe ser menor que el máximo."
    // }

    // if (triggerError) {
    //     erroRMin.style.display = "";
    //     erroRMin.innerHTML = msgError;
    //     return false;
    // } else {
    //     erroRMin.style.display = "none";
    // }

    // triggerError = false

    // // validacion rangoMax
    // if (formulario.rangoMax.value.length === 0) {
    //     triggerError = true;
    //     msgError = "El rango máximo no puede estar vacío."

    // } else if (isNaN(formulario.rangoMax.value)) {
    //     triggerError = true;
    //     msgError = "El rango máximo debe ser un número."
    // } else if (formulario.rangoMax.value <= formulario.rangoMin.value) {
    //     triggerError = true;
    //     msgError = "El rango máximo debe ser mayor que el mínimo."
    // }

    // if (triggerError) {
    //     erroRMax.style.display = "";
    //     erroRMax.innerHTML = msgError;
    //     return false;
    // } else {
    //     erroRMax.style.display = "none";
    // }

    var rol = "";
    formulario.rol.forEach(radio => {
        radio.checked ? rol = radio.value : null;
    });

    var usuario = {
        "indicativo": formulario.indicativo.value,
        "nombre": formulario.nombre.value,
        "apellido1": formulario.apellido1.value,
        "apellido2": formulario.apellido2.value,
        "email": formulario.email.value,
        "rol": rol
    };

    datos = new FormData();
    datos.append("participante", JSON.stringify(usuario))


    var respuesta = await fetch("API/usuarios.php", { method: "POST", body: datos })

    // si la respuesta de la api es 200 es que el modo ya existe
    if (respuesta.status === 200) {
        erroNom.innerHTML = msgErroNom = "Este usuario ya existe."
        erroNom.style.display = "";

    }


    if (respuesta.status === 201) {
        return true;
    } else {
        return false;
    }
}


async function editaUsuario(id, formulario) {
    // // validamos
    // var triggerError = false
    // var erroNom = document.querySelector("#error-banda-nombre");
    // var erroDis = document.querySelector("#error-banda-distancia");
    // var erroRMin = document.querySelector("#error-banda-rangoMin");
    // var erroRMax = document.querySelector("#error-banda-rangoMax");

    // // validacion Nombre
    // if (formulario.nombre.value === "") {
    //     triggerError = true;
    //     msgError = "El nombre no puede estar vacío."

    // } else if (formulario.nombre.value.length > 45) {
    //     triggerError = true;
    //     msgError = "El nombre no puede superar los 45 caracteres."

    // }

    // if (triggerError) {
    //     erroNom.style.display = "";
    //     erroNom.innerHTML = msgError;
    //     return false;
    // } else {
    //     erroNom.style.display = "none";
    // }

    // triggerError = false

    // // validacion distancia
    // if (formulario.distancia.value.length === 0) {
    //     triggerError = true;
    //     msgError = "La distancia no puede estar vacía."

    // } else if (isNaN(formulario.distancia.value)) {
    //     triggerError = true;
    //     msgError = "La distancia debe ser un número."
    // }

    // if (triggerError) {
    //     erroDis.style.display = "";
    //     erroDis.innerHTML = msgError;
    //     return false;
    // } else {
    //     erroDis.style.display = "none";
    // }

    // triggerError = false

    // // validacion rangoMin
    // if (formulario.rangoMin.value.length === 0) {
    //     triggerError = true;
    //     msgError = "El rango mínimo no puede estar vacío."

    // } else if (isNaN(formulario.rangoMin.value)) {
    //     triggerError = true;
    //     msgError = "El rango mínimo debe ser un número."
    // } else if (formulario.rangoMin.value >= formulario.rangoMax.value) {
    //     triggerError = true;
    //     msgError = "El rango mínimo debe ser menor que el máximo."
    // }

    // if (triggerError) {
    //     erroRMin.style.display = "";
    //     erroRMin.innerHTML = msgError;
    //     return false;
    // } else {
    //     erroRMin.style.display = "none";
    // }

    // triggerError = false

    // // validacion rangoMax
    // if (formulario.rangoMax.value.length === 0) {
    //     triggerError = true;
    //     msgError = "El rango máximo no puede estar vacío."

    // } else if (isNaN(formulario.rangoMax.value)) {
    //     triggerError = true;
    //     msgError = "El rango máximo debe ser un número."
    // } else if (formulario.rangoMax.value <= formulario.rangoMin.value) {
    //     triggerError = true;
    //     msgError = "El rango máximo debe ser mayor que el mínimo."
    // }

    // if (triggerError) {
    //     erroRMax.style.display = "";
    //     erroRMax.innerHTML = msgError;
    //     return false;
    // } else {
    //     erroRMax.style.display = "none";
    // }

    var rol = "";
    formulario.rol.forEach(radio => {
        radio.checked ? rol = radio.value : null;
    });

    var usuario = {
        "indicativo": formulario.indicativo.value,
        "nombre": formulario.nombre.value,
        "apellido1": formulario.apellido1.value,
        "apellido2": formulario.apellido2.value,
        "email": formulario.email.value,
        "rol": rol
    };

    var datos = { "id": id, "participante": usuario };
    var respuesta = await fetch("API/usuarios.php", { method: "PUT", headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(datos) });

    if (respuesta.status === 201) {
        return true;
    } else {
        return false;
    }
}


async function borraUsuario(id) {
    var datos = { "id": id };
    var respuesta = await fetch("API/usuarios.php", { method: "DELETE", headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(datos) });

    if (respuesta.status === 201) {
        return true;
    } else {
        return false;
    }
}