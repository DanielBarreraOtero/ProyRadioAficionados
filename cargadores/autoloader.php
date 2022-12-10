<?php

function autoloader($clase){

    // para cuando se cambie el wordir de apache
    // $ruta = $_SERVER["DOCUMENT_ROOT"];

    // solucion temporal para acceder desde todos los dispositivos
    // coge la ruta de la carpeta 2 niveles por encima de el archivo actual
    $ruta = dirname(__FILE__,2);

    if(file_exists("$ruta/Clases/$clase.php")){
        require_once "$ruta/Clases/$clase.php";
    } else if(file_exists("$ruta/helper/$clase.php")){
        require_once "$ruta/helper/$clase.php";
    } else if(file_exists("$ruta/baseDatos/$clase.php")){
        require_once "$ruta/baseDatos/$clase.php";
    } else if(file_exists("$ruta/baseDatos/repositorios/$clase.php")){
        require_once "$ruta/baseDatos/repositorios/$clase.php";
    }
}

spl_autoload_register("autoloader");