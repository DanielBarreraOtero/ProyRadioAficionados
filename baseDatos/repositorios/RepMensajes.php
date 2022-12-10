<?php 

class RepMensajes {
    
    private PDO $con;

    public function setCon(PDO $con)
    {
        $this->con = $con;
    }

    function __construct(PDO $con)
    {
        $this->setCon($con);
    }


    public function getMensajeByID(int $id)
    {
        $query = "SELECT * FROM qso where id = $id";

        $resul = $this->con->query($query);

        try {
            $mensaje = new Mensaje();
            return $mensaje->mysqlToMensaje($resul->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getAllMensajes()
    {
        $query = "SELECT * FROM qso";

        $resul = $this->con->query($query);

        try {
            $resul = $resul->fetchAll(PDO::FETCH_ASSOC);
            $mensajes = [];
            foreach ($resul as $resultado) {
                $mensaje = new Mensaje();
                $mensaje->mysqlToMensaje($resultado);
                array_push($mensajes, $mensaje);
            }
            return $mensajes;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getBanda(Mensaje $mensaje)
    {
        $rpBanda = new RepBanda($this->con);
        return $rpBanda->getBandaByID($mensaje->getIdBanda());
    }

    public function getModo(Mensaje $mensaje)
    {
        $rpModo = new RepModo($this->con);
        return $rpModo->getModoByID($mensaje->getIdModo());
    }

    public function getParticipacion(Mensaje $mensaje)
    {
        $rpPar = new RepParticipacion($this->con);
        return $rpPar->getParticipacionByID($mensaje->getIdParticipacion());
    }

    public function addMensaje(Mensaje $mensaje)
    {
        $campos = "hora, participacion_id, indicativoJuez, modo_id, banda_id";
        $valores = ":hora, :participacion_id, :indicativoJuez, :modo_id, :banda_id";

        $query = "INSERT INTO qso ($campos) VALUES ($valores);";
        try {
            $PrepST = $this->con->prepare($query);
            $PrepST->execute($mensaje->toMysqlArray());
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function updateMensaje(array $values, int $id)
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

        $query = "UPDATE qso SET $aCambiar WHERE id = $id;";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function deleteMensaje(int $id)
    {
        $query = "DELETE FROM qso WHERE id = $id;";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }
}