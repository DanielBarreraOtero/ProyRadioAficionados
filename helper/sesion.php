<?php
class Sesion
{
    public static function iniciar()
    {
        session_status() === PHP_SESSION_ACTIVE ?: session_start();
    }

    public static function leer(string $clave)
    {
        self::iniciar();
        if(self::existe($clave)){
            return $_SESSION[$clave];
        } else {
            return null;
        }
    }

    public static function existe(string $clave)
    {
        self::iniciar();
        return isset($_SESSION[$clave]);
    }

    public static function escribir($clave,$valor)
    {
        self::iniciar();
        $_SESSION[$clave] = $valor;
    }

    public static function eliminar($clave)
    {
        self::iniciar();
        unset($_SESSION[$clave]);
    }
}