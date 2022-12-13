<?php

class RepParticipante
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


    public function getParticipanteByID(int $id): Participante
    {
        $query = "SELECT * FROM participantes where id = $id";

        $resul = $this->con->query($query);

        try {
            $arrayDatos = $resul->fetch(PDO::FETCH_ASSOC);
            $arrayDatos['idParticipaciones'] = self::getIdParticipaciones($id);
            $participante = new Participante();
            return $participante->mysqlToParticipante($arrayDatos);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getAllParticipantes()
    {
        $query = "SELECT * FROM participantes";

        $resul = $this->con->query($query);

        try {
            $resul = $resul->fetchAll(PDO::FETCH_ASSOC);
            $participantes = [];
            foreach ($resul as $resultado) {
                $participante = new Participante();
                $resultado['idParticipaciones'] = self::getiDParticipaciones($resultado['id']);
                $participante->mysqlToParticipante($resultado);
                array_push($participantes, $participante);
            }
            return $participantes;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getiDParticipaciones(int $id): array
    {
        $query = "SELECT po.id FROM participantes p JOIN participacion po
                  ON p.id=po.participantes_id WHERE p.id = $id";

        $resul = $this->con->query($query);

        try {
            $idParticipaciones = [];
            while ($row = $resul->fetch()) {
                array_push($idParticipaciones, $row[0]);
            }
            return $idParticipaciones;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getParticipaciones(Participante $participante): array
    {
        $rpParticipaciones = new RepParticipacion($this->con);
        $participaciones = [];
        foreach ($participante->getiDParticipaciones() as $id) {
            $participacion = $rpParticipaciones->getParticipacionByID($id);
            array_push($participaciones, $participacion);
        }
        return $participaciones;
    }

    public function addParticipante(Participante $participante)
    {
        $reflect = new ReflectionClass("Participante");
        // Cogemos la propiedades de la clase
        $propiedades = $reflect->getProperties();
        // Le quitamos el id porque la BD lo genera automaticamente
        foreach ($propiedades as $propiedad => $valor) {
            if (
                $valor->name === "id" || $valor->name === "idParticipaciones" ||
                $valor->name === "participaciones"
            ) {
                unset($propiedades[$propiedad]);
            }
        }

        $valores = [];

        foreach ($propiedades as $propiedad) {
            $metodo = $reflect->getMethod("get" . ucfirst($propiedad->name));
            if ($propiedad->isInitialized($participante)) {
                $valor = $metodo->invoke($participante);

                if ($propiedad->name == "rol") {
                    $valor = $valor->value;
                }

                // si es string, lo rodeamos de ''
                if (!is_numeric($valor)) {
                    $valor = "'" . $valor . "'";
                }
                $valores[$propiedad->name] = $valor;
            }
        }

        // generamos la query con los valores de banda que 
        // estuviesen definidos
        $query = "INSERT INTO participantes (" . implode(", ", array_keys($valores)) .
            ") VALUES (" . implode(", ", $valores) . ");";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function estaRegistrado(string $email, string $contrasena): int
    {
        $query = "SELECT id FROM participantes WHERE email = '$email' AND password = '$contrasena'";

        try {
            $resul = $this->con->query($query);

            $resul = $resul->fetch(PDO::FETCH_ASSOC);

            return (isset($resul['id'])) ? $resul['id'] : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function existeParticipante(string $indicativo)
    {
        $query = "SELECT id FROM participantes WHERE indicativo = '$indicativo'";

        try {
            $resul = $this->con->query($query);

            $resul = $resul->fetch(PDO::FETCH_ASSOC);

            return (isset($resul['id'])) ? true : false;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function updateParticipante(array $values, int $id)
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

        $query = "UPDATE participantes SET $aCambiar WHERE id = $id;";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function deleteParticipante(int $id)
    {
        $query = "DELETE FROM participantes WHERE id = $id;";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
