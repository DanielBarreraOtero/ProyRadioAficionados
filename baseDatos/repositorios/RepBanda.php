<?php

class RepBanda
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


    public function getBandaByID(int $id)
    {
        $query = "SELECT * FROM banda where id = $id";

        $resul = $this->con->query($query);

        try {
            $banda = new Banda();
            return $banda->rellenaBanda($resul->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getAllBandas()
    {
        $query = "SELECT * FROM banda";

        $resul = $this->con->query($query);

        try {
            $bandas = [];
            foreach ($resul->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $banda = new Banda();
                $banda->rellenaBanda($row);
                array_push($bandas,$banda);
            }
            return $bandas;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function addBanda(Banda $banda)
    {
        $reflect = new ReflectionClass("Banda");
        // Cogemos la propiedades de la clase
        $propiedades = $reflect->getProperties();
        // Le quitamos el id porque la BD lo genera automaticamente
        unset($propiedades[array_search("id", $propiedades)]);

        $valores = [];

        // Por cada propiedad de banda, comprobamos si esta definida
        // si lo esta guardamos su nombre y su valor en un array
        foreach ($propiedades as $propiedad) {
            $metodo = $reflect->getMethod("get" . ucfirst($propiedad->name));
            if ($propiedad->isInitialized($banda)) {
                $valor = $metodo->invoke($banda);

                // si es string, lo rodeamos de ''
                if (!is_numeric($valor)) {
                    $valor = "'" . $valor . "'";
                }
                $valores[$propiedad->name] = $valor;
            }
        }

        // generamos la query con los valores de banda que 
        // estuviesen definidos
        $query = "INSERT INTO banda (" . implode(", ", array_keys($valores)) .
            ") VALUES (" . implode(", ", $valores) . ");";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function updateBanda(array $values, int $id)
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

        $query = "UPDATE banda SET $aCambiar WHERE id = $id;";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function deleteBanda(int $id)
    {
        $query = "DELETE FROM banda WHERE id = $id;";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
