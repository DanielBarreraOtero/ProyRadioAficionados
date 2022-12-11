<?php
require_once '../cargadores/autoloader.php';
$con = GBD::getConnection("localhost", "radioaficionadosbdnew");
$repBandas = new RepBanda($con);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id'])) {
        $bandas = $repBandas->getAllBandas();

        echo json_encode($bandas);
    } else {
        echo "devolveria la banda en cuestion";
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['banda'])) {
    $banda = json_decode($_POST['banda']);
    if (!$repBandas->existeBanda($banda->nombre)) {
        $newBanda = new Banda();
        $newBanda->rellenaBanda(["id" => 0, "nombre" => $banda->nombre, "distancia" => $banda->distancia, "rangoMin" => $banda->rangoMin, "rangoMax" => $banda->rangoMax]);

        $result = $repBandas->addBanda($newBanda);

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
    $banda = $obj->banda;

    if (isset($banda->nombre)) {
        $result = $repBandas->updateBanda(["nombre" => $banda->nombre, "distancia" => $banda->distancia, "rangoMin" => $banda->rangoMin, "rangoMax" => $banda->rangoMax], $obj->id);
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
        $result = $repBandas->deleteBanda($obj->id);
    } else {
        $result = 0;
    }

    if ($result > 0) {
        http_response_code(201);
    } else {
        http_response_code(400);
    }
}
