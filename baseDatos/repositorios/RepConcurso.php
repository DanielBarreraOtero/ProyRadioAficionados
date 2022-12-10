<?php

class RepConcurso
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


    public function getConcursoByID(int $id)
    {
        $query = "SELECT * FROM concursos where id = $id";

        $resul = $this->con->query($query);

        try {
            $datos = $resul->fetch(PDO::FETCH_ASSOC);
            $concurso = new Concurso();

            $datos['idBandas'] = self::getIdBandas($id);
            $datos['idModos'] = self::getIdModos($id);
            $datos['idDiplomas'] = self::getIdDiplomas($id);
            $datos['idParticipaciones'] = self::getIdParticipaciones($id);
            $datos['idPremios'] = self::getIdPremios($id);

            $concurso->rellenaConcurso($datos);
            return $concurso;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getAllConcursos()
    {
        $query = "SELECT * FROM concursos";

        $resul = $this->con->query($query);

        try {
            $concursos = [];
            foreach ($resul->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $concurso = new Concurso();
                $row['idBandas'] = self::getIdBandas($row['id']);
                $row['idModos'] = self::getIdModos($row['id']);
                $row['idDiplomas'] = self::getIdDiplomas($row['id']);
                $row['idParticipaciones'] = self::getIdParticipaciones($row['id']);
                $row['idPremios'] = self::getIdPremios($row['id']);

                $concurso->rellenaConcurso($row);
                array_push($concursos, $concurso);
            }
            return $concursos;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getAllConcursosDisponibles()
    {
        $query = "SELECT * FROM concursos WHERE fechaIniInscrp <= now() AND fechaFinInscrp >= now()";

        $resul = $this->con->query($query);

        try {
            $concursos = [];
            foreach ($resul->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $concurso = new Concurso();
                $row['idBandas'] = self::getIdBandas($row['id']);
                $row['idModos'] = self::getIdModos($row['id']);
                $row['idDiplomas'] = self::getIdDiplomas($row['id']);
                $row['idParticipaciones'] = self::getIdParticipaciones($row['id']);
                $row['idPremios'] = self::getIdPremios($row['id']);

                $concurso->rellenaConcurso($row);
                array_push($concursos, $concurso);
            }
            return $concursos;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * Devuelve un array de Participantes del concurso (No jueces).
     */
    public function getParticipantes(int $id)
    {
        $rpParticipaciones = new RepParticipacion($this->con);

        $query = "SELECT *, X(gps), Y(gps) FROM participacion WHERE concursos_id = $id AND rol like 'concursante'";

        try {
            $resul = $this->con->query($query);

            $resul = $resul->fetchAll(PDO::FETCH_ASSOC);
            $participaciones = [];
            foreach ($resul as $resultado) {
                $participacion = new Participacion();
                $participacion->mysqlToParticipacion($resultado);
                $participacion->setIdMensajes($rpParticipaciones->getIdMensajes($participacion));
                $participacion->setParticipante($rpParticipaciones->getParticipante($participacion));
                array_push($participaciones, $participacion);
            }
            return $participaciones;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * Devuelve un array de Participantes del concurso (solo jueces).
     */
    public function getJueces(int $id)
    {
        $rpParticipaciones = new RepParticipacion($this->con);

        $query = "SELECT *, X(gps), Y(gps) FROM participacion WHERE concursos_id = $id AND rol like 'juez'";

        try {
            $resul = $this->con->query($query);

            $resul = $resul->fetchAll(PDO::FETCH_ASSOC);
            $participaciones = [];
            foreach ($resul as $resultado) {
                $participacion = new Participacion();
                $participacion->mysqlToParticipacion($resultado);
                $participacion->setIdMensajes($rpParticipaciones->getIdMensajes($participacion));
                $participacion->setParticipante($rpParticipaciones->getParticipante($participacion));
                array_push($participaciones, $participacion);
            }
            return $participaciones;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getIdBandas(int $id)
    {
        $query = "SELECT banda_id FROM banda_concurso WHERE concurso_id = $id";

        $resul = $this->con->query($query);

        try {
            $ids = [];
            foreach ($resul->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($ids, $row['banda_id']);
            }
            return $ids;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getBandas(Concurso $conc)
    {
        $rpBandas = new RepBanda($this->con);

        $bandas = [];
        foreach ($conc->getIdBandas() as $id) {
            $banda = $rpBandas->getBandaByID($id);
            array_push($bandas, $banda);
        }
        return $bandas;
    }

    public function getIdModos(int $id)
    {
        $query = "SELECT modo_id FROM modo_concurso WHERE concurso_id = $id";

        $resul = $this->con->query($query);

        try {
            $ids = [];
            foreach ($resul->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($ids, $row['modo_id']);
            }
            return $ids;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getModos(Concurso $conc)
    {
        $rpModos = new RepModo($this->con);

        $modos = [];
        foreach ($conc->getIdModos() as $id) {
            $modo = $rpModos->getModoByID($id);
            array_push($modos, $modo);
        }
        return $modos;
    }

    public function getIdDiplomas(int $id)
    {
        $query = "SELECT id FROM diploma WHERE concurso_id = $id";

        $resul = $this->con->query($query);

        try {
            $ids = [];
            foreach ($resul->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($ids, $row['id']);
            }
            return $ids;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getDiplomas(Concurso $conc)
    {
        $rpDiploma = new RepDiploma($this->con);

        $diplomas = [];
        foreach ($conc->getIdDiplomas() as $id) {
            $diploma = $rpDiploma->getDiplomaByID($id);
            array_push($diplomas, $diploma);
        }
        return $diplomas;
    }

    public function getIdParticipaciones(int $id)
    {
        $query = "SELECT id FROM participacion WHERE concursos_id = $id";

        $resul = $this->con->query($query);

        try {
            $ids = [];
            foreach ($resul->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($ids, $row['id']);
            }
            return $ids;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getParticipaciones(Concurso $conc)
    {
        $rpParticipaciones = new RepParticipacion($this->con);

        $participaciones = [];
        foreach ($conc->getIdParticipaciones() as $id) {
            $participacion = $rpParticipaciones->getParticipacionByID($id);
            array_push($participaciones, $participacion);
        }
        return $participaciones;
    }

    public function getIdPremios(int $id)
    {
        $query = "SELECT id FROM modo_concurso WHERE concurso_id = $id AND nombre IS NOT NULL";

        $resul = $this->con->query($query);

        try {
            $ids = [];
            foreach ($resul->fetchAll(PDO::FETCH_ASSOC) as $row) {
                array_push($ids, $row['id']);
            }
            return $ids;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getPremios(Concurso $conc)
    {
        $rpPremios = new RepPremio($this->con);

        $premios = [];
        foreach ($conc->getIdPremios() as $id) {
            $premio = $rpPremios->getPremioByID($id);
            array_push($premios, $premio);
        }
        return $premios;
    }

    public function addConcurso(Concurso $concurso)
    {
        // INICIAR UNA TRANSACCION PARA ASEGURARNOS DE QUE NO SE 
        // HAGAN INSERTS DE CONCURSO SI NO SE HAN REALIZADO LOS
        // INSERTS DE MODO_CONCURSO, BANDA CONCURSO, DIPLOMA O PARTICIPACION

        $this->con->beginTransaction();

        $campos = "nombre, `desc`, fechaIniInscrp, fechaFinInscrp,
        fechaIniCon, fechaFinCon";
        $valores = ":nombre, :desc, :fechaIniInscrp, :fechaFinInscrp,
        :fechaIniCon, :fechaFinCon";

        // si cartel esta definido lo añadimos al prepareStatement
        if (isset($concurso->cartel)) {
            $campos = $campos . ", cartel";
            $valores = $valores . ", :cartel";
        }

        $query = "INSERT INTO concursos ($campos) VALUES ($valores);";

        try {
            $PrepST = $this->con->prepare($query);
            $PrepST->execute($concurso->toMysqlArray());

            var_dump($this->getAllConcursos());
            // Añadimos modo-concurso
            $rpPremios = new RepPremio($this->con);
            foreach ($concurso->getPremios() as $premio) {
                $rpPremios->addPremio($premio);
            }

            // Añadimos banda-concurso
            foreach ($concurso->getBandas() as $banda) {
                $this->concursoBanda($concurso, $banda);
            }

            // Añadimos diploma
            $rpDiplomas = new RepDiploma($this->con);
            foreach ($concurso->getDiplomas() as $diploma) {
                $rpDiplomas->addDiploma($diploma);
            }

            // Añadimos participación
            $rpParticipaciones = new RepParticipacion($this->con);
            foreach ($concurso->getParticipaciones() as $participacion) {
                $rpParticipaciones->addParticipacion($participacion);
            }

            $this->con->commit();
        } catch (PDOException $e) {
            // Si se captura algun error durante la transaccion, se vuelve
            // al estado previo antes de comenzar
            $this->con->rollBack();
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

        $query = "UPDATE participantes SET $aCambiar WHERE id = $id;";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function deleteConcurso(int $id)
    {
        $query = "DELETE FROM concursos WHERE id = $id;";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    private function concursoBanda(Concurso $concurso, Banda $banda)
    {
        $idConcurso = $concurso->getId();
        $idBanda = $banda->getId();

        $query = "INSERT INTO banda_concurso (banda_id, concurso_id)
         values ($idBanda, $idConcurso)";

        try {
            return $this->con->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
