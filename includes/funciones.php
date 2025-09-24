<?php 

require 'app.php';

function incluirTemplates( string $nombre, bool $inicio) {
    include __DIR__ . "/templates/{$nombre}.php";
}




function estaAutenticada() : bool {
    // Solo inicia la sesión si no hay una activa
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return $_SESSION['login'] ?? false;
}





?>


