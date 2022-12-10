<?php
if (isset($_GET['menu'])) {
    // if ($_GET['menu'] == "inicio") {
    //     require_once './Vistas/Principal/main.php';
    // }
    if ($_GET['menu'] == "login") {
        require_once './Vistas/Login/autentifica.php';
    }
    if ($_GET['menu'] == "registro") {
        require_once './Vistas/Login/registro.php';
    }
    if ($_GET['menu'] == "cerrarsesion") {
        require_once './Vistas/Login/cerrarsesion.php';
    }
    if ($_GET['menu'] == "denegado") {
        require_once './Vistas/Error/denegado.php';
    }
    if ($_GET['menu'] == "mantenimiento") {
        require_once './Vistas/mantenimiento/mantenimiento.php';
    }
} else {
    require_once './Vistas/Principal/main.php';
}

    
    //Añadir otras rutas
