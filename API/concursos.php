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
        $concurso = $repConcurso->getConcursoByID($_GET['id']);
        if (isset($concurso)) {
            $concurso->setBandas($repConcurso->getBandas($concurso));
            $concurso->setModos($repConcurso->getModos($concurso));
            $concurso->setPremios($repConcurso->getPremios($concurso));
            $concurso->setDiplomas($repConcurso->getDiplomas($concurso));
            $concurso->setParticipaciones($repConcurso->getParticipaciones($concurso));
            $concurso->setNParticipantes(count($repConcurso->getParticipantes($concurso->getId())));
            $concurso->setNJueces(count($repConcurso->getJueces($concurso->getId())));
        }

        echo json_encode($concurso);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['concurso'])) {
    $c = json_decode($_POST['concurso']);

    $newConc = new Concurso();

    $newConc->rellenaConcurso([
        "id" => 0, "nombre" => $c->nombre, "desc" => $c->desc, "idBandas" => $c->idBandas,
        "idModos" => $c->idModos, "idDiplomas" => $c->idDiplomas, "fechaIniInscrp" => $c->fechaIniInscrp,
        "fechaFinInscrp" => $c->fechaFinInscrp, "fechaIniCon" => $c->fechaIniCon,
        "fechaFinCon" => $c->fechaFinCon,
    ]);

    $newConc->setId($repConcurso->getNextId());

    $premios = [];
    foreach ($newConc->getIdModos() as $idModo) {
        $premio = new Premio();
        $premio->rellenaPremio(['id' => 0, 'modo_id' => $idModo, 'concurso_id' => $newConc->getId(), "nombre" => ""]);
        array_push($premios, $premio);
    }

    $newConc->setPremios($premios);
    $newConc->setBandas($repConcurso->getBandas($newConc));

    $result = $repConcurso->addConcurso($newConc);


    if ($result > 0) {
        http_response_code(201);
    } else {
        http_response_code(400);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $putdata = file_get_contents("php://input", "r");
    $obj = json_decode($putdata);
    $p = $obj->participante;

    if (isset($p->indicativo)) {
        $result = $repPar->updateParticipante(["indicativo" => $p->indicativo, "nombre" => $p->nombre, "apellido1" => $p->apellido1, "apellido2" => $p->apellido2, "email" => $p->email, "rol" => $p->rol], $obj->id);
    } else {
        $result = 0;
    }

    if ($result > 0) {
        http_response_code(201);
    } else {
        http_response_code(400);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $deletedata = file_get_contents("php://input", "r");
    $obj = json_decode($deletedata);

    if (isset($obj->id)) {
        $result = $repConcurso->deleteConcurso($obj->id);
    } else {
        $result = 0;
    }

    if ($result > 0) {
        http_response_code(201);
    } else {
        http_response_code(400);
    }
}
