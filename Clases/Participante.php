<?php

enum RolParticipante: string
{
    case user = 'user';
    case admin = 'admin';
}

class Participante implements JsonSerializable
{

    private int $id;
    private string $indicativo;
    private string $nombre;
    private string $apellido1;
    private string $apellido2;
    private string $email;
    private string $password;
    private RolParticipante $rol;
    private string $imagen;
    private array $idParticipaciones;
    private array $participaciones = [];

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of indicativo
     */
    public function getIndicativo()
    {
        return $this->indicativo;
    }

    /** 
     * Set the value of indicativo
     * 
     * El indicativo debe estar en mayúsculas, empezar por una o dos letras,
     * después un número del 0-9 y acabar en letras, que pueden ser 1-3.
     *
     * @return  self
     */
    public function setIndicativo($indicativo)
    {
        $regex = "/^[A-Z]{1,2}\d[A-Z]{1,3}$/";

        if (preg_match($regex, $indicativo) == 1) {
            $this->indicativo = $indicativo;
        }

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of apellido1
     */
    public function getApellido1()
    {
        return $this->apellido1;
    }

    /**
     * Set the value of apellido1
     *
     * @return  self
     */
    public function setApellido1($apellido1)
    {
        $this->apellido1 = $apellido1;

        return $this;
    }

    /**
     * Get the value of apellido2
     */
    public function getApellido2()
    {
        return $this->apellido2;
    }

    /**
     * Set the value of apellido2
     *
     * @return  self
     */
    public function setApellido2($apellido2)
    {
        $this->apellido2 = $apellido2;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of rol
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set the value of rol
     *
     * @return  self
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get the value of imagen
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set the value of imagen
     *
     * @return  self
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get the value of idParticipaciones
     */
    public function getIdParticipaciones()
    {
        return $this->idParticipaciones;
    }

    /**
     * Set the value of idParticipaciones
     *
     * @return  self
     */
    public function setIdParticipaciones($idParticipaciones)
    {
        $this->idParticipaciones = $idParticipaciones;

        return $this;
    }

    /**
     * Get the value of participaciones
     */
    public function getParticipaciones()
    {
        return $this->participaciones;
    }

    /**
     * Set the value of participaciones
     *
     * @return  self
     */
    public function setParticipaciones($participaciones)
    {
        $this->participaciones = $participaciones;

        return $this;
    }

    /**
     * Recibe un array asociativo y rellena el participante con los datos otorgados\
     * 
     * Parametros obligatorios:\
     * id, indicativo, nombre, apellido1, email, password, rol (string), y idParticpaciones (Array).\
     * \
     * Parametros opcionales:\
     * participaciones (Array<Participacion>), apellido2, imagen.\
     * \
     * Se devuelve a sí mismo.
     */
    public function rellenarParticipante(array $par)
    {
        $this->setId($par['id'])->setIndicativo($par['indicativo'])
            ->setNombre($par['nombre'])->setApellido1($par['apellido1'])
            ->setEmail($par['email'])->setPassword($par['password'])
            ->setIdParticipaciones($par['idParticipaciones']);

        $this->setRol($par['rol'] === 'admin' ?
            RolParticipante::admin : RolParticipante::user);

        if (isset($par['participaciones'])) {
            $this->setParticipaciones($par['participaciones']);
        }

        if (isset($par['apellido2'])) {
            $this->setApellido2($par['apellido2']);
        }

        if (isset($par['imagen'])) {
            $this->setImagen($par['imagen']);
        }

        return $this;
    }

    /**
     * Recibe el array básico que devuelve mysql, con el de idParticipaciones y rellena el objeto.\
     * Se devuelve a sí mismo.
     */
    public function mysqlToParticipante(array $mysqlArray): Participante
    {
        $this->setId($mysqlArray['id'])
            ->setIndicativo($mysqlArray['indicativo'])
            ->setNombre($mysqlArray['nombre'])
            ->setApellido1($mysqlArray['apellido1'])
            ->setEmail($mysqlArray['email'])
            ->setPassword($mysqlArray['password'])
            ->setIdParticipaciones($mysqlArray['idParticipaciones']);

        $this->setRol($mysqlArray['rol'] === 'admin' ?
            RolParticipante::admin : RolParticipante::user);

        if (isset($mysqlArray['apellido2'])) {
            $this->setApellido2($mysqlArray['apellido2']);
        }

        if (isset($mysqlArray['imagen'])) {
            $this->setImagen($mysqlArray['imagen']);
        }

        return $this;
    }

    public function jsonSerialize()
    {
        $std = new stdClass();
        $std->id = $this->getId();
        $std->indicativo = $this->getIndicativo();
        $std->nombre = $this->getNombre();
        $std->apellido1 = $this->getApellido1();
        isset($this->apellido2) ? $std->apellido2 = $this->getApellido2() : null;
        $std->email = $this->getEmail();
        $std->password = $this->getPassword();
        $std->rol = $this->getRol();
        isset($this->imagen) ? $std->imagen = $this->getImagen() : null;
        $std->idParticipaciones = $this->getIdParticipaciones();
        isset($this->participaciones) ? $std->participaciones = $this->getParticipaciones() : null;

        return $std;
    }
}
