<?php

class RepPremio
{

    private PDO $con;

    public function setCon(PDO $con)
    {
        $this->con = $con;
    }

    function __construct(PDO $con)
    {
        $this->setCon($con);
    }

    public function getPremioByID(int $id)
    {
        $query = "SELECT * FROM modo_concurso where id = $id";

        $resul = $this->con->query($query);

        try {
            $premio = new Premio();
            return $premio->rellenaPremio($resul->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getAllPremios()
    {
        $query = "SELECT * FROM modo_concurso";

        $resul = $this->con->query($query);

        try {
            $premios = [];
            foreach ($resul->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $premio = new Premio();
                $premio->rellenaPremio($row);
                array_push($premios, $premio);
            }
            return $premios;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getConcurso(Premio $premio)
    {
        $rpConc = new RepConcurso($this->con);
        return $rpConc->getConcursoByID($premio->getIdConcurso());
    }

    public function getModo(Premio $premio)
    {
        $rpModo = new RepModo($this->con);
        return $rpModo->getModoByID($premio->getIdModo());
    }

    public function addPremio(Premio $premio)
    {
        $reflect = new ReflectionClass("Premio");
        // Cogemos la propiedades de la clase
        $propiedades = $reflect->getProperties();
        // Le quitamos el id porque la BD lo genera automaticamente
        foreach ($propiedades as $propiedad => $valor) {
            if (
                $valor->name === "id" || $valor->name === "modo" ||
                $valor->name === "concurso"
            ) {
                unset($propiedades[$propiedad]);
            }
        }

        $valores = [];

        foreach ($propiedades as $propiedad) {
            $nomPropiedad = $propiedad->name;
            $metodo = $reflect->getMethod("get" . ucfirst($nomPropiedad));
            if ($propiedad->isInitialized($premio)) {
                $valor = $metodo->invoke($premio);

                if ($nomPropiedad === 'idConcurso') {
                    $nomPropiedad = 'concurso_id';
                }

                if ($nomPropiedad === 'idModo') {
                    $nomPropiedad = 'modo_id';
                }

                // si es string, lo rodeamos de ''
                if (!is_numeric($valor)) {
                    $valor = "'" . $valor . "'";
                }

                $valores[$nomPropiedad] = $valor;
            }
        }

        $query = "INSERT INTO modo_concurso (" . implode(", ", array_keys($valores)) .
            ") VALUES (" . implode(", ", $valores) . ");";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * Updatea la tabla modo_concurso \
     * Importante que los nombres de array coincidan con los nombres \
     * de las columnas de la tabla modo_concurso
     */
    public function updatePremio(array $values, int $id)
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

        $query = "UPDATE modo_concurso SET $aCambiar WHERE id = $id;";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function deletePremio(int $id)
    {
        $query = "DELETE FROM modo_concurso WHERE id = $id;";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
