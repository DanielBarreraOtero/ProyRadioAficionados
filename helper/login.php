<?php
class Login
{
    /**
     * Comprueba que el login sea correcto, si es así lo añade a la sesión y \
     * settea la cookie de recuerdame si se le indica.
     * @return boolean
     */
    public static function Identifica(PDO $con, string $usuario, string $contrasena, bool $recuerdame = false): bool
    {
        // Si ExisteUsuario(usuario,contraseña)
        if ($id = self::ExisteUsuario($con, $usuario, $contrasena)) {
            //  cojo el usuario entero de la base de datos
            $rpParticipante = new RepParticipante($con);
            $participante = $rpParticipante->getParticipanteByID($id);

            Sesion::escribir("login", true);
            Sesion::escribir("participante", $participante);
            Sesion::escribir("rol", $participante->getRol()->value);

            if ($recuerdame) {
                // setteo la cookie con el usuario y la contraseña
                $std = new stdClass();
                $std->usuario = $usuario;
                $std->contrasena = $contrasena;
                setcookie("recuerdame", json_encode($std), time() + 60 * 60 * 24 * 30);
            }

            return true;
        }
        Sesion::escribir("login", false);
        Sesion::eliminar("participante");
        Sesion::escribir("rol", "guest");

        return false;
    }

    /**
     * Comprueba en la base de datos que un usuario y contraseña sean correctos
     * @return int id / 0 = false
     */
    private static function ExisteUsuario(PDO $con, string $usuario, string $contrasena): int
    {
        $rpParticipante = new RepParticipante($con);
        return $rpParticipante->estaRegistrado($usuario, $contrasena);
    }

    /**
     * Comrpueba si el usuario tiene una sesión activa \
     * @return boolean
     */
    public static function UsuarioEstaLogueado(): bool
    {
        return (Sesion::existe('login') && Sesion::leer('login')) ? true : false;
    }

    /**
     * Comprueba si el usuario tiene una cookie de recuerdame \
     * si es así coge el usuario y contraseña de esta y lo intenta logear \
     * @return boolean
     */
    public static function UsuarioRecordado($con): bool
    {
        // Si existe la cookie de recuerdame
        if (isset($_COOKIE['recuerdame'])) {
            $data = json_decode($_COOKIE['recuerdame']);
            return self::Identifica($con, $data->usuario, $data->contrasena, true);
        }
        return false;
    }
}
