<header class="c-header">
    <div class="c-header__box--left">
        <button class="c-burgerButton" aria-controls="nav" aria-expanded="false">
            <svg class="c-burgerButton__icon" viewBox="0 0 100 100" height="100%">
                <rect class="c-burgerButton__linea--first" width="80" height="15" x="10" y="17.5
                " rx="7"></rect>
                <rect class="c-burgerButton__linea--second" width="80" height="15" x="10" y="42.5" rx="7"></rect>
                <rect class="c-burgerButton__linea--third" width="80" height="15" x="10" y="67.5" rx="7"></rect>
            </svg>

        </button>
    </div>
    <div class="c-header__box--center">
        <img src="imgs/radio-tower.png" alt="peta" class="c-header__logo"> <p class="c-header__titulo">RadioAficionados</p>
        
    </div>
    <div class="c-header__box--right">
        <?php
        if (!Login::UsuarioEstaLogueado()) {
        ?>
            <p>¡Bienvenido Invitado!</p>
            <a href="?menu=login">Iniciar Sesión</a>
        <?php
        } else {
        ?>
            <p>¡Bienvenido <?= Sesion::leer("participante")->getNombre() ?>!</p>
            <p><?= "Rol: ".Sesion::leer("rol") ?></p>
            <a style="text-decoration: none;" href="?menu=cerrarsesion">❌</a>
        <?php
        }
        ?>
    </div>
</header>