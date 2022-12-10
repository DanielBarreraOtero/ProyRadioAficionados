async function rellenaTablaCalificacion(idConcurso) {
    var datos = new FormData();
    datos.append('clasificacionConcurso', true);
    datos.append('idConcurso', idConcurso);

    const respuesta = await fetch("API/listadoUsuarios.php", { method: "POST", body: datos });
    var participaciones = await respuesta.json();

    var tabla = document.querySelector(".c-concurso-page__table");
    var tbody = tabla.children[1];

    for (let i = 0; i < participaciones.length; i++) {
        const participacion = participaciones[i];

        var row = document.createElement('tr');
        var numero = document.createElement('td');
        var nombre = document.createElement('td');
        var apellidos = document.createElement('td');
        var puntos = document.createElement('td');

        numero.innerHTML = i + 1;
        nombre.innerHTML = participacion.participante.nombre;
        apellidos.innerHTML = participacion.participante.apellido1 + " " + participacion.participante.apellido2;
        puntos.innerHTML = participacion.idMensajes.length;

        row.appendChild(numero);
        row.appendChild(nombre);
        row.appendChild(apellidos);
        row.appendChild(puntos);
        tbody.appendChild(row);
    }

};


