<?php
require_once '../cargadores/autoloader.php';
$con = GBD::getConnection("localhost", "radioaficionadosbdnew");
$repPar = new RepParticipante($con);
$repParticipacion = new RepParticipacion($con);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id'])) {
        $participantes = $repPar->getAllParticipantes();

        // le añadimos las participaciones
        foreach ($participantes as  $par) {
            $participaciones = $repPar->getParticipaciones($par);

            // a cada participación le añadimos el concurso
            foreach ($participaciones as $participacion) {
                $participacion->setConcurso($repParticipacion->getConcurso($participacion));
            }

            $par->setParticipaciones($participaciones);
        }

        $participantes = json_encode($participantes);
        
        echo $participantes;

    } else {
        echo "devolveria el modo en cuestion";
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['participante'])) {
    $p = json_decode($_POST['participante']);
    if (!$repPar->existeParticipante($p->indicativo)) {

        $newPar = new Participante();
        // relleno el participante

        $newPar->rellenarParticipante(["id" => 0, "indicativo" => $p->indicativo, "nombre" => $p->nombre, "apellido1" => $p->apellido1, "apellido2" => $p->apellido2,
        "email" => $p->email, "password" => '1234', "rol" => $p->rol, "idParticipaciones" => [] ]);

        $result = $repPar->addParticipante($newPar);


        if ($result > 0) {
            http_response_code(201);
        } else {
            http_response_code(400);
        }
    } else {
        http_response_code(200);
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
        $result = $repPar->deleteParticipante($obj->id);
    } else {
        $result = 0;
    }

    if ($result > 0) {
        http_response_code(201);
    } else {
        http_response_code(400);
    }
}

