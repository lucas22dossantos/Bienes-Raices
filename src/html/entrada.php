<?php // include '../../includes/templates/header.php'; ?>
<?php 
    require __DIR__ . '../../../includes/funciones.php';

  incluirTemplates('header', $inicio = false);
?>

    <main class="contenedor seccion contenido-centrado">
      <h1>Guía para la decoración de tu hogar</h1>
      <picture>
        <source srcset="../../build/img/destacada2.webp" type="img/webp" />
        <source srcset="../../build/img/destacada2.jpg" type="img/jpg" />
        <img
          loading="lazy"
          src="../../build/img/destacada2.jpg"
          alt="Anuncio"
        />
      </picture>

      <p class="informacion-meta">
        Escrito en: <span>20/10/2025</span> por: <span>Admin</span>
      </p>

      <div class="resumen-propiedad">
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae
          provident, velit aliquid corporis ducimus, quam numquam fuga
          consectetur autem eum doloribus laudantium, minus facere blanditiis
          ut! Perferendis facere incidunt atque. Lorem ipsum dolor, sit amet
          consectetur adipisicing elit. Perferendis deserunt sapiente
          dignissimos explicabo veritatis, quaerat minus nobis quis blanditiis
          doloremque rerum accusamus esse quam dolore error nisi veniam unde
          sequi? Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae
          provident, velit aliquid corporis ducimus, quam numquam fuga
          consectetur autem eum doloribus laudantium, minus facere blanditiis
          ut! Perferendis facere incidunt atque. Lorem ipsum dolor, sit amet
          consectetur adipisicing elit. Perferendis deserunt sapiente
          dignissimos explicabo veritatis, quaerat minus nobis quis blanditiis
          doloremque rerum accusamus esse quam dolore error nisi veniam unde
          sequi?
        </p>
      </div>
    </main>

    <script src="../../build/js/bundle.min.js"></script>

        <?php
       incluirTemplates('footer', $inicio = false);
     ?>