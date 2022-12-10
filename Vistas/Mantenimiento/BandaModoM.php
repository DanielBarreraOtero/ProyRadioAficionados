<?php
require_once '../../cargadores/autoloader.php';
$con = GBD::getConnection("localhost", "radioaficionadosbdnew");

if (Sesion::leer('rol') !== 'admin') {
    header('location:?menu=denegado');
}

?>

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
                <button class="c-mant__newBtn" id="c-mant__newBtn--bandas">+ Nuevo</button>
            </div>
            <table class="c-mant__table">
                <thead>
                    <tr class="c-mant__table__head-row">
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody id="c-mant__table__body--modos">
                </tbody>
            </table>
        </div>
    </div>
</div>