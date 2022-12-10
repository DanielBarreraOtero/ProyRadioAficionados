<?php

class Point implements JsonSerializable {

    private float $x;
    private float $y;


    /**
     * Get the value of x
     */ 
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set the value of x
     *
     * @return  self
     */ 
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get the value of y
     */ 
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set the value of y
     *
     * @return  self
     */ 
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    public function __construct(float $x, float $y) {
        $this->setX($x);
        $this->setY($y);
    }

    public function jsonSerialize()
    {
        $std = new stdClass();
        $std->X = $this->getX();
        $std->Y = $this->getY();

        return $std;
    }
}