<?php include '../../includes/templates/header.php'; ?>


    <main class="contenedor seccion contenido-centrado">
      <h1>Casa en venta frente al bosque</h1>
      <picture>
        <source srcset="../../build/img/destacada.webp" type="img/webp" />
        <source srcset="../../build/img/destacada.jpg" type="img/jpg" />
        <img loading="lazy" src="../../build/img/destacada.jpg" alt="Anuncio" />
      </picture>

      <div class="resumen-propiedad">
        <p class="precio">$3,000,000</p>
        <ul class="icono-caracteristicas">
          <li>
            <img
              class="icono"
              loading="lazy"
              src="../../build/img/icono_wc.svg"
              alt="Icono WC"
            />
            <p>3</p>
          </li>
          <li>
            <img
              class="icono"
              loading="lazy"
              src="../../build/img/icono_estacionamiento.svg"
              alt="Icono estacionamiento"
            />
            <p>3</p>
          </li>
          <li>
            <img
              class="icono"
              loading="lazy"
              src="../../build/img/icono_dormitorio.svg"
              alt="Icono dormitorio"
            />
            <p>4</p>
          </li>
        </ul>

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

    <?php include '../../includes/templates/footer.php'; ?>
    <script src="../../build/js/bundle.min.js"></script>
