<?php
// logout.php

// Inicio la sesión para acceder a las variables de sesión existentes
session_start();

// Elimino todas las variables de sesión
session_unset();

// Destruyo la sesión actual
session_destroy();

// Redirijo al usuario a la página de inicio de sesión
header("Location: login.php");
exit(); // Aseguro que el script termine aquí
?>
