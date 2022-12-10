<?php
$modo = 'Nuevo';

if (isset($_GET['modo']) && $_GET['modo'] === 'edita') {
    $modo = "Edita";
}
?>
<form action="" id="c-card-formulario__form--modo">
    <div class="c-card-formulario --modo">
        <div class="c-card-formulario__titulo"><?= $modo ?> Modo</div>
        <div class="c-card-formulario__bloqueL">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" class="c-card-formulario__input--registro">
            <span class="c-card-formulario__error" id="error-modo-nombre" style="display: none;"></span>
        </div>
        <div class="c-card-formulario__bloqueM">
            <input type="submit" name="enviar" value="Aceptar" id="c-card-formulario__btnAceptar--modo">
        </div>
    </div>
</form>