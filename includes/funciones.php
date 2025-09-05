<?php 

require 'app.php';

function incluirTemplates( string $nombre, bool $inicio) {
    include __DIR__ . "/templates/{$nombre}.php";
}

?>
