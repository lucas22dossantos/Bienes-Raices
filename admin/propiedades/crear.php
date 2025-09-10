<?php

//base de datos
    require '../../includes/config/database.php';
    $db = conectarBD();

    require '../../includes/funciones.php';
    incluirTemplates('header',false);

    //arreglo con mensajes de error
    $errores = [];


    //ejecuta el codigo despues que el usuario envia el furmulario.
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        

        $titulo = $_POST['titulo'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $habitaciones = $_POST['habitaciones'];
        $wc = $_POST['wc'];
        $estacionamiento = $_POST['estacionamiento'];
        $vendedorid = $_POST['vendedorid'];

        if(!$titulo){
            $errores[] = "El campo titulo es obligario";
        }
        if(!$precio){
            $errores[] = "El campo precio es obligario";
        }
        if(strlen(!$descripcion) < 50){
            $errores[] = "El campo descripcion es obligario y debe de tener almenos 50 caracteres";
        }
        if(!$habitaciones){
            $errores[] = "El campo habitaciones es obligario";
        }
        if(!$wc){
            $errores[] = "El campo baños es obligario";
        }
        if(!$estacionamiento){
            $errores[] = "El campo estacionamiento es obligario";
        }
        if(!$vendedorid){
            $errores[] = "El campo vendedor es obligario";
        }

        // echo '<pre> ';
        //     var_dump($errores);
        // echo '</pre> ';
        // exit;

        //revisamos que el array de errores este vacio
        if(empty($errores)){
            
            //Insertamos en la base de datos
            $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, vendedores_id)
            VALUES ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedorid');"; 

            $resultado = mysqli_query($db, $query);

            if($resultado){
                echo 'Insertado Correctamente';
            }
        }
    }

?>
<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/admin/" class="boton boton-verde">Volver</a>

    <?php if(!empty($errores)): ?>
    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

        

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
                <option value="">>-- selecione --<</option>
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