<?php

class Mensaje implements JsonSerializable
{

    private int $id;
    private DateTimeImmutable $hora;
    private int $idParticipacion;
    private Participacion $participacion;
    private int $indicativoJuez;
    private int $idModo;
    private Modo $modo;
    private int $idBanda;
    private Banda $banda;


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
     * Get the value of hora
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set the value of hora
     *
     * @return  self
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get the value of idParticipacion
     */
    public function getIdParticipacion()
    {
        return $this->idParticipacion;
    }

    /**
     * Set the value of idParticipacion
     *
     * @return  self
     */
    public function setIdParticipacion($idParticipacion)
    {
        $this->idParticipacion = $idParticipacion;

        return $this;
    }

    /**
     * Get the value of idParticipacion
     */
    public function getParticipacion()
    {
        return $this->participacion;
    }

    /**
     * Set the value of idParticipacion
     *
     * @return  self
     */
    public function setParticipacion($participacion)
    {
        $this->participacion = $participacion;

        return $this;
    }

    /**
     * Get the value of indicativoJuez
     */
    public function getIndicativoJuez()
    {
        return $this->indicativoJuez;
    }

    /**
     * Set the value of indicativoJuez
     *
     * @return  self
     */
    public function setIndicativoJuez($indicativoJuez)
    {
        $this->indicativoJuez = $indicativoJuez;

        return $this;
    }

    /**
     * Get the value of idModo
     */
    public function getIdModo()
    {
        return $this->idModo;
    }

    /**
     * Set the value of idModo
     *
     * @return  self
     */
    public function setIdModo($idModo)
    {
        $this->idModo = $idModo;

        return $this;
    }

    /**
     * Get the value of idModo
     */
    public function getModo()
    {
        return $this->modo;
    }

    /**
     * Set the value of idModo
     *
     * @return  self
     */
    public function setModo($modo)
    {
        $this->modo = $modo;

        return $this;
    }

    /**
     * Get the value of idBanda
     */
    public function getIdBanda()
    {
        return $this->idBanda;
    }

    /**
     * Set the value of idBanda
     *
     * @return  self
     */
    public function setIdBanda($idBanda)
    {
        $this->idBanda = $idBanda;

        return $this;
    }

    /**
     * Get the value of idBanda
     */
    public function getBanda()
    {
        return $this->banda;
    }

    /**
     * Set the value of idBanda
     *
     * @return  self
     */
    public function setBanda($banda)
    {
        $this->banda = $banda;

        return $this;
    }

    /**
     * Devuelve un array formateado con los campos necesarios para la tabla
     * de mysql
     */
    public function toMysqlArray()
    {
        $hora = $this->getHora()->format("Y-m-d H:i:s");
        $idParticipacion = $this->getIdParticipacion();
        $indicativoJuez = $this->getIndicativoJuez();
        $idModo = $this->getIdModo();
        $idBanda = $this->getIdBanda();

        return array(
            "hora" => $hora, "participacion_id" => $idParticipacion,
            "indicativoJuez" => $indicativoJuez,
            "modo_id" => $idModo, "banda_id" => $idBanda
        );
    }

    /**
     * Dado un array con los datos necesarios, rellena la participacion con estos.\
     * \
     * Parametros obligatorios:\
     * id, hora, idParticipacion, indicativoJuez, idModo, idBanda.\
     * \
     * Parametros opcionales:\
     * participacion, modo, banda.
     */
    public function rellenaMensaje(array $mensaje): void
    {
        $this->setId($mensaje['id'])->setHora($mensaje['hora'])
            ->setIdParticipacion($mensaje['idParticipacion'])
            ->setIndicativoJuez($mensaje['indicativoJuez'])
            ->setIdModo($mensaje['idModo'])->setIdBanda($mensaje['idBanda']);

        if (isset($mensaje['participacion'])) {
            $this->setParticipacion($mensaje['participacion']);
        }

        if (isset($mensaje['modo'])) {
            $this->setModo($mensaje['modo']);
        }

        if (isset($mensaje['banda'])) {
            $this->setIdBanda($mensaje['banda']);
        }
    }

    public function mysqlToMensaje(array $mysqlArray): Mensaje
    {
        $this->setId($mysqlArray['id'])
            ->setIdParticipacion($mysqlArray['participacion_id'])
            ->setIndicativoJuez($mysqlArray['indicativoJuez'])
            ->setIdModo($mysqlArray['modo_id'])->setIdBanda($mysqlArray['banda_id']);

        $this->setHora(new DateTimeImmutable($mysqlArray['hora']));

        return $this;
    }

    public function jsonSerialize()
    {
        $std = new stdClass();
        $std->id = $this->getId();
        $std->idParticipacion = $this->getIdParticipacion();
        $std->indicativoJuez = $this->getIndicativoJuez();
        $std->idModo = $this->getIdModo();
        $std->idBanda = $this->getIdBanda();
        $std->idHora = $this->getHora();



        return $std;
    }
}
