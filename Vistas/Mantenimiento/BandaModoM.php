<?php
require_once '../../cargadores/autoloader.php';
$con = GBD::getConnection("localhost", "radioaficionadosbdnew");

if (Sesion::leer('rol') !== 'admin') {
    header('location: ../error/denegado.php');
}

?>
<button id="c-mant__btnBorrar--modos" style="display: none;">
    <img src="imgs/papelera.png" style="user-select: none;" width="25px">
</button>
<div class="c-mant">
    <div class="c-mant__boxL--row">
        <div class="c-mant__boxBandas">
            <div class="c-mant__boxL--row--opposite">
                <p>Bandas</p>
                <button class="c-mant__newBtn" id="c-mant__newBtn--bandas">+ Nuevo</button>
            </div>
            <table class="c-mant__table">
                <thead>
                    <tr class="c-mant__table__head-row">
                        <th>Nombre</th>
                        <th>Distancia</th>
                        <th>Rango Mín</th>
                        <th>Rango Máx</th>
                    </tr>
                </thead>
                <tbody id="c-mant__table__body--bandas">
                </tbody>
            </table>
        </div>

        <div class="c-mant__boxModos">
            <div class="c-mant__boxL--row--opposite">
                <p>Modos</p>
                <button class="c-mant__newBtn" id="c-mant__newBtn--modos">+ Nuevo</button>
            </div>
            <table class="c-mant__table">
                <thead>
                    <tr class="c-mant__table__head-row">
                        <th>Nombre</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody id="c-mant__table__body--modos">
                </tbody>
            </table>
        </div>
    </div>
</div>