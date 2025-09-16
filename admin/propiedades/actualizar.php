<?php

//recibimos el id y validamos
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id){
    header('Location:/admin');
}

//base de datos
    require '../../includes/config/database.php';
    $db = conectarBD();

    require '../../includes/funciones.php';
    incluirTemplates('header',false);

    //Consulta traer los datos de propiedades
    $consultaProp = "SELECT * FROM propiedades WHERE id =" . $id . ";";
    $resultadoProp =  mysqli_query($db, $consultaProp);
    $propiedad = mysqli_fetch_assoc($resultadoProp);

    //consulta para obtener a todos los vendedores
    $consulta = "SELECT * FROM vendedores;";
    $resultadoVendedores =  mysqli_query($db, $consulta);

    //arreglo con mensajes de error
    $errores = [];

    $titulo = $propiedad['titulo'];
    $precio = $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $estacionamiento = $propiedad['estacionamiento'];
    $vendedorid = $propiedad['vendedores_id'];
    $imagenProp = $propiedad['imagen'];

    //ejecuta el codigo despues que el usuario envia el furmulario.
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        

        // echo '<pre>';
        // var_dump($_POST);
        // echo '</pre>';

        // exit;

        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
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

            if($imagen['name']){

                // Eliminar la imagen anterior si existe
                $rutaImagenAnterior = $carpetaImagenes . $imagenProp;

                // file_exists() Verifica si el archivo realmente existe en esa ruta. true o false
                if(file_exists($rutaImagenAnterior)){ 
                    unlink($rutaImagenAnterior); // unlink() Borra el archivo de manera definitiva del disco (del servidor).
                }
                
                //generar un nombre unico
                $nombreImagenes = md5(uniqid(rand(rand(), true))) . '.jpg'  ;
                var_dump($nombreImagenes);
            } else {
                $nombreImagenes = $imagenProp; // mantener la imagen anterior
            }

            // Subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagenes);

            // //actualizamos
            $stmt = $db->prepare ("UPDATE propiedades  SET 
                titulo = ?, 
                precio = ?, 
                imagen = ?, 
                descripcion = ?, 
                habitaciones = ?, 
                wc = ?, 
                estacionamiento = ?, 
                creado = ?, 
                vendedores_id = ? 
                WHERE id = ?");
            $stmt->bind_param("sissiiisii", $titulo, $precio, $nombreImagenes, $descripcion, $habitaciones, $wc, $estacionamiento, $creado, $vendedorid, $id);
            $stmt->execute();

            // echo $stmt;


            if($stmt->affected_rows > 0){
                //rediccionar al usuario
                header('Location: /admin?resultado=2');
                exit;
            }
        }
    }

?>
<main class="contenedor seccion">
    <h1>Actualizar propiedad</h1>

    <a href="/admin/" class="boton boton-verde">Volver</a>

    <?php if(!empty($errores)): ?>
    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

        

    <form action="actualizar.php?id=<?php echo $id; ?>"  method="POST" class="formulario" enctype="multipart/form-data">
        <fieldset>
            <legend>Informacion general</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad" value="<?php echo htmlspecialchars($titulo); ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">
            <img src="/imagenes/<?php echo $propiedad['imagen'];?>" alt="" class="imagen-small">

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

        <input type="submit" value="Actualizar propiedad" class="boton boton-verde">
    </form>
</main>

<?php
    incluirTemplates('footer', false);
?>