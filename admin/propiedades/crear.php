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
        $descripcion = $_POST['descripcion'];

        // $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
        // $precio = mysqli_real_escape_string($db, $_POST['precio']);
        // $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        // $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
        // $wc = mysqli_real_escape_string($db, $_POST['wc']);
        // $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
        // $vendedorid = mysqli_real_escape_string($db, $_POST['vendedorid']);
        $creado = date('Y-m-d');

        $precio = filter_var($_POST['precio'], FILTER_VALIDATE_INT);
        $habitaciones = filter_var($_POST['habitaciones'], FILTER_VALIDATE_INT);
        $wc = filter_var($_POST['wc'], FILTER_VALIDATE_INT);
        $estacionamiento = filter_var($_POST['estacionamiento'], FILTER_VALIDATE_INT);
        $vendedorid = filter_var($_POST['vendedorid'], FILTER_VALIDATE_INT);

        $imagen = $_FILES['imagen'];

       
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
        if(!$imagen['name'] || $imagen['error']){
            $errores[] = "el campo de imagenes no pude estar vacia";
        }

        // validamos por tamaño las imagenes(100kb máximo)
        $medida = 1024 * 1024; // 1 MB
        if($imagen['size'] > $medida){
            $errores[] = "la imagen es muy pesada";
        }


        //revisamos que el array de errores este vacio
        if(empty($errores)){

            /** Subida de archivos **/ 

            // creamos carpetas
            $carpetaImagenes = "../../imagenes/";
            if(!is_dir($carpetaImagenes)){ //pregunta si no existe la carpeta ingresara y creara la carpeta.
                mkdir($carpetaImagenes);
            }

            //generar un nombre unico
            $nombreImagenes = md5(uniqid(rand(rand(), true))) . '.jpg'  ;
            var_dump($nombreImagenes);


            // Subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagenes);

            // exit;



            //Insertamos en la base de datos
            $stmt = $db->prepare("INSERT INTO propiedades 
                (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sissiiisi", $titulo, $precio, $nombreImagenes, $descripcion, $habitaciones, $wc, $estacionamiento, $creado, $vendedorid);
            $stmt->execute();


            // $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id)
            // VALUES ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedorid');"; 

            // $resultadoInsert  = mysqli_query($db, $query);
  
            if($stmt->affected_rows > 0){
                //rediccionar al usuario
                header('Location: /admin?resultado=1');
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

        

    <form action="/admin/propiedades/crear.php" method="POST" class="formulario" enctype="multipart/form-data">
        <fieldset>
            <legend>Informacion general</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad" value="<?php echo htmlspecialchars($titulo); ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($descripcion); ?></textarea>

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