<?php

class RepDiploma {
    
    private PDO $con;

    public function setCon(PDO $con)
    {
        $this->con = $con;
    }

    function __construct(PDO $con)
    {
        $this->setCon($con);
    }


    public function getDiplomaByID(int $id)
    {
        $query = "SELECT * FROM diploma where id = $id";

        $resul = $this->con->query($query);
        $diploma = new Diploma();

        try {
            return $diploma->mysqlToDiploma($resul->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getAllDiplomas()
    {
        $query = "SELECT * FROM diploma";

        $resul = $this->con->query($query);

        try {

            $resul = $resul->fetchAll(PDO::FETCH_ASSOC);
            $diplomas = [];
            foreach ($resul as $resultado) {
                $diploma = new Diploma();
                $diploma->mysqlToDiploma($resultado);
                array_push($diplomas, $diploma);
            }
            return $diplomas;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getConcurso(Diploma $diploma)
    {
        $rpConc = new RepConcurso($this->con);
        return $rpConc->getConcursoByID($diploma->getIdConcurso());
    }

    public function addDiploma(Diploma $diploma)
    {
        $reflect = new ReflectionClass("Diploma");
        // Cogemos la propiedades de la clase
        $propiedades = $reflect->getProperties();
        // Le quitamos el id porque la BD lo genera automaticamente
        unset($propiedades[array_search("id", $propiedades)]);

        $valores = [];

        foreach ($propiedades as $propiedad) {
            $nomPropiedad = $propiedad->name;
            $metodo = $reflect->getMethod("get" . ucfirst($nomPropiedad));
            if ($propiedad->isInitialized($diploma)) {
                $valor = $metodo->invoke($diploma);

                // si es un concurso cogemos su id
                if($nomPropiedad == "concurso") {
                    $valor = $valor->getId();
                    $nomPropiedad = $nomPropiedad."_id";
                }

                // si es string, lo rodeamos de ''
                if (!is_numeric($valor)) {
                    $valor = "'" . $valor . "'";
                }
                $valores[$nomPropiedad] = $valor;
            }
        }

        $query = "INSERT INTO diploma (" . implode(", ", array_keys($valores)) .
            ") VALUES (" . implode(", ", $valores) . ");";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function updateDiploma(array $values, int $id)
    {
        $aCambiar = "";

        foreach ($values as $key => $value) {
            // si no es un numero le añadimos las comillas
            if (!is_numeric($value)) {
                $value = "'$value'";
            }
            $aCambiar = $aCambiar . "$key = $value";

            if ($key !== array_key_last($values)) {
                $aCambiar = $aCambiar . ", ";
            }
        }

        $query = "UPDATE diploma SET $aCambiar WHERE id = $id;";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function deleteDiploma(int $id)
    {
        $query = "DELETE FROM diploma WHERE id = $id;";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }
}