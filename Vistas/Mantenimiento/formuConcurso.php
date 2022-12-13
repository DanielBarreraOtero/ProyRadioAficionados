<?php
$modo = 'Nuevo';

if (isset($_GET['modo']) && $_GET['modo'] === 'edita') {
    $modo = "Edita";
}
?>
<form action="" id="c-card-formulario__form--banda">
    <div class="c-card-formulario --concurso">
        <div class="c-card-formulario__titulo"><?= $modo ?> Concurso</div>
        <div class="c-card-formulario__bloqueM">
            <label for="nombre" class="c-card-formulario__label--registro">Nombre:</label>
            <input type="text" name="nombre" class="c-card-formulario__input--registro">
            <div class="c-card-formulario__bloqueL--row --flex-center --flex-around --nomargins   ">
                <div class="c-card-formulario__bloqueL --nomargins">
                    <p class="c-card-formulario__subtitulo">Inscripción</p>
                    <div class="c-card-formulario__bloqueS">
                        <label for="fIniInscrp" class="c-card-formulario__label--registro">Inicio:</label>
                        <input type="date" name="fIniInscrp" class="c-card-formulario__date">
                        <label for="fFinInscrp" class="c-card-formulario__label--registro">Fin:</label>
                        <input type="date" name="fFinInscrp" class="c-card-formulario__date">
                    </div>
                </div>
                <!-- </div>
        <div class="c-card-formulario__bloqueL--row --flex-center --flex-around"> -->
                <div class="c-card-formulario__bloqueL --nomargins">
                    <p class="c-card-formulario__subtitulo">Concurso</p>
                    <div class="c-card-formulario__bloqueS">
                        <label for="fIniCon" class="c-card-formulario__label--registro">Inicio:</label>
                        <input type="date" name="fIniCon" class="c-card-formulario__date">
                        <label for="fFinCon" class="c-card-formulario__label--registro">Fin:</label>
                        <input type="date" name="fFinCon" class="c-card-formulario__date">
                    </div>
                </div>
            </div>
        </div>
        <div class="c-card-formulario__bloqueM">
            <label for="desc" class="c-card-formulario__label--registro">Descripción:</label>
            <input type="text" name="desc" class="c-card-formulario__tArea">

            <div class="c-card-formulario__bloqueL--row --flex-around">
                <div class="c-card-formulario__bloqueM">
                    <label for="bandas" class="c-card-formulario__label--registro">Bandas:</label>
                    <select name="bandas" class="c-card-formulario__select" multiple>
                        <option value="ejemplo">ejemplo</option>
                    </select>
                </div>
                <div class="c-card-formulario__bloqueM">
                    <label for="modos" class="c-card-formulario__label--registro">Modos:</label>
                    <select name="modos" class="c-card-formulario__select" multiple>
                        <option value="ejemplo">ejemplo</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="c-card-formulario__bloqueL--row">
            <div class="c-card-formulario__bloqueS">
                <input type="submit" name="enviar" value="Aceptar" class="c-boton" id="c-card-formulario__btnAceptar--modo">
            </div>
        </div>
    </div>
</form>