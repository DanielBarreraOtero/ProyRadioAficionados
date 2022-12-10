<?php
require_once '../../cargadores/autoloader.php';
$con = GBD::getConnection("localhost", "radioaficionadosbdnew");

if (Sesion::leer('rol') !== 'admin') {
    header('location: ../error/denegado.php');
}

?>

<div class="c-mant">
    <div class="c-mant__boxL">
        <button class="c-mant__newBtn">+ Nuevo</button>
        <table class="c-mant__table">
            <thead>
                <tr class="c-mant__table__head-row">
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fechas Inscripción</th>
                    <th>Fechas Concurso</th>
                    <th>Nº Participantes</th>
                    <th>Nº Jueces</th>
                </tr>
            </thead>
            <tbody id="c-mant__table__body">
            </tbody>
        </table>
    </div>
</div>