    <?php
class Concurso implements JsonSerializable
{
    private int $id;
    private string $nombre;
    private string $desc;
    private array $idBandas = [];
    private array $bandas = [];
    private array $idModos = [];
    private array $modos = [];
    private array $idParticipaciones = [];
    private array $participaciones = [];
    private array $idPremios = [];
    private array $premios = [];
    private array $idDiplomas = [];
    private array $diplomas = [];
    private int $nParticipantes = 0;
    private int $nJueces = 0;
    private DateTimeImmutable $fechaIniInscrp;
    private DateTimeImmutable $fechaFinInscrp;
    private DateTimeImmutable $fechaIniCon;
    private DateTimeImmutable $fechaFinCon;
    private string $cartel;

    // GETTERS Y SETTERS

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
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of desc
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * Set the value of desc
     *
     * @return  self
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;

        return $this;
    }

    /**
     * Get the value of bandas
     */
    public function getBandas()
    {
        return $this->bandas;
    }

    /**
     * Set the value of bandas
     *
     * @return  self
     */
    public function setBandas($bandas)
    {
        $this->bandas = $bandas;

        return $this;
    }

    /**
     * Get the value of modos
     */
    public function getModos()
    {
        return $this->modos;
    }

    /**
     * Set the value of modos
     *
     * @return  self
     */
    public function setModos($modos)
    {
        $this->modos = $modos;

        return $this;
    }

    /**
     * Get the value of participaciones
     */
    public function getParticipaciones()
    {
        return $this->participaciones;
    }

    /**
     * Set the value of participaciones
     *
     * @return  self
     */
    public function setParticipaciones($participaciones)
    {
        $this->participaciones = $participaciones;

        return $this;
    }

    /**
     * Get the value of fechaIniInscrp
     */
    public function getFechaIniInscrp()
    {
        return $this->fechaIniInscrp;
    }

    /**
     * Set the value of fechaIniInscrp
     *
     * @return  self
     */
    public function setFechaIniInscrp($fechaIniInscrp)
    {
        $vl = new Validacion();

        if (is_string($fechaIniInscrp)) {
            $fechaIniInscrp = new DateTimeImmutable($fechaIniInscrp);
        }

        if (
            !isset($this->fechaFinInscrp) ||
            $vl->ValidaFechaPasada($fechaIniInscrp, $this->fechaFinInscrp)
        ) {
            $this->fechaIniInscrp = $fechaIniInscrp;
        } else {
            throw new Exception("La fecha de inicio no puede ser anterior a la de fin.");
        }

        return $this;
    }

    /**
     * Get the value of fechaFinInscrp
     */
    public function getFechaFinInscrp()
    {
        return $this->fechaFinInscrp;
    }

    /**
     * Set the value of fechaFinInscrp
     * 
     * LA FECHA DE INICIO DEBE SER DEFINIDA ANTES QUE ESTA
     *
     * @return  self
     */
    public function setFechaFinInscrp($fechaFinInscrp)
    {
        $vl = new Validacion();

        if (is_string($fechaFinInscrp)) {
            $fechaFinInscrp = new DateTimeImmutable($fechaFinInscrp);
        }

        if (
            !isset($this->fechaIniInscrp) ||
            $vl->ValidaFechaPasada(
                $this->fechaIniInscrp,
                $fechaFinInscrp
            )
        ) {
            $this->fechaFinInscrp = $fechaFinInscrp;
        } else {
            throw new Exception("La fecha fin no puede ser previa a la de inicio.");
        }

        return $this;
    }

    /**
     * Get the value of fechaIniCon
     */
    public function getFechaIniCon()
    {
        return $this->fechaIniCon;
    }

    /**
     * Set the value of fechaIniCon
     *
     * @return  self
     */
    public function setFechaIniCon($fechaIniCon)
    {
        $vl = new Validacion();

        if (is_string($fechaIniCon)) {
            $fechaIniCon = new DateTimeImmutable($fechaIniCon);
        }

        if (
            !isset($this->fechaFinCon) ||
            $vl->ValidaFechaPasada($fechaIniCon, $this->fechaFinCon)
        ) {
            $this->fechaIniCon = $fechaIniCon;
        } else {
            throw new Exception("La fecha de inicio no puede ser anterior a la de fin.");
        }


        return $this;
    }

    /**
     * Get the value of fechaFinCon
     */
    public function getFechaFinCon()
    {
        return $this->fechaFinCon;
    }

    /**
     * Set the value of fechaFinCon
     * 
     * LA FECHA DE INICIO DEBE SER DEFINIDA ANTES QUE ESTA
     *
     * @return  self
     */
    public function setFechaFinCon($fechaFinCon)
    {
        $vl = new Validacion();

        if (is_string($fechaFinCon)) {
            $fechaFinCon = new DateTimeImmutable($fechaFinCon);
        }

        if (
            !isset($this->fechaIniCon) ||
            $vl->ValidaFechaPasada($this->fechaIniCon, $fechaFinCon)
        ) {
            $this->fechaFinCon = $fechaFinCon;
        } else {
            throw new Exception("La fecha fin no puede ser previa a la de inicio.");
        }

        return $this;
    }

    /**
     * Get the value of cartel
     */
    public function getCartel()
    {
        return $this->cartel;
    }

    /**
     * Set the value of cartel
     *
     * @return  self
     */
    public function setCartel($cartel)
    {
        $this->cartel = $cartel;

        return $this;
    }

    /**
     * Get the value of premios
     */
    public function getPremios()
    {
        return $this->premios;
    }

    /**
     * Set the value of premios
     *
     * @return  self
     */
    public function setPremios($premios)
    {
        $this->premios = $premios;

        return $this;
    }

    /**
     * Get the value of diplomas
     */
    public function getDiplomas()
    {
        return $this->diplomas;
    }

    /**
     * Set the value of diplomas
     *
     * @return  self
     */
    public function setDiplomas($diplomas)
    {
        $this->diplomas = $diplomas;

        foreach ($diplomas as $diploma) {
            $diploma->setConcurso($this);
        }

        return $this;
    }
    
    /**
     * Get the value of idBandas
     */ 
    public function getIdBandas()
    {
        return $this->idBandas;
    }

    /**
     * Set the value of idBandas
     *
     * @return  self
     */ 
    public function setIdBandas($idBandas)
    {
        $this->idBandas = $idBandas;

        return $this;
    }

    /**
     * Get the value of idModos
     */ 
    public function getIdModos()
    {
        return $this->idModos;
    }

    /**
     * Set the value of idModos
     *
     * @return  self
     */ 
    public function setIdModos($idModos)
    {
        $this->idModos = $idModos;

        return $this;
    }

    /**
     * Get the value of idParticipaciones
     */ 
    public function getIdParticipaciones()
    {
        return $this->idParticipaciones;
    }

    /**
     * Set the value of idParticipaciones
     *
     * @return  self
     */ 
    public function setIdParticipaciones($idParticipaciones)
    {
        $this->idParticipaciones = $idParticipaciones;

        return $this;
    }

    /**
     * Get the value of idPremios
     */ 
    public function getIdPremios()
    {
        return $this->idPremios;
    }

    /**
     * Set the value of idPremios
     *
     * @return  self
     */ 
    public function setIdPremios($idPremios)
    {
        $this->idPremios = $idPremios;

        return $this;
    }

    /**
     * Get the value of idDiplomas
     */ 
    public function getIdDiplomas()
    {
        return $this->idDiplomas;
    }

    /**
     * Set the value of idDiplomas
     *
     * @return  self
     */ 
    public function setIdDiplomas($idDiplomas)
    {
        $this->idDiplomas = $idDiplomas;

        return $this;
    }
    
    /**
     * Get the value of nParticipantes
     */ 
    public function getNParticipantes()
    {
        return $this->nParticipantes;
    }

    /**
     * Set the value of nParticipantes
     *
     * @return  self
     */ 
    public function setNParticipantes($nParticipantes)
    {
        $this->nParticipantes = $nParticipantes;

        return $this;
    }

    /**
     * Get the value of nJueces
     */ 
    public function getNJueces()
    {
        return $this->nJueces;
    }

    /**
     * Set the value of nJueces
     *
     * @return  self
     */ 
    public function setNJueces($nJueces)
    {
        $this->nJueces = $nJueces;

        return $this;
    }

    public function rellenaConcurso(array $concurso): void
    {
        $this->setId($concurso['id'])->setNombre($concurso['nombre'])
        ->setDesc($concurso['desc'])->setIdBandas($concurso['idBandas'])
        ->setIdModos($concurso['idModos'])->setIdDiplomas($concurso['idDiplomas'])
        ->setFechaIniInscrp($concurso['fechaIniInscrp'])
        ->setFechaFinInscrp($concurso['fechaFinInscrp'])
        ->setFechaIniCon($concurso['fechaIniCon'])
        ->setFechaFinCon($concurso['fechaFinCon']);

        if (isset($concurso['bandas'])) {
            $this->setBandas($concurso['bandas']);
        }

        if (isset($concurso['modos'])) {
            $this->setModos($concurso['modos']);
        }

        if (isset($concurso['diplomas'])) {
            $this->setDiplomas($concurso['diplomas']);
        }

        if (isset($concurso['idParticipaciones'])) {
            $this->setIdParticipaciones($concurso['idParticipaciones']);
        }
        
        if (isset($concurso['participaciones'])) {
            $this->setParticipaciones($concurso['participaciones']);
        }
        
        if (isset($concurso['idPremios'])) {
            $this->setIdPremios($concurso['idPremios']);
        }
        
        if (isset($concurso['premios'])) {
            $this->setPremios($concurso['premios']);
        }

        if (isset($concurso['cartel'])) {
            $this->setCartel($concurso['cartel']);
        }

        if (isset($concurso['nParticipantes'])) {
            $this->setNParticipantes($concurso['nParticipantes']);
        }
        if (isset($concurso['nJueces'])) {
            $this->setNJueces($concurso['nParticipantes']);
        }
    }

    /**
     * Devuelve un array formateado con los campos necesarios para la tabla de mysql
     */
    public function toMysqlArray(): array
    {
        $nombre = $this->getNombre();
        $desc = $this->getDesc();
        $fInInscrp = $this->getFechaIniInscrp()->format("Y-m-d H:i:s");
        $fFiInscrp = $this->getFechaFinInscrp()->format("Y-m-d H:i:s");
        $fInCon = $this->getFechaIniCon()->format("Y-m-d H:i:s");
        $fFinCon = $this->getFechaFinCon()->format("Y-m-d H:i:s");

        $concurso = array(
            "nombre" => $nombre, "desc" => $desc,
            "fechaIniInscrp" => $fInInscrp, "fechaFinInscrp" => $fFiInscrp,
            "fechaIniCon" => $fInCon, "fechaFinCon" => $fFinCon
        );

        if (isset($this->cartel)) {
            $cartel = $this->getCartel();
            $concurso['cartel'] = $cartel;
        }

        return $concurso;
    }


    public function jsonSerialize()
    {
        $std = new stdClass();
        $std->id = $this->getId();
        $std->nombre = $this->getNombre();
        $std->desc = $this->getDesc();
        $std->idBandas= $this->getIdBandas();
        $std->bandas= $this->getBandas();
        $std->idModos= $this->getIdModos();
        $std->modos= $this->getModos();
        $std->idParticipaciones= $this->getIdParticipaciones();
        $std->participaciones= $this->getParticipaciones();
        $std->idPremios= $this->getIdPremios();
        $std->premios= $this->getPremios();
        $std->idDiplomas= $this->getIdDiplomas();
        $std->diplomas= $this->getDiplomas();
        $std->fechaIniInscrp= $this->getFechaIniInscrp();
        $std->fechaFinInscrp= $this->getFechaFinInscrp();
        $std->fechaIniCon= $this->getFechaIniCon();
        $std->fechaFinCon= $this->getFechaFinCon();
        (isset($this->cartel))? $this->getCartel(): null;
        $std->nParticipantes= $this->getNParticipantes();
        $std->nJueces= $this->getNJueces();

        return $std;
    }

}
