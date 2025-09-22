<?php 
    require __DIR__ . '../../../includes/funciones.php';

  incluirTemplates('header', $inicio = false);
?>
    <main class="contenedor seccion">
      <h1>Contacto</h1>

      <picture>
        <source srcset="../../build/img/destacada3.webp" type="image/webp" />
        <source srcset="../../build/img/destacada3.jpg" type="image/jpeg" />
        <img src="../../build/img/destacada3.jpg" alt="imagen de contacto" />
      </picture>

      <h2>Llene el formulario</h2>

      <form action="" class="formulario">
        <fieldset>
          <legend>Información personal</legend>

          <label for="nombre">Nombre:</label>
          <input
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Tu nombre"
            required
          />

          <label for="email">Email:</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="Tu correo electrónico"
            required
          />

          <label for="telefono">Teléfono:</label>
          <input
            type="tel"
            id="telefono"
            name="telefono"
            placeholder="Tu teléfono"
            required
            pattern="[0-9]{10}"
          />

          <label for="mensaje">Mensaje:</label>
          <textarea
            id="mensaje"
            name="mensaje"
            placeholder="Tu mensaje"
            required
          ></textarea>
        </fieldset>

        <fieldset>
          <legend>Información sobre la propiedad</legend>

          <label for="opciones">Vende o compra:</label>
          <select id="opciones" name="opciones" required>
            <option value="" disabled selected>-- Seleccione --</option>
            <option value="compra">Compra</option>
            <option value="vende">Vende</option>
          </select>

          <label for="presupuesto">Precio o presupuesto:</label>
          <input
            type="number"
            id="presupuesto"
            name="presupuesto"
            placeholder="Precio o presupuesto"
            required
          />
        </fieldset>

        <fieldset>
          <legend>Contacto</legend>
          <p>¿Cómo desea ser contactado?</p>

          <div class="forma-contacto">
            <label for="contactar-telefono">Teléfono:</label>
            <input
              type="radio"
              id="contactar-telefono"
              name="contacto"
              value="telefono"
              required
            />

            <label for="contactar-email">Email:</label>
            <input
              type="radio"
              id="contactar-email"
              name="contacto"
              value="email"
            />
          </div>

          <p>Si eligió teléfono, seleccione fecha y hora:</p>

          <label for="fecha">Fecha:</label>
          <input type="date" id="fecha" name="fecha" />

          <label for="hora">Hora:</label>
          <input type="time" id="hora" name="hora" min="09:00" max="18:00" />
        </fieldset>

        <input
          type="submit"
          value="Enviar"
          class="boton-verde"
          aria-label="Enviar formulario de contacto"
        />
      </form>
    </main>

    <script src="../../build/js/bundle.min.js"></script>

        <?php
       incluirTemplates('footer', $inicio = false);
     ?>