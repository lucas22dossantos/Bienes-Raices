<?php

$resultado = isset($_GET['resultado']) ?? null;

require '../includes/funciones.php';
incluirTemplates('header',false);

?>
<main class="contenedor seccion">
    <h1>Administrador de bienes raices</h1>

    <?php if(intval($resultado) === 1):  ?>
        <p class="alerta exito">Anuncio creado correctamente</p>
    <?php endif?>

    <a href="propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
</main>

<?php
incluirTemplates('footer', false);
?>