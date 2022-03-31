<?php
session_set_cookie_params(01 * 60 * 60);
session_start();
session_destroy();
header("Location: Inicio.php");
?>