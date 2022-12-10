<?php

enum Categoria: string
{
    case oro = "oro";
    case plata = "plata";
    case bronce = "bronce";
}

class Diploma implements JsonSerializable
{

    private int $id;
    private int $idConcurso;
    private Concurso $concurso;
    private Categoria $categoria;
    private int $minPts;
    private string $img;



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

    /**
     * Get the value of categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set the value of categoria
     *
     * @return  self
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get the value of minPts
     */
    public function getMinPts()
    {
        return $this->minPts;
    }

    /**
     * Set the value of minPts
     *
     * @return  self
     */
    public function setMinPts($minPts)
    {
        $this->minPts = $minPts;

        return $this;
    }

    /**
     * Get the value of img
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set the value of img
     *
     * @return  self
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Rellena el objeto con los datos otorgados en el array.\
     * Parametros obligatorios:\
     * id, categoria (Categoria), minPts, idConcurso.\
     * \
     * Parametros opcionales:\
     * img, concurso (Concurso).
     */
    public function rellenaDiploma(array $diploma): void
    {
        $this->setId($diploma['id'])->setCategoria($diploma['categoria'])->setMinPts($diploma['minPts'])->setIdConcurso($diploma['idConcurso']);

        if (isset($diploma['img'])) {
            $this->setImg($diploma['img']);
        }

        if (isset($diploma['concurso'])) {
            $this->setConcurso($diploma['concurso']);
        }
    }


    public function mysqlToDiploma(array $mysqlArray): Diploma
    {
        $this->setId($mysqlArray['id'])
            ->setMinPts($mysqlArray['minPts'])
            ->setIdConcurso($mysqlArray['concurso_id']);

        if ($mysqlArray['categoria'] === 'oro') {
            $categoria = Categoria::oro;
        } else if ($mysqlArray['categoria'] === 'plata') {
            $categoria = Categoria::plata;
        } else {
            $categoria = Categoria::bronce;
        }
        $this->setCategoria($categoria);

        if (isset($mysqlArray['imagen'])) {
            $this->setImg($mysqlArray['imagen']);
        }

        return $this;
    }

    public function jsonSerialize()
    {
        $std = new stdClass();
        $std->id = $this->getId();
        $std->minPts = $this->getMinPts();
        $std->idConcurso = $this->getIdConcurso();
        $std->categoria = $this->getCategoria();
        (isset($this->img))?  $std->img = $this->getImg(): null;


        return $std;
    }
}
