<?php
$modo = 'Nuevo';

if (isset($_GET['modo']) && $_GET['modo'] === 'edita') {
    $modo = "Edita";
}
?>
<div class="c-card-formulario --concurso">
    <div class="c-card-formulario__titulo"><?= $modo ?> Concurso</div>
    <div class="c-card-formulario__bloqueM">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" class="c-card-formulario__input--registro">
        <p class="c-card-formulario__spacer">Fechas de Inscripción</p>
        <div class="c-card-formulario__bloqueL--row">
            <label for="fIniInscrp">Inicio:</label>
            <input type="date" name="fIniInscrp" class="c-card-formulario__date">
            <label for="fFinInscrp">Fin:</label>
            <input type="date" name="fFinInscrp" class="c-card-formulario__date">
        </div>
        <p class="c-card-formulario__spacer">Fechas de Concurso</p>
        <div class="c-card-formulario__bloqueL--row">
            <label for="fIniCon">Inicio:</label>
            <input type="date" name="fIniCon" class="c-card-formulario__date">
            <label for="fFinCon">Fin:</label>
            <input type="date" name="fFinCon" class="c-card-formulario__date">
        </div>
    </div>
    <div class="c-card-formulario__bloqueM">
        <label for="desc">Descripción:</label>
        <input type="text" name="desc" class="c-card-formulario__tArea">
    </div>
</div>