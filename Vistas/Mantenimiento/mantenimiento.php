<?php
echo ("<p> Mantenimiento</p>");


// // "YYYY-MM-DD hh:mm:ss"
$intervalo = new DateInterval("PT1S");

$fecha = new DateTimeImmutable("now");
// $fechaClon = new DateTimeImmutable("now");
$fecha2 = $fecha->add($intervalo);


// // var_dump($intervalo);

// var_dump($fecha);

echo $fecha->format("Y-m-d H:i:s") . "<br>";
echo $fecha2->format("Y-m-d H:i:s") . "<br>";

// $v = new Validacion();

// var_dump($v->ValidaFechaPasada($fecha,$fecha2));

// crear un nuevo concurso con todas sus dependencias
        $rpConc = new RepConcurso($con);
        // $rpBan = new RepBanda($con);
        // $rpModo = new RepModo($con);

        // $conc = new Concurso();

        // $banda = new Banda();
        // $banda->rellenaBanda($rpBan->getBandaByID(1));
        // $bandas[0] = $banda;

        // $modo = new Modo();
        // $modo->rellenaModo($rpModo->getModoByID(1));
        // $modos[0] = $modo;

        // $premio = new Premio();
        // $premio->rellenaPremio(array("id"=>1,"nombre"=>"test","modo"=>$modo,"concurso"=>$conc));
        // $premios[0] = $premio;

        // $diploma = new Diploma();
        // $arrDiploma = array("id"=>1,"categoria"=>Categoria::oro,"minPts"=>2);
        // $diploma->rellenaDiploma($arrDiploma);
        // $diplomas[0] = $diploma;

        // $campos = array("id"=>1,"nombre"=>"ConcTest","desc"=>"Primer concurso de prueba",
        // "fechaIniInscrp"=>$fecha,"fechaFinInscrp"=>$fecha2, "fechaIniCon"=>$fecha,
        // "fechaFinCon"=>$fecha2,"bandas"=>$bandas,"modos"=>$modos,"diplomas"=>$diplomas,
        // "premios"=>$premios);

        // $conc->rellenaConcurso($campos);

        // // var_dump($conc);


        // $rpConc->addConcurso($conc);


$rpPar = new RepParticipacion($con);
$rpDip = new RepDiploma($con);
$par = $rpPar->getParticipacionByID(1);
$par->setIdMensajes(array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,1,2,3,4,5,6,7,8,9,10,11,12,13,14));
$par->setIdDiploma($rpPar->getIdDiploma($par));
$par->setDiploma($rpPar->getDiploma($par));

$conc = $rpConc->getConcursoByID(1);
$conc->setBandas($rpConc->getBandas($conc));
$conc->setModos($rpConc->getModos($conc));
$conc->setDiplomas($rpConc->getDiplomas($conc));
$conc->setParticipaciones($rpConc->getParticipaciones($conc));
$conc->setPremios($rpConc->getPremios($conc));

var_dump($conc);

