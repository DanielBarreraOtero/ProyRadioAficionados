<?php
class Principal
{
    public static function main()
    {
        require_once './cargadores/autoloader.php';
        require_once './Vistas/Principal/layout.php';
    }
}
Principal::main();
?>
