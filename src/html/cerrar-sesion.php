<?php

session_start();

// Vaciar todas las variables de sesión
$_SESSION = [];

// Destruir la sesión en el servidor
session_destroy();
 
// Redirigir al inicio
header('Location: /');
exit;