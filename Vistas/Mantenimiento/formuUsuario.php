<?php
$modo = 'Nuevo';

if (isset($_GET['modo']) && $_GET['modo'] === 'edita') {
    $modo = "Edita";
}
?>
<form action="" id="c-card-formulario__form--usuario">
    <div class="c-card-formulario --usuario">
        <div class="c-card-formulario__titulo"><?= $modo ?> Usuario</div>
        <div class="c-card-formulario__bloqueXM--row">
            <div class="c-card-formulario__bloqueM">
                <label for="indicativo" class="c-card-formulario__label--registro">Indicativo:</label>
                <input type="text" name="indicativo" class="c-card-formulario__input--registro">
                <span class="c-card-formulario__error" id="error-usuario-indicativo" style="display: none;"></span>
            </div>
            <div class="c-card-formulario__bloqueM">
                <label for="nombre" class="c-card-formulario__label--registro">Nombre:</label>
                <input type="text" name="nombre" class="c-card-formulario__input--registro">
                <span class="c-card-formulario__error" id="error-usuario-nombre" style="display: none;"></span>
            </div>
            <div class="c-card-formulario__bloqueM">
                <label for="apellido1" class="c-card-formulario__label--registro">1º Apellido:</label>
                <input type="text" name="apellido1" class="c-card-formulario__input--registro">
                <span class="c-card-formulario__error" id="error-usuario-apellido1" style="display: none;"></span>
            </div>
            <div class="c-card-formulario__bloqueM">
                <label for="apellido2" class="c-card-formulario__label--registro">2º Apellido:</label>
                <input type="text" name="apellido2" class="c-card-formulario__input--registro">
                <span class="c-card-formulario__error" id="error-usuario-apellido2" style="display: none;"></span>
            </div>
            <div class="c-card-formulario__bloqueM">
                <label for="email" class="c-card-formulario__label--registro">Email:</label>
                <input type="email" name="email" class="c-card-formulario__input--registro">
                <span class="c-card-formulario__error" id="error-usuario-email" style="display: none;"></span>
            </div>
            <div class="c-card-formulario__bloqueM --nomargins">
                <label for="rol" class="c-card-formulario__label--registro">Rol:</label>
                <div class="c-card-formulario__bloqueL --nomargins">
                    <div class="c-card-formulario__bloqueL--row--radius --nomargins">
                        <label for="rol">Admin: </label>
                        <input type="radio" name="rol" value="admin" class="c-card-formulario__radius">
                        <label for="rol">Usuario: </label>
                        <input type="radio" name="rol" value="user" class="c-card-formulario__radius">
                    </div>
                </div>
                <span class="c-card-formulario__error" id="error-usuario-rol" style="display: none;"></span>
            </div>
        </div>
        <div class="c-card-formulario__bloqueM">
            <label for="participaciones" class="c-card-formulario__label--registro">Participaciones:</label>
            <div class="c-card-formulario__participaciones-box" name="participaciones"></div>
        </div>

        <div class="c-card-formulario__bloqueL--row">
            <div class="c-card-formulario__bloqueS">
                <input type="submit" name="enviar" value="Aceptar" class="c-boton" id="c-card-formulario__btnAceptar--modo">
            </div>
        </div>
    </div>
</form>