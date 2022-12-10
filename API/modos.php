<?php
require_once '../cargadores/autoloader.php';
$con = GBD::getConnection("localhost", "radioaficionadosbdnew");
$repModos = new RepModo($con);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id'])) {
        $modos = $repModos->getAllModos();

        echo json_encode($modos);
    } else {
        echo "devolveria el modo en cuestion";
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
    if (!$repModos->existeModo($_POST['nombre'])) {
        $modo = new Modo();
        $modo->setNombre($_POST['nombre']);

        $result = $repModos->addModo($modo);

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

    if (isset($obj->nombre)) {
        $result = $repModos->updateModo(["nombre" => $obj->nombre], $obj->id);
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
        $result = $repModos->deleteModo($obj->id);
    } else {
        $result = 0;
    }

    if ($result > 0) {
        http_response_code(201);
    } else {
        http_response_code(400);
    }
}

