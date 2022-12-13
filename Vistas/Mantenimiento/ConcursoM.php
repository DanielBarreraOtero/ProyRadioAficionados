<?php
require_once '../../cargadores/autoloader.php';
$con = GBD::getConnection("localhost", "radioaficionadosbdnew");

if (Sesion::leer('rol') !== 'admin') {
    header('location: ../error/denegado.php');
}

?>
<button id="c-mant__btnBorrar--concurso" class="c-boton--danger" style="display: none;">
    <img src="imgs/papelera.png" style="user-select: none;" width="25px">
</button>
<div class="c-mant">
    <div class="c-mant__boxL">
        <div class="c-mant__boxL--row--opposite">
            <p class="c-mant__titulo">Concursos</p>
            <button class="c-boton--new c-mant__newBtn" id="c-mant__newBtn--bandas">+ Nuevo</button>
        </div>
        <table class="c-mant__table">
            <thead>
                <tr class="c-mant__table__head-row">
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fechas Inscripción</th>
                    <th>Fechas Concurso</th>
                    <th>Nº Participantes</th>
                    <th>Nº Jueces</th>
                    <th>Borrar</th>
                </tr>
            </thead>
            <tbody id="c-mant__table__body">
            </tbody>
        </table>
    </div>
</div>