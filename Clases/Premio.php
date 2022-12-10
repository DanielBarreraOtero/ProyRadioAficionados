<?php

class Premio implements JsonSerializable{

    private int $id;
    private string $nombre;
    private int $idConcurso;
    private Concurso $concurso;
    private int $idModo;
    private Modo $modo;
    // opcionales
    private string $indicativoGanadador;
    private string $nombreGanadador;
    private string $apellido1Ganadador;
    private string $apellido2Ganadador;


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
     * Get the value of modo
     */ 
    public function getModo()
    {
        return $this->modo;
    }

    /**
     * Set the value of modo
     *
     * @return  self
     */ 
    public function setModo($modo)
    {
        $this->modo = $modo;

        return $this;
    }

    /**
     * Get the value of indicativoGanadador
     */ 
    public function getIndicativoGanadador()
    {
        return $this->indicativoGanadador;
    }

    /**
     * Set the value of indicativoGanadador
     *
     * @return  self
     */ 
    public function setIndicativoGanadador($indicativoGanadador)
    {
        $this->indicativoGanadador = $indicativoGanadador;

        return $this;
    }

    /**
     * Get the value of nombreGanadador
     */ 
    public function getNombreGanadador()
    {
        return $this->nombreGanadador;
    }

    /**
     * Set the value of nombreGanadador
     *
     * @return  self
     */ 
    public function setNombreGanadador($nombreGanadador)
    {
        $this->nombreGanadador = $nombreGanadador;

        return $this;
    }

    /**
     * Get the value of apellido1Ganadador
     */ 
    public function getApellido1Ganadador()
    {
        return $this->apellido1Ganadador;
    }

    /**
     * Set the value of apellido1Ganadador
     *
     * @return  self
     */ 
    public function setApellido1Ganadador($apellido1Ganadador)
    {
        $this->apellido1Ganadador = $apellido1Ganadador;

        return $this;
    }

    /**
     * Get the value of apellido2Ganadador
     */ 
    public function getApellido2Ganadador()
    {
        return $this->apellido2Ganadador;
    }

    /**
     * Set the value of apellido2Ganadador
     *
     * @return  self
     */ 
    public function setApellido2Ganadador($apellido2Ganadador)
    {
        $this->apellido2Ganadador = $apellido2Ganadador;

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
     * Get the value of concurso
     */ 
    public function getConcurso()
    {
        return $this->concurso;
    }

    /**
     * Set the value of concurso
     *
     * @return  self
     */ 
    public function setConcurso($concurso)
    {
        $this->concurso = $concurso;

        return $this;
    }

    public function rellenaPremio(array $premio) {
        $this->setId($premio['id'])->setNombre($premio['nombre'])->
        setIdModo($premio['modo_id'])->setIdConcurso($premio['concurso_id']);

        if (isset($premio['modo'])){
            $this->setModo($premio['modo']);
        }

        if (isset($premio['concurso'])){
            $this->setConcurso($premio['concurso']);
        }

        if (isset($premio['indicativoGanador'])){
            $this->setIndicativoGanadador($premio['indicativoGanador']);
        }

        if (isset($premio['nombreGanadador'])){
            $this->setNombreGanadador($premio['nombreGanadador']);
        }

        if (isset($premio['apellido1Ganadador'])){
            $this->setApellido1Ganadador($premio['apellido1Ganadador']);
        }

        if (isset($premio['apellido2Ganadador'])){
            $this->setApellido2Ganadador($premio['apellido2Ganadador']);
        }
        return $this;
    }


    public function jsonSerialize()
    {
        $std = new stdClass();
        $std->id = $this->getId();
        $std->nombre = $this->getNombre();
        $std->idModo= $this->getIdModo();
        (isset($this->modo))?  $std->modo= $this->getModo(): null;
        $std->idConcurso= $this->getIdConcurso();
        (isset($this->concurso))? $std->concurso= $this->getConcurso(): null;
        (isset($this->indicativoGanador))? $std->indicativoGanador= $this->getIndicativoGanadador(): null;
        (isset($this->nombreGanadador))? $std->nombreGanadador= $this->getNombreGanadador(): null;
        (isset($this->apellido1Ganadador))? $std->apellido1Ganadador= $this->getApellido1Ganadador(): null;
        (isset($this->apellido2Ganadador))? $std->apellido2Ganadador= $this->getApellido2Ganadador(): null;

        return $std;
    }
}