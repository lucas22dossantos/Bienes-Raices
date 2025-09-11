<?php

//base de datos
    require '../../includes/config/database.php';
    $db = conectarBD();

    require '../../includes/funciones.php';
    incluirTemplates('header',false);

    //consulta para obtener a todos los vendedores
    $consulta = "SELECT * FROM vendedores;";
    $resultadoVendedores =  mysqli_query($db, $consulta);

    //arreglo con mensajes de error
    $errores = [];

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedorid = '';

    //ejecuta el codigo despues que el usuario envia el furmulario.
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        

        $titulo = $_POST['titulo'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $habitaciones = $_POST['habitaciones'];
        $wc = $_POST['wc'];
        $estacionamiento = $_POST['estacionamiento'];
        $vendedorid = $_POST['vendedorid'];
        $creado = date('y/m/d');

        if(!$titulo){
            $errores[] = "El campo titulo es obligatorio";
        }
        if(!$precio){
            $errores[] = "El campo precio es obligatorio";
        }
        if(!$descripcion || strlen($descripcion) < 50){
            $errores[] = "El campo descripcion es obligatorio y debe tener al menos 50 caracteres";
        }
        if(!$habitaciones){
            $errores[] = "El campo habitaciones es obligatorio";
        }
        if(!$wc){
            $errores[] = "El campo baños es obligatorio";
        }
        if(!$estacionamiento){
            $errores[] = "El campo estacionamiento es obligatorio";
        }
        if(!$vendedorid){
            $errores[] = "El campo vendedor es obligatorio";
        }

        // echo '<pre> ';
        //     var_dump($_POST);
        // echo '</pre> ';
        // exit;

        //revisamos que el array de errores este vacio
        if(empty($errores)){
            
            //Insertamos en la base de datos
            $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id)
            VALUES ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedorid');"; 

            $resultadoInsert  = mysqli_query($db, $query);
 
                
             if($resultadoInsert){
                //rediccionar al usuario
                header('Location: /admin');
                exit;
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
            <input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
 
        </fieldset>
        <fieldset>
            <legend>Informacion Habitaciones</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">

            <label for="estacionamiento">Estacionamientos:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 2" min="1" max="9" value="<?php echo $estacionamiento; ?>">

 
        </fieldset>

         <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedorid" id="vendedorid">
                <option value="">-- Seleccione --</option>
                    <?php while($vendedor = mysqli_fetch_assoc($resultadoVendedores)) : ?>
                        <option <?php echo $vendedorid == $vendedor['id'] ? 'selected' : '' ?> value="<?php echo $vendedor['id'] ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor["apellido"] ?> </option>
                    <?php endwhile ?>
            </select>
        </fieldset>

        <input type="submit" value="Crear propiedad" class="boton boton-verde">
    </form>
</main>

<?php
    incluirTemplates('footer', false);
?>