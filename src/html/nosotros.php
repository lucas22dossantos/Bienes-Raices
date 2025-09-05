<?php //include '../../includes/templates/header.php'; ?>
<?php 
    require __DIR__ . '../../../includes/funciones.php';

  incluirTemplates('header', $inicio = false);
?>

    <main class="contenedor seccion">
      <h1>Conose sobre nosotros</h1>

      <div class="contenido-nosotros">
        <div class="imagen">
          <picture>
            <source srcset="../../build/img/nosotros.webp" type="image/webp" />
            <source srcset="../../build/img/nosotros.jpg" type="image/jpeg" />
            <img src="../../build/img/nosotros.jpg" alt="Sobre nosotros" />
          </picture>
        </div>
        <div class="texto-nosotros">
          <blockquote>25 Años de experiencia</blockquote>
          <p>
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Unde quod
            facere beatae repellendus quas vero maiores fugiat corrupti
            similique illo! Nam nobis aut id et quibusdam libero, expedita
            beatae ratione? Lorem ipsum dolor sit amet consectetur, adipisicing
            elit. Unde quod facere beatae repellendus quas vero maiores fugiat
            corrupti similique illo! Nam nobis aut id et quibusdam libero,
            expedita beatae ratione? Lorem ipsum dolor sit amet consectetur,
            adipisicing elit. Unde quod facere beatae repellendus quas vero
            maiores fugiat corrupti similique illo! Nam nobis aut id et
            quibusdam libero, expedita beatae ratione? Lorem ipsum dolor sit
            amet consectetur, adipisicing elit. Unde quod facere beatae
            repellendus quas vero maiores fugiat corrupti similique illo! Nam
            nobis aut id et quibusdam libero, expedita beatae ratione?
          </p>
          <p>
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Animi non
            fuga aliquam voluptatibus sapiente veritatis suscipit tempore sequi
            sunt dolorum, nobis quo culpa ad. Repellat quis non quo incidunt
            tempore.
          </p>
        </div>
      </div>
    </main>

    <section class="contenedor seccion">
      <h1>Mas sobre nosotros</h1>
      <div class="icono-nosotros">
        <div class="icono">
          <img
            src="../../build/img/icono1.svg"
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
          <img
            src="../../build/img/icono2.svg"
            alt="Icono precio"
            loading="lazy"
          />
          <h3>Precio</h3>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit.
            Distinctio, minima sint architecto facere deleniti esse voluptatem
            numquam quae laborum sed ipsum. Exercitationem omnis laborum
            eligendi blanditiis laboriosam fugiat eum pariatur!
          </p>
        </div>
        <div class="icono">
          <img
            src="../../build/img/icono3.svg"
            alt="Icono tiempo"
            loading="lazy"
          />
          <h3>A tiempo</h3>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit.
            Distinctio, minima sint architecto facere deleniti esse voluptatem
            numquam quae laborum sed ipsum. Exercitationem omnis laborum
            eligendi blanditiis laboriosam fugiat eum pariatur!
          </p>
        </div>
      </div>
    </section>

    <script src="../../build/js/bundle.min.js"></script>

        <?php
       incluirTemplates('footer', $inicio = false);
     ?>