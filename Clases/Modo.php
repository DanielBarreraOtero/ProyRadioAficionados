<?php

class Modo implements JsonSerializable{

    private int $id;
    private string $nombre;

    

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


    public function rellenaModo(array $modo) {
        $this->setId($modo['id'])->setNombre($modo['nombre']);

        return $this;
    }

    public function jsonSerialize()
    {
        $std = new stdClass();
        $std->id = $this->getId();
        $std->nombre = $this->getNombre();

        return $std;
    }
}