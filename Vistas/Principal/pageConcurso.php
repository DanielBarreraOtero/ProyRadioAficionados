<?php
// Se llama desde js, y se le pasa la informacion del concursoº
// y rellenamos los datos con ella
require_once '../../cargadores/autoloader.php';
$con = GBD::getConnection("localhost", "radioaficionadosbdnew");

$RepConc = new RepConcurso($con);
$RepPremio = new RepPremio($con);
$concurso = $RepConc->getConcursoByID($_POST['idConcurso']);

$fechaIni = $concurso->getFechaIniCon()->format('d/m/Y');
$fechaFin = $concurso->getFechaFinCon()->format('d/m/Y');

$participantes = $RepConc->getParticipantes($concurso->getId());
$jueces = $RepConc->getJueces($concurso->getId());

$premios = $RepConc->getPremios($concurso);
$strPremios = "";
foreach ($premios as $premio) {
    $premio->setModo($RepPremio->getModo($premio));
    $strPremios = $strPremios . $premio->getModo()->getNombre() . ": " . $premio->getNombre();
}

$bandas = $RepConc->getBandas($concurso);
$strBandas = "";
foreach ($bandas as $banda) {
    $strBandas = $strBandas . $banda->getNombre();
}
?>
<div class="c-concurso-page" concId="<?= $concurso->getID() ?>">
    <div class="c-concurso-page__banner"></div>
    <div class="c-concurso-page__boxL--opposite">
        <p class="c-concurso-page__titulo"><?= $concurso->getNombre(); ?></p>
        <p class="c-concurso-page__time"><?= $fechaIni . ' - ' . $fechaFin ?></p>
    </div>
    <div class="c-concurso-page__boxL--opposite--noborders">
        <p class="c-concurso-page__titulo">Descripción</p>
        <p class="c-concurso-page__miembros">Participantes: <?= count($participantes) ?> 🙍‍♂️ Jueces: <?= count($jueces) ?> 👮‍♂️</p>
    </div>
    <div class="c-concurso-page__boxL--noborders">
        <p class="c-concurso-page__desc"><?= $concurso->getDesc() ?></p>
    </div>
    <div class="c-concurso-page__boxL--opposite--noborders">
        <div class="c-concurso-page__boxM">
            <p class="c-concurso-page__titulo">Premios</p>
        </div>
        <div class="c-concurso-page__boxM--right">
            <p class="c-concurso-page__titulo">Bandas</p>
        </div>
    </div>
    <div class="c-concurso-page__boxL--opposite--noborders">
        <div class="c-concurso-page__boxM--noborders">
            <p class="c-concurso-page__text"><?= $strPremios ?></p>
        </div>
        <div class="c-concurso-page__boxM--right--noborders">
            <p class="c-concurso-page__text"><?= $strBandas ?></p>
        </div>
    </div>
    <br>
    <div class="c-concurso-page__boxL">
        <p class="c-concurso-page__titulo">CLASIFICACIONES / CONCURSANTES</p>
    </div>
    <div class="c-concurso-page__boxL--noborders">
        <table class="c-concurso-page__table">
            <thead>
                <tr>
                    <th>N.</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Puntuación</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>