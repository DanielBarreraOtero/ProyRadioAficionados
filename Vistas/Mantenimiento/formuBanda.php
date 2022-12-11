<?php
$modo = 'Nueva';

if (isset($_GET['modo']) && $_GET['modo'] === 'edita') {
    $modo = "Edita";
}
?>
<form action="" id="c-card-formulario__form--banda">
    <div class="c-card-formulario --banda">
        <div class="c-card-formulario__titulo"><?= $modo ?> Banda</div>
        <div class="c-card-formulario__bloqueL">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" class="c-card-formulario__input--registro">
            <span class="c-card-formulario__error" id="error-banda-nombre" style="display: none;"></span>
        </div>
        <div class="c-card-formulario__bloqueL--row">
            <div class="c-card-formulario__bloqueS">
                <label for="distancia">Distancia:</label>
                <input type="number" name="distancia" class="c-card-formulario__input--registro">
                <span class="c-card-formulario__error" id="error-banda-distancia" style="display: none;"></span>
            </div>
            <div class="c-card-formulario__bloqueS">
                <label for="rangoMin">RangoMin:</label>
                <input type="number" name="rangoMin" class="c-card-formulario__input--registro">
                <span class="c-card-formulario__error" id="error-banda-rangoMin" style="display: none;"></span>
            </div>
            <div class="c-card-formulario__bloqueS">
                <label for="rangoMax">RangoMax:</label>
                <input type="number" name="rangoMax" class="c-card-formulario__input--registro">
                <span class="c-card-formulario__error" id="error-banda-rangoMax" style="display: none;"></span>
            </div>
        </div>
        <div class="c-card-formulario__bloqueL--row">
            <div class="c-card-formulario__bloqueS">
                <input type="submit" name="enviar" value="Aceptar" id="c-card-formulario__btnAceptar--modo">
            </div>
        </div>
    </div>
</form>