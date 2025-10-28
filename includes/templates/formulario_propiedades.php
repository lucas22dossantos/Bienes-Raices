<fieldset>
    <legend>Informacion general</legend>

    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo propiedad" value="<?php echo san($propiedad->titulo); ?>">

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio propiedad" value="<?php echo san($propiedad->precio); ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="propiedad[imagen]" accept="image/jpeg, image/png">

    <?php if ($propiedad->imagen): ?>
        <img src="/imagenes/<?php echo san($propiedad->imagen); ?>" class="imagen-small">
    <?php endif; ?>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="propiedad[descripcion]"><?php echo san($propiedad->descripcion); ?></textarea>

</fieldset>
<fieldset>
    <legend>Informacion Habitaciones</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej: 3" min="1" max="9" value="<?php echo san($propiedad->habitaciones); ?>">

    <label for="wc">Baños:</label>
    <input type="number" id="wc" name="propiedad[wc]" placeholder="Ej: 3" min="1" max="9" value="<?php echo san($propiedad->wc); ?>">

    <label for="estacionamiento">Estacionamientos:</label>
    <input type="number" id="estacionamiento" name="propiedad[estacionamiento]" placeholder="Ej: 2" min="1" max="9" value="<?php echo san($propiedad->estacionamiento); ?>">


</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    <input type="text" id="vendedor" name="propiedad[vendedor]" placeholder="Nombre del vendedor" value="1">

</fieldset>