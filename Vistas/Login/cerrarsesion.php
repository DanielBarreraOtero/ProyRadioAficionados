<?php
Sesion::escribir('login',false);
Sesion::escribir('rol',"guest");
Sesion::eliminar("participante");
setcookie("recuerdame","", -10);
header("location:?");
?>