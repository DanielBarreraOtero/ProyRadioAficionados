<?php

class cardConcurso
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

    public function misConcursos(int $idParticipante = 0, Participante $participante = null)
    {
        $rpParticipante = new RepParticipante($this->con);
        if (is_null($participante)) {
            $participante = $rpParticipante->getParticipanteByID($idParticipante);
        }
        $participaciones = $rpParticipante->getParticipaciones($participante);
        $idConcursos = [];

        foreach ($participaciones as $participacion) {
            array_push($idConcursos, $participacion->getIdConcurso());
        }

        self::newConcursosBox(titulo: "Mis Concursos", idConcursos: $idConcursos);
    }

    public function concursosDisponibles()
    {
        $rpConc = new RepConcurso($this->con);
        $concursos = $rpConc->getAllConcursosDisponibles();

        self::newConcursosBox(titulo: "Concursos Disponibles", concursos: $concursos);
    }

    public function newConcursosBox(string $titulo = "", array $idConcursos = [], array $concursos = [])
    {
?>
        <?php ?>
        <div class="c-box-concursos">
            <?php
            if ($titulo !== "") {
            ?> <p class='c-box-concursos__titulo'><?= $titulo ?></p>
            <?php }
            ?>

            <div class="c-box-concursos__box">
                <div class="c-box-concursos__row">
                    <?php
                    if (count($concursos) == 0) {
                        foreach ($idConcursos as $id) {
                            self::cardConcurso(id: $id);
                        }
                    } else {
                        foreach ($concursos as $concurso) {
                            self::cardConcurso(conc: $concurso);
                        }
                    } ?>
                </div>
            </div>
        </div>
    <?php
    }

    public function cardConcurso(int $id = null, Concurso $conc = null)
    {
        $rpConc = new RepConcurso($this->con);
        if (is_null($conc)) {
            $conc = $rpConc->getConcursoByID($id);
        }
        if (isset($conc->idPremios)) {
            $premio = $rpConc->getPremios($conc)[0]->getNombre();
        } else {
            $premio = "";
        }
        $fechaIni = $conc->getFechaIniCon()->format('d/m/Y');
        $fechaFin = $conc->getFechaFinCon()->format('d/m/Y');
        $participantes = $rpConc->getParticipantes($conc->getId());
        $jueces = $rpConc->getJueces($conc->getId());

    ?>
        <div class="c-card-concurso" concId="<?= $conc->getId() ?>">
            <div class="c-card-concurso__foto"></div>
            <div class="c-card-concurso__body">
                <p class="c-card-concurso__titulo"><?= $conc->getNombre() ?></p>
                <p class="c-card-concurso__premio"><?= $premio ?></p>
                <p class="c-card-concurso__miembros"><?= '🙍‍♂️:' . count($participantes).' 👮‍♂️:'.count($jueces) ?></p>
                <p class="c-card-concurso__desc"><?= $conc->getDesc() ?></p>
                <p class="c-card-concurso__time"><?= $fechaIni . ' - ' . $fechaFin ?></p>
            </div>
        </div>
<?php
    }
}

?>