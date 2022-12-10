<?php

class Banda implements JsonSerializable
{

    private int $id;
    private string $nombre;
    private int $distancia;
    private int $rangoMin;
    private int $rangoMax;


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
     * Get the value of distancia
     */
    public function getDistancia()
    {
        return $this->distancia;
    }

    /**
     * Set the value of distancia
     *
     * @return  self
     */
    public function setDistancia($distancia)
    {
        $this->distancia = $distancia;

        return $this;
    }

    /**
     * Get the value of rangoMin
     */
    public function getRangoMin()
    {
        return $this->rangoMin;
    }

    /**
     * Set the value of rangoMin \
     * No puede ser mayor que RangoMax
     *
     * @return  self
     */
    public function setRangoMin($rangoMin)
    {
        if (!isset($this->rangoMax) || $this->rangoMax > $rangoMin) {
            $this->rangoMin = $rangoMin;
        }else {
            throw new Exception("El rango mínimo no puede ser mayor que el máximo");
        }

        return $this;
    }

    /**
     * Get the value of rangoMax
     */
    public function getRangoMax()
    {
        return $this->rangoMax;
    }

    /**
     * Set the value of rangoMax \
     * No puede ser menor que RangoMin
     *
     * @return  self
     */
    public function setRangoMax($rangoMax)
    {
        if (!isset($this->rangoMin) || $this->rangoMin < $rangoMax) {
            $this->rangoMax = $rangoMax;
        } else{
            throw new Exception("El rango máximo no puede ser menor que el mínimo");
        }

        return $this;
    }



    public function rellenaBanda(array $banda) {
        $this->setId($banda['id'])->setNombre($banda['nombre'])->
        setDistancia($banda['distancia'])->setRangoMin($banda['rangoMin'])->
        setRangoMax($banda['rangoMax']);

        return $this;
    }

    public function jsonSerialize()
    {
        $std = new stdClass();
        $std->id = $this->getId();
        $std->nombre = $this->getNombre();
        $std->distancia = $this->getDistancia();
        $std->rangoMin = $this->getRangoMin();
        $std->rangoMax = $this->getRangoMax();


        return $std;
    }
}
