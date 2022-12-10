<?php
require_once '../cargadores/autoloader.php';
$con = GBD::getConnection("localhost", "radioaficionadosbdnew");
$repConcurso = new RepConcurso($con);

if(isset($_POST['clasificacionConcurso']) && isset($_POST['idConcurso'])){
    $participaciones = $repConcurso->getParticipantes($_POST['idConcurso']);
    echo json_encode($participaciones) ;
}
