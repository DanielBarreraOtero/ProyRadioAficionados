<?php

class RepModo
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


    public function getModoByID(int $id)
    {
        $query = "SELECT * FROM modo where id = $id";

        $resul = $this->con->query($query);

        $modo = new Modo();
        try {
            return $modo->rellenaModo($resul->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            throw $e;
        }
        
    }

    public function getAllModos()
    {
        $query = "SELECT * FROM modo";

        $resul = $this->con->query($query);


        try {
            $modos = [];

            foreach ($resul->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $modo = new Modo();
                $modo->rellenaModo($row);
                array_push($modos, $modo);
            }

            return $modos;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function addModo(Modo $modo)
    {
        $nomModo = $modo->getNombre();
        $query = "INSERT INTO modo (`nombre`) VALUES ('$nomModo');";

        return $this->con->exec($query);
    }

    public function updateModo(array $values, int $id)
    {
        $aCambiar = "";

        foreach ($values as $key => $value) {
            $aCambiar = $aCambiar . "$key = '$value'";

            if ($key !== array_key_last($values)) {
                $aCambiar = $aCambiar . ", ";
            }
        }

        $query = "UPDATE modo SET $aCambiar WHERE id = $id;";

        return $this->con->exec($query);
    }

    public function deleteModo(int $id)
    {
        $query = "DELETE FROM modo WHERE id = $id;";

        return $this->con->exec($query);
    }
}
