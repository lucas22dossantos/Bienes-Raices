<?php 
  require __DIR__ . '/includes/funciones.php';

  incluirTemplates('header', $inicio = true);
?>

    <main class="contenedor seccion">
      <h1>Mas sobre nosotros</h1>
      <div class="icono-nosotros">
        <div class="icono">
          <img
            src="build/img/icono1.svg"
            alt="Icono seguraridad"
            loading="lazy"
          />
          <h3>Seguridad</h3>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit.
            Distinctio, minima sint architecto facere deleniti esse voluptatem
            numquam quae laborum sed ipsum. Exercitationem omnis laborum
            eligendi blanditiis laboriosam fugiat eum pariatur!
          </p>
        </div>
        <div class="icono">
          <img src="build/img/icono2.svg" alt="Icono precio" loading="lazy" />
          <h3>Precio</h3>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit.
            Distinctio, minima sint architecto facere deleniti esse voluptatem
            numquam quae laborum sed ipsum. Exercitationem omnis laborum
            eligendi blanditiis laboriosam fugiat eum pariatur!
          </p>
        </div>
        <div class="icono">
          <img src="build/img/icono3.svg" alt="Icono tiempo" loading="lazy" />
          <h3>A tiempo</h3>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit.
            Distinctio, minima sint architecto facere deleniti esse voluptatem
            numquam quae laborum sed ipsum. Exercitationem omnis laborum
            eligendi blanditiis laboriosam fugiat eum pariatur!
          </p>
        </div>
      </div>
    </main>

    <section class="seccion contenedor">
      <h2>Casas y depas en venta</h2>

      <?php include 'includes/templates/mostrarAnuncios.php'; ?>

      <div class="alinear-derecha">
        <a href="src/html/anuncios.php" class="boton-verde">Ver todas</a>
      </div>
    </section>

    <section class="imagen-contacto">
      <h2>Encuentra la casa de tus sueños</h2>
      <p>
        Llena el formulario de contacto y un asesor se podrá en contacto a la
        brevedad
      </p>
      <a href="src/html/contacto.php" class="boton-amarillo">Contactános</a>
    </section>

    <div class="contenedor seccion seccion-inferior">
      <section class="blog">
        <h3>Nuestra Blog</h3>

        <article class="entrada-blog">
          <div class="imagen">
            <picture>
              <source srcset="build/img/blog1.webp" type="image/webp" />
              <source srcset="build/img/blog1.jpg" type="image/jpeg" />
              <img src="build/img/blog1.jpg" alt="Texto entrada blog" />
            </picture>
          </div>

          <div class="texto-entrada">
            <a href="src/html/entrada.php">
              <h4>Terraza en el techo de tu casa</h4>
              <p class="informacion-meta">
                Escrito en: <span>20/10/2025</span> por: <span>Admin</span>
              </p>
              <p>
                Consejos para construir una terraza en el techo de tu casa con
                los mejores materiales y ahorrando dinero
              </p>
            </a>
          </div>
        </article>

        <article class="entrada-blog">
          <div class="imagen">
            <picture>
              <source srcset="build/img/blog2.webp" type="image/webp" />
              <source srcset="build/img/blog2.jpg" type="image/jpeg" />
              <img src="build/img/blog2.jpg" alt="Texto entrada blog" />
            </picture>
          </div>

          <div class="texto-entrada">
            <a href="src/html/entrada.php">
              <h4>Guía para la dechoración de tu hogar</h4>
              <p class="informacion-meta">
                Escrito en: <span>20/10/2025</span> por: <span>Admin</span>
              </p>
              <p>
                Maximiza el espacio en tu hogar con esta guía, aprende a
                combinar muebles y colores para darle vida a tu espacio
              </p>
            </a>
          </div>
        </article>
      </section>

      <section class="testimoniales">
        <h3>Testimoniales</h3>
        <div class="testimonial">
          <blockquote>
            El personal se comportó de una excelente forma, muy buena atención y
            la casa que me ofrecieron cumpe con todas mis expetativas
          </blockquote>
          <p>- Lucas</p>
        </div>
      </section>
    </div>

    
    <script src="build/js/bundle.min.js"></script>


      <?php
       incluirTemplates('footer', $inicio = false);
     ?>