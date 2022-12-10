<?php
class GBD
{
    private static $conexion;

    /**
     * Constructor donde se crea la conexión
     *
     * @param string $host url del servidor
     * @param string $basedatos nombre de la base de datos
     * @param string $usuario
     * @param string $password
     * @param string $driver driver para el servidor de base de datos
     */
    public static function getConnection(
        string $host,
        string $basedatos,
        string $usuario = 'root',
        string $password = '',
        string $driver = "mysql"
    ) {
        if (!isset(self::$conexion)) {
            $dsn = $driver . ":dbname=" . $basedatos . ";host=" . $host;
            
            try {
                self::$conexion = new PDO(
                    $dsn,
                    $usuario,
                    $password,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );

                return self::$conexion;
            } catch (PDOException $e) {
                throw new PDOException("Error en la conexión: " . $e->getMessage());
            }
        } else {
            return self::$conexion;
        }
    }
}
