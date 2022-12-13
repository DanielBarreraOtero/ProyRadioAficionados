<?php
$valida = new Validacion();
$returnUrl = Sesion::leer('returnurl'); // Cojo el backlink
Sesion::escribir("returnurl", 'login'); // setteo uno nuevo

$incorrecto = false;

// Si selecciona crear una cuenta nueva
if (isset($_POST['registro'])) {
    header("location:?menu=registro");
}

// Si interactua con el formulario
if (isset($_POST['login'])) {
    $valida->Email('email');
    $valida->CadenaRango('email',60);
    $valida->Requerido('email');
    $valida->Requerido('pass');
    //Comprobamos validacion
    if ($valida->ValidacionPasada()) {
        Login::Identifica(
            $con,
            $_POST['email'],
            $_POST['pass'],
            isset($_POST['recuerdame']) ? $_POST['recuerdame'] : false
        )? $incorrecto = false: $incorrecto = true;
    }
}

// Si esta logueado
if (Login::UsuarioEstaLogueado()) {
    // si tenia backlink y este no era login lo redirecciono a ese
    // si no tenia o era login, lo redirecciono a inicio
    $url = ($returnUrl !== null && $returnUrl !== 'login') ? $returnUrl : 'inicio';
    header("location:?");
}
?>
<div class="c-container-login">
    <form class="c-card-formulario --login" action="" method="post">
        <p class="c-card-formulario__titulo">Iniciar sesión</p>
        <div class="c-card-formulario__bloqueL">
            <label for="email" class="c-card-formulario__label--registro">Email:</label>
            <input type="email" name="email" class="c-card-formulario__input--registro"
            value="<?= $valida->getValor("email") ?>">

            <!-- error -->
            <?php if (!$valida->ValidacionPasada()) {
                echo $valida->ImprimirError("email");
            } ?>
        </div>
        <div class="c-card-formulario__bloqueL">
            <label for="pass" class="c-card-formulario__label--registro">Contraseña:</label>
            <input type="password" name="pass" class="c-card-formulario__input--registro"
            value="<?= $valida->getValor("pass") ?>">

            <!-- error -->
            <?php if (!$valida->ValidacionPasada()) {
                echo $valida->ImprimirError("pass");
            } 
            if ($incorrecto) {
                echo "<span class='error_mensaje'>Usuario o contraseña incorrectos</span>";
            }?>
        </div>
        <div class="c-card-formulario__bloqueCheck">
            <label for="recuerda" class="c-card-formulario__label--registro">Recordárme:</label>
            <input type="checkbox" name="recuerdame" class="c-card-formulario__check--registro">
        </div>
        <div class="c-card-formulario__bloqueL">
            <input type="submit" name="login" class="c-boton" value="Iniciar sesión">
        </div>
        <p class="c-card-formulario__spacer">- O -</p>
        <div class="c-card-formulario__bloqueL">
            <input type="submit" name="registro" class="c-boton" value="Crear nueva cuenta">
        </div>
    </form>
</div>