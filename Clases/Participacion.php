<?php

enum RolParticipacion: string
{
    case concursante = "concursante";
    case juez = "juez";
}

class Participacion implements JsonSerializable
{

    private int $id;
    private RolParticipacion $rol;
    private Point $gps;
    private int $idConcurso;
    private Concurso $concurso;
    private int $idParticipante;
    private Participante $participante;
    private array $idMensajes = [];
    private array $mensajes;
    private array $idPremios = [];
    private array $premios;
    private int $idDiploma;
    private Diploma $diploma;

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
     * Get the value of gps
     */
    public function getGps()
    {
        return $this->gps;
    }

    /**
     * Set the value of gps
     *
     * @return  self
     */
    public function setGps($gps)
    {
        $this->gps = $gps;

        return $this;
    }

    /**
     * Get the value of idConcurso
     */
    public function getIdConcurso()
    {
        return $this->idConcurso;
    }

    /**
     * Set the value of idConcurso
     *
     * @return  self
     */
    public function setIdConcurso($idConcurso)
    {
        $this->idConcurso = $idConcurso;

        return $this;
    }

    /**
     * Get the value of idConcurso
     */
    public function getConcurso()
    {
        return $this->concurso;
    }

    /**
     * Set the value of idConcurso
     *
     * @return  self
     */
    public function setConcurso($concurso)
    {
        $this->concurso = $concurso;

        return $this;
    }

    /**
     * Get the value of idParticipante
     */
    public function getIdParticipante()
    {
        return $this->idParticipante;
    }

    /**
     * Set the value of idParticipante
     *
     * @return  self
     */
    public function setIdParticipante($idParticipante)
    {
        $this->idParticipante = $idParticipante;

        return $this;
    }

    /**
     * Get the value of idParticipante
     */
    public function getParticipante()
    {
        return $this->participante;
    }

    /**
     * Set the value of idParticipante
     *
     * @return  self
     */
    public function setParticipante($participante)
    {
        $this->participante = $participante;

        return $this;
    }

    /**
     * Get the value of idMensajes
     */
    public function getIdMensajes()
    {
        return $this->idMensajes;
    }

    /**
     * Set the value of idMensajes
     *
     * @return  self
     */
    public function setIdMensajes($idMensajes)
    {
        $this->idMensajes = $idMensajes;

        return $this;
    }

    /**
     * Get the value of mensajes
     */
    public function getMensajes()
    {
        return $this->mensajes;
    }

    /**
     * Set the value of mensajes
     *
     * @return  self
     */
    public function setMensajes($mensajes)
    {
        $this->mensajes = $mensajes;

        return $this;
    }

    /**
     * Get the value of idPremio
     */
    public function getIdPremios()
    {
        return $this->idPremios;
    }

    /**
     * Set the value of idPremio
     *
     * @return  self
     */
    public function setIdPremios($idPremios)
    {
        $this->idPremios = $idPremios;

        return $this;
    }

    /**
     * Get the value of premio
     */
    public function getPremios()
    {
        return $this->premios;
    }

    /**
     * Set the value of premio
     *
     * @return  self
     */
    public function setPremios($premios)
    {
        $this->premios = $premios;

        return $this;
    }

    /**
     * Get the value of idDiploma
     */
    public function getIdDiploma()
    {
        return $this->idDiploma;
    }

    /**
     * Set the value of idDiploma
     *
     * @return  self
     */
    public function setIdDiploma($idDiploma)
    {
        $this->idDiploma = $idDiploma;

        return $this;
    }

    /**
     * Get the value of diploma
     */
    public function getDiploma()
    {
        return $this->diploma;
    }

    /**
     * Set the value of diploma
     *
     * @return  self
     */
    public function setDiploma($diploma)
    {
        $this->diploma = $diploma;

        return $this;
    }

    /**
     * Dado un array con los datos necesarios, rellena la participacion con estos.\
     * \
     * Parametros obligatorios:\
     * id,gps (Point), idConcurso, rol (RolParticipacion), idParticipante.\
     * \
     * Parametros opcionales:\
     * idMensajes, mensajes, idPremios, premios, idDiploma, diploma
     */
    public function rellenarParticipacion(array $participacion)
    {
        $this->setId($participacion['id'])->setGps($participacion['gps'])
            ->setIdConcurso($participacion['idConcurso'])
            ->setRol($participacion['rol'])
            ->setIdParticipante($participacion['idParticipante']);

        if (isset($participacion['idMensajes'])) {
            $this->setIdMensajes($participacion['idMensajes']);
        }
        if (isset($participacion['mensajes'])) {
            $this->setMensajes($participacion['mensajes']);
        }

        if (isset($participacion['idPremios'])) {
            $this->setIdPremios($participacion['idPremios']);
        }
        if (isset($participacion['premios'])) {
            $this->setPremios($participacion['premios']);
        }

        if (isset($participacion['idDiploma'])) {
            $this->setIdDiploma($participacion['idDiploma']);
        }
        if (isset($participacion['diploma'])) {
            $this->setDiploma($participacion['diploma']);
        }
    }


    /**
     * Devuelve un array formateado con los campos necesarios para la tabla
     * de mysql
     */
    public function toMysqlArray()
    {
        $rol = $this->getRol()->value;
        $puntoX = $this->getGps()->getX();
        $puntoY = $this->getGps()->getY();
        $idConcurso = $this->getIdConcurso();
        $idParticipante = $this->getIdParticipante();

        return array(
            "rol" => $rol, "puntoX" => $puntoX, "puntoY" => $puntoY,
            "concursos_id" => $idConcurso, "participantes_id" => $idParticipante
        );
    }

    public function mysqlToParticipacion(array $mysqlArray): Participacion
    {
        $this->setId($mysqlArray['id'])
            ->setIdConcurso($mysqlArray['concursos_id'])
            ->setIdParticipante($mysqlArray['participantes_id']);

        $this->setRol($mysqlArray['rol'] === 'juez' ?
            RolParticipacion::juez : RolParticipacion::concursante);

        $gps = new Point($mysqlArray['X(gps)'], $mysqlArray['Y(gps)']);
        $this->setGps($gps);

        if (isset($mysqlArray['idMensajes'])) {
            $this->setIdMensajes($mysqlArray['idMensajes']);
        }

        if (isset($mysqlArray['IdPremios'])) {
            $this->setIdPremios($mysqlArray['idPremios']);
        }

        if (isset($mysqlArray['idDiploma'])) {
            $this->setIdDiploma($mysqlArray['idDiploma']);
        }

        return $this;
    }

    public function jsonSerialize()
    {
        $std = new stdClass();
        $std->id = $this->getId();
        $std->rol = $this->getRol();
        $std->gps = $this->getGps();
        $std->idConcurso = $this->getIdConcurso();
        isset($this->concurso)? $std->concurso = $this->getConcurso(): null;
        $std->idParticipante = $this->getIdParticipante();
        isset($this->participante)? $std->participante = $this->getParticipante(): null;
        $std->idMensajes = $this->getIdMensajes();
        isset($this->mensajes)? $std->mensajes = $this->getMensajes(): null;
        isset($this->idPremios)? $std->idPremios = $this->getIdPremios(): null;
        isset($this->premios)? $std->premios = $this->getPremios(): null;
        isset($this->idDiploma)? $std->idDiploma = $this->getIdDiploma(): null;
        isset($this->diploma)? $std->diploma = $this->getDiploma(): null;

        return $std;
    }
}

