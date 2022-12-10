<?php 
require_once "Vistas/Principal/cardConcurso.php";
$cardConcurso = new cardConcurso($con);
?>
<div class="c-main-page">
    <?php
    if(Sesion::leer('rol') !== 'guest'){
        $cardConcurso->misConcursos(idParticipante: Sesion::leer("participante")->getId());
    }

    $cardConcurso->concursosDisponibles();
    ?>
    
</div>