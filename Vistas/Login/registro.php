<?php
$valida = new Validacion();
$error = false;
$returnUrl = Sesion::leer('returnurl');
if (isset($_POST['cancelar'])) {
    header("location:?menu=login");
}

// Si interactua con el formulario

if (isset($_POST['continuar'])) {
    $valida->Indicativo("indicativo");
    $valida->Requerido("indicativo");
    $valida->CadenaRango('nombre', 45);
    $valida->Requerido("nombre");
    $valida->CadenaRango('apellido1', 45);
    $valida->Requerido("apellido1");
    ($valida->getValor('apellido2') !== '')? $valida->CadenaRango('apellido2', 45): null;
    $valida->Email('email');
    $valida->CadenaRango('email', 60);
    $valida->Requerido('email');
    $valida->Requerido('pass');
    $valida->Igual('pass2', 'pass');
    $valida->Requerido('pass2');
    //Comprobamos validacion
    if ($valida->ValidacionPasada()) {
        $datos = array(
            "id" => 0, "indicativo" => $valida->getValor('indicativo'),
            "nombre" => $valida->getValor('nombre'), "apellido1" => $valida->getValor('apellido1'),
            "apellido2" => $valida->getValor('apellido2'),  "email" => $valida->getValor('email'),
            "password" => $valida->getValor('pass2'), "rol" => 'user', "idParticipaciones" => []

        );
        $participante = new Participante();
        $participante->rellenarParticipante($datos);
        $rpParticipante = new RepParticipante($con);

        try {
            $rpParticipante->addParticipante($participante);
            Login::Identifica($con, $_POST['email'], $_POST['pass'], false);
        } catch (PDOException $e) {
            $error = true;
        }
    }
}
// Si esta logueado
if (Login::UsuarioEstaLogueado()) {
    header("location:?");
}

?>
<div class="c-container-login">
    <form class="c-card-formulario --registro" action="" method="post">
        <p class="c-card-formulario__titulo">Crear una cuenta</p>
        <div class="c-card-formulario__bloqueM">
            <label for="indicativo">Indicativo:</label>
            <input type="text" name="indicativo" class="c-card-formulario__input--registro" value="<?= $valida->getValor("indicativo") ?>">

            <!-- error -->
            <?php if (!$valida->ValidacionPasada()) {
                echo $valida->ImprimirError("indicativo");
            } ?>
        </div>
        <div class="c-card-formulario__bloqueM">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" class="c-card-formulario__input--registro" value="<?= $valida->getValor("nombre") ?>">

            <!-- error -->
            <?php if (!$valida->ValidacionPasada()) {
                echo $valida->ImprimirError("nombre");
            } ?>
        </div>
        <div class="c-card-formulario__bloqueM">
            <label for="apellido1">1º Apellido:</label>
            <input type="text" name="apellido1" class="c-card-formulario__input--registro" value="<?= $valida->getValor("apellido1") ?>">

            <!-- error -->
            <?php if (!$valida->ValidacionPasada()) {
                echo $valida->ImprimirError("apellido1");
            } ?>
        </div>
        <div class="c-card-formulario__bloqueM">
            <label for="apellido2">2º Apellido:</label>
            <input type="text" name="apellido2" class="c-card-formulario__input--registro" value="<?= $valida->getValor("apellido2") ?>">

            <!-- error -->
            <?php if (!$valida->ValidacionPasada()) {
                echo $valida->ImprimirError("apellido2");
            } ?>
        </div>
        <div class="c-card-formulario__bloqueL">
            <label for="email" class="c-card-formulario__label--registro">Email:</label>
            <input type="email" name="email" class="c-card-formulario__input--registro" value="<?= $valida->getValor("email") ?>">

            <!-- error -->
            <?php if (!$valida->ValidacionPasada()) {
                echo $valida->ImprimirError("email");
            } ?>
        </div>
        <div class="c-card-formulario__bloqueL">
            <label for="pass" class="c-card-formulario__label--registro">Contraseña:</label>
            <input type="password" name="pass" class="c-card-formulario__input--registro" value="<?= $valida->getValor("pass") ?>">

            <!-- error -->
            <?php if (!$valida->ValidacionPasada()) {
                echo $valida->ImprimirError("pass");
            } ?>
        </div>
        <div class="c-card-formulario__bloqueL">
            <label for="pass2" class="c-card-formulario__label--registro">Repetir contraseña:</label>
            <input type="password" name="pass2" class="c-card-formulario__input--registro" value="<?= $valida->getValor("pass2") ?>">

            <!-- error -->
            <?php if (!$valida->ValidacionPasada()) {
                echo $valida->ImprimirError("pass2");
            } ?>

            <?php
            if ($error) {
                echo "<span class='error_mensaje'>El indicativo o el email ya estan en uso.</span>";
            }
            ?>
        </div>
        <div class="c-card-formulario__bloqueBtn">
            <input type="submit" name="cancelar" value="Cancelar">
            <input type="submit" name="continuar" value="Continuar">
        </div>
    </form>
</div>