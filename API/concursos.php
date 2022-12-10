<?php
require_once '../cargadores/autoloader.php';
$con = GBD::getConnection("localhost", "radioaficionadosbdnew");
$repConcurso = new RepConcurso($con);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id'])) {
        $concursos = $repConcurso->getAllConcursos();

        foreach ($concursos as $concurso) {
            $concurso->setBandas($repConcurso->getBandas($concurso));
            $concurso->setModos($repConcurso->getModos($concurso));
            $concurso->setPremios($repConcurso->getPremios($concurso));
            $concurso->setDiplomas($repConcurso->getDiplomas($concurso));
            $concurso->setParticipaciones($repConcurso->getParticipaciones($concurso));
            $concurso->setNParticipantes(count($repConcurso->getParticipantes($concurso->getId())));
            $concurso->setNJueces(count($repConcurso->getJueces($concurso->getId())));
        }

        echo json_encode($concursos);
    } else {
        echo "devolveria el concurso en cuestion";
    }
}
