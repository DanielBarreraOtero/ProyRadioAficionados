<?php
$con = GBD::getConnection("localhost", "radioaficionadosbdnew");
if (!Login::UsuarioEstaLogueado() && !Login::UsuarioRecordado($con)) {
    Login::Identifica($con, "guest", "guest", false);
}
// Dependiendo de el rol que tenga (invitado, usuario-normal, usuario-admin)
// Le aparecerá un menú de usuario diferente (invitado o usuario) y 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RadioAficionados</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/modal.js"></script>
    <script src="js/burgerIcon.js"></script>
    <script src="js/navHandler.js"></script>
    <script src="js/mantenimientoConcursos.js"></script>
    <script src="js/mantenimientoUsuarios.js"></script>
    <script src="js/mantenimientoBandaModo.js"></script>
    <script src="js/pageConcurso.js"></script>
    <script src="js/cardConcursoHandler.js"></script>
</head>

<body>
    <?php
    require_once './Vistas/Principal/header.php';
    ?>
    <section id="main-section">
        <nav class="c-nav">
            <ul class="c-nav__menu">
                <?php if (Sesion::leer('rol') === 'admin') {
                ?>
                    <li><a class="c-nav__link" id="link-mantenimientoConc" title="Mantenimiento de Concursos">⚙️ Concursos</a></li>
                    <li><a class="c-nav__link" id="link-mantenimientoUsu" title="Mantenimiento de Usuarios">⚙️ Usuarios</a></li>
                    <li><a class="c-nav__link" id="link-mantenimientoBandaModo" title="Mantenimiento de Bandas y Modos">⚙️ Bandas y Modos</a></li>
                <?php
                } ?>
                <?php if (Sesion::leer('rol') !== 'guest') {
                ?>
                    <li><a class="c-nav__link" id="link-mensajes" title="Mis Mensajes">✉️ Mis Mensajes</a></li>
                    <li><a class="c-nav__link" id="link-carrera" title="Mi Carrera">🏁 Mi Carrera</a></li>
                <?php
                } ?>

                <?php if (Sesion::leer('rol') === 'guest') {
                ?>
                    <li><a class="c-nav__link" id="link-iniciar">Iniciar Sesión</a></li>
                <?php
                } ?>
            </ul>
        </nav>
        <div id="cuerpo">
            <?php
            require_once './Vistas/Principal/enruta.php';
            ?>
        </div>
    </section>

    <?php
    require_once './Vistas/Principal/footer.php';
    ?>

</body>

</html>