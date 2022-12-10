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
}
