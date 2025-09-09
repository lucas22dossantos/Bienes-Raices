<?php

//base de datos
    require '../../includes/config/database.php';
    $db = conectarBD();

    require '../../includes/funciones.php';
    incluirTemplates('header',false);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        echo '<pre> ';
            var_dump($_POST);
        echo '</pre> ';

        $titulo = $_POST['titulo'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $habitaciones = $_POST['habitaciones'];
        $wc = $_POST['wc'];
        $estacionamiento = $_POST['estacionamiento'];
        $vendedorid = $_POST['vendedorid'];

        //Insertamos en la base de datos

        $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, vendedores_id)
        VALUES ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedorid');"; 

        $resultado = mysqli_query($db, $query);

        if($resultado){
            echo 'Insertado Correctamente';
        }
        
    }

?>
<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/admin/" class="boton boton-verde">Volver</a>

    <form action="/admin/propiedades/crear.php" method="POST" class="formulario">
        <fieldset>
            <legend>Informacion general</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio propiedad">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"></textarea>
 
        </fieldset>
        <fieldset>
            <legend>Informacion Habitaciones</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9">

            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9">

            <label for="estacionamiento">Estacionamientos:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 2" min="1" max="9">

 
        </fieldset>

         <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedorid" id="vendedorid">
                <option value="1">Juan</option>
                <option value="2">Lucas</option>
            </select>
        </fieldset>

        <input type="submit" value="Crear propiedad" class="boton boton-verde">
    </form>
</main>

<?php
    incluirTemplates('footer', false);
?>