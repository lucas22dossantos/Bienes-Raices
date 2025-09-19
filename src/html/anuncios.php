<?php 
  require __DIR__ . '../../../includes/funciones.php';

  incluirTemplates('header', $inicio = false);
?>

<main class="contenedor seccion">
      <h2>Casas y depas en venta</h2>
<?php

  $limite = 100;
require __DIR__ . '/../../includes/templates/mostrarAnuncios.php'; 
?>

</main>

<script src="../../build/js/bundle.min.js"></script>

<?php
  incluirTemplates('footer', $inicio = false);
?>