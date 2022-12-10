window.addEventListener('load', function() {

    const tarjetas = this.document.querySelectorAll(".c-card-concurso");

    // Programamos el onclick de cada tarjeta
    for (let i = 0; i < tarjetas.length; i++) {
        const tarjeta = tarjetas[i];
        var id = tarjeta.getAttribute("concid");

        tarjeta.addEventListener('click', () => {
            var cuerpo = document.querySelector('#cuerpo');
            var datos = new FormData();
            datos.append("idConcurso",id);

            // cuando se clicke pide la pagina de un concurso en especifico
            fetch("Vistas/Principal/pageConcurso.php",{method:"POST",body: datos}).then(async respuesta => {
                // cuando le llega cambia el contenido de la pagina principal por la pagina de concurso
                cuerpo.innerHTML = await respuesta.text();
            }).then(() => {
                // una vez la haya cambiado llamamos al metodo que pinta la tabla de clasificacion del concurso
                rellenaTablaCalificacion(id);
            });


        });

        //      HACER QUE CUANDO SE PASE EL RATON POR ENCIMA SE APLIQUEN EFECTOS DE HOVER
        // tarjeta.addEventListener('mouseover', () => {
        //     tarjeta.style.backgroundColor = "red";
        // });

        // tarjeta.addEventListener('mouseout', () => {
        //     tarjeta.style.backgroundColor = "black";
        // });
    }
});
