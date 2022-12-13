window.addEventListener("load", function () {
    // cogemos todos los elementos
    const btn = document.querySelector(".c-burgerButton");
    const lineas = document.querySelectorAll(".c-burgerButton__icon>*");
    const nav = document.querySelector('.c-nav');

    const cuerpo = document.querySelector('#cuerpo');
    const links = document.querySelectorAll('.c-nav__link');

    btn.addEventListener("click", () => {
        // controla la animacion del svg
        animacionBtn(btn, lineas);
        // controla la animacion de nav
        animacionNav(nav, btn);
    });
    
    // controla que si se clicka fuera de el nav se cierre el menu
    cuerpo.addEventListener("click", () => {
        if (btn.getAttribute('aria-expanded') === "true") {
            animacionBtn(btn, lineas);
            animacionNav(nav, btn);
        }
    });

    // controla que si se clicka en alguno de los links se cierre el menu
    links.forEach(link => {
        link.addEventListener("click", () => {
            if (btn.getAttribute('aria-expanded') === "true") {
                animacionBtn(btn, lineas);
                animacionNav(nav, btn);
            }
        });
    });
});

function animacionBtn(btn, lineas) {
    // Si esta cerrado
    if (btn.getAttribute('aria-expanded') === "false") {
        for (let i = 0; i < lineas.length; i++) {
            // a cada linea se le da su variante de pulsado, se le cambia
            // el tamaño y se la mueve al centro
            lineas[i].className.baseVal = lineas[i].className.baseVal + "--pulsado";
            lineas[i].width.baseVal.value = 15;
            lineas[i].x.baseVal.value = 42.5;
        }
        btn.setAttribute('aria-expanded', "true");
        // Si esta abierto
    } else {
        for (let i = 0; i < lineas.length; i++) {
            // se hace lo contrario que en el bucle anterior
            lineas[i].className.baseVal = lineas[i].className.baseVal.replace("--pulsado", "");
            lineas[i].width.baseVal.value = 80;
            lineas[i].x.baseVal.value = 10;
        }
        btn.setAttribute('aria-expanded', "false");
    }
}

function animacionNav(nav, btn) {

    if (btn.getAttribute('aria-expanded') === "false") {
        // Si se va a cerrar, le quitamos la clase para que haga la transicion de cerrar
        nav.classList.toggle('c-nav--abierto');
        // esperamos 500ms a que se realice y despues le hacemos display none para que no se pueda seleccionar con el tabulador
        setTimeout(() => { nav.style.display = 'none' }, 500);
    } else {
        // si se deberia de abrir, le quitamos el display por si esta en none
        nav.style.display = ''
        // esperamos 5ms para que la linea anterior tenga efecto y despues le ponemos la clase abierto
        setTimeout(() => { nav.classList.toggle('c-nav--abierto') }, 5);
    }
}