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
}
