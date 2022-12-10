window.addEventListener('load', () => {

    var cuerpo = document.querySelector('#cuerpo');
    var linkConcursos = document.querySelector('#link-mantenimientoConc');
    var linkBandasModos = document.querySelector('#link-mantenimientoBandaModo');

    

    linkConcursos.addEventListener('click', () => {
        fetch("Vistas/Mantenimiento/ConcursoM.php", { method: "GET" }).then(async (respuesta) => {
            // cuando le llega cambia el contenido de la pagina principal por lo que se recibe
            cuerpo.innerHTML = await respuesta.text();
        }).then(async () => {
            // Llama al metodo que se encarga de rellenar la página
            makeMantenimientoConcursos();
        });
    });

    
    linkBandasModos.addEventListener('click', () => {
        fetch("Vistas/Mantenimiento/BandaModoM.php", { method: "GET" }).then(async (respuesta) => {
            // cuando le llega cambia el contenido de la pagina principal por lo que se recibe
            cuerpo.innerHTML = await respuesta.text();
        }).then(async () => {
            // Llama al metodo que se encarga de rellenar la página
            makeMantenimientoBandaModo();
        });
    });

});

