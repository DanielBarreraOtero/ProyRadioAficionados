<?php

class RepParticipacion
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

    public function getParticipacionByID(int $id)
    {
        // añadimos en dos columnas nuevas la latitud y la longitud de gps
        $query = "SELECT *, X(gps), Y(gps) FROM participacion where id = $id";

        $resul = $this->con->query($query);

        try {
            $participacion = new Participacion();
            $participacion->mysqlToParticipacion($resul->fetch(PDO::FETCH_ASSOC));
            $participacion->setIdMensajes(self::getIdMensajes($participacion));
            $participacion->setIdPremios(self::getIdPremios($participacion));
            $participacion->setIdDiploma(self::getIdDiploma($participacion));
            return $participacion;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getAllParticipaciones()
    {
        // añadimos en dos columnas nuevas la latitud y la longitud de gps
        $query = "SELECT *, X(gps), Y(gps) FROM participacion";

        $resul = $this->con->query($query);

        try {

            $resul = $resul->fetchAll(PDO::FETCH_ASSOC);
            $participaciones = [];
            foreach ($resul as $resultado) {
                $participacion = new Participacion();
                $participacion->mysqlToParticipacion($resultado);
                $participacion->setIdMensajes(self::getIdMensajes($participacion));
                $participacion->setIdPremios(self::getIdPremios($participacion));
                $participacion->setIdDiploma(self::getIdDiploma($participacion));
                array_push($participaciones, $participacion);
            }
            return $participaciones;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getParticipante(Participacion $participacion)
    {
        // si ya tiene participante se lo devolvemos
        if (isset($participacion->participante)) {
            return $participacion->getParticipante();
        }
        
        // si tiene su id lo buscamos en la base de datos y lo devolvemos
        if ($participacion->getIdParticipante()) {
            $rpParti = new RepParticipante($this->con);
            return $rpParti->getParticipanteByID($participacion->getIdParticipante());
        }

        // si no tiene ningun participante asignado devolvemos false
        return false;
    }

    public function getConcurso(Participacion $participacion)
    {
        // si ya tiene concurso se lo devolvemos
        if (isset($participacion->concurso)) {
            return $participacion->getConcurso();
        }
        
        // si tiene su id lo buscamos en la base de datos y lo devolvemos
        if ($participacion->getIdConcurso()) {
            $rpConc = new RepConcurso($this->con);
            return $rpConc->getConcursoByID($participacion->getIdConcurso());
        }

        // si no tiene ningun concurso asignado devolvemos false
        return false;
    }

    /**
     * Pide a la base de datos todos los mensajes de una participacion.\
     */
    public function getIdMensajes(Participacion $participacion)
    {
        $id = $participacion->getId();
        $query = "SELECT q.id FROM participacion p JOIN qso q ON p.id = q.participacion_id WHERE p.id = $id";

        $resul = $this->con->query($query);

        try {
            $idMensajes = [];
            while ($row = $resul->fetch()) {
                array_push($idMensajes, $row[0]);
            }
            return $idMensajes;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getMensajes(Participacion $participacion)
    {
        $rpMen = new RepMensajes($this->con);
        $mensajes = [];

        foreach ($participacion->getIdMensajes() as $id) {
            $mensaje = $rpMen->getMensajeByID($id);
            array_push($mensajes, $mensaje);
        }
        return $mensajes;
    }

    public function getIdDiploma(Participacion $participacion)
    {
        $conc_id = $participacion->getIdConcurso();
        $nPts = count($participacion->getIdMensajes());
        // Seleccionamos solo el mayor diploma que haya ganado el participante
        $query = "SELECT id FROM diploma WHERE concurso_id = $conc_id AND minPts <= $nPts
        ORDER BY categoria LIMIT 1;";

        $resul = $this->con->query($query);
        $row = $resul->fetch();

        return $row ? $row[0] : false;
    }

    public function getDiploma(Participacion $participacion)
    {
        $rpDiploma = new RepDiploma($this->con);
        // si no se ha declarado el id del diploma este lo busca
        if (isset($participacion->idDiploma)) {
            $id = $participacion->getIdDiploma();
        } else {
            $id = self::getIdDiploma($participacion);
        }

        return $rpDiploma->getDiplomaByID($id);
    }

    public function getIdPremios(Participacion $participacion)
    {
        $conc_id = $participacion->getIdConcurso();
        if (isset($participacion->participante)) {
            $indicativoParticipante = $participacion->getParticipante()->getIndicativo();
        } else {
            $indicativoParticipante = self::getParticipante($participacion)->getIndicativo();
        }

        $query = "SELECT id FROM modo_concurso WHERE concurso_id = $conc_id AND indicativoGanador LIKE '$indicativoParticipante';";

        $resul = $this->con->query($query);

        try {
            $idPremios = [];
            while ($row = $resul->fetch()) {
                array_push($idPremios, $row[0]);
            }
            return $idPremios;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getPremios(Participacion $participacion)
    {
        $rpPremios = new RepPremio($this->con);
        $premios = [];

        foreach ($participacion->getIdPremios() as $id) {
            $premio = $rpPremios->getPremioByID($id);
            array_push($premios, $premio);
        }
        return $premios;
    }

    public function addParticipacion(Participacion $participacion)
    {
        $campos = "rol, gps, concursos_id, participantes_id";
        $valores = ":rol, POINT(:puntoX, :puntoY), :concursos_id, :participantes_id";

        $query = "INSERT INTO participacion ($campos) VALUES ($valores);";
        try {
            $PrepST = $this->con->prepare($query);
            $PrepST->execute($participacion->toMysqlArray());
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function updateParticipacion(array $values, int $id)
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

        $query = "UPDATE participacion SET $aCambiar WHERE id = $id;";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function deleteParticipacion(int $id)
    {
        $query = "DELETE FROM participacion WHERE id = $id;";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
