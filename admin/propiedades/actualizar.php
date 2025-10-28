<?php

use App\Propiedad;

require '../../includes/app.php';

// funcion de autenticacion
estaAutenticada();

//recibimos el id y validamos
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

//base de datos
$db = conectarBD();

incluirTemplates('header', false);

$propiedad = Propiedad::encontrar($id);

//consulta para obtener a todos los vendedores
$consulta = "SELECT * FROM vendedores;";
$resultadoVendedores =  mysqli_query($db, $consulta);

//arreglo con mensajes de error
$errores = [];

//ejecuta el codigo despues que el usuario envia el furmulario.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    debuguear($_POST);
    $args = $_POST['propiedad'];

    $propiedad->sincronizar($args);

    debuguear($propiedad);

    $imagen = $_FILES['imagen'];

    if (!$titulo) {
        $errores[] = "El campo titulo es obligatorio";
    }

    if (!$precio) {
        $errores[] = "El campo precio es obligatorio";
    }

    if (!$descripcion || strlen($descripcion) < 50) {
        $errores[] = "El campo descripcion es obligatorio y debe tener al menos 50 caracteres";
    }
    if (!$habitaciones) {
        $errores[] = "El campo habitaciones es obligatorio";
    }
    if (!$wc) {
        $errores[] = "El campo baños es obligatorio";
    }
    if (!$estacionamiento) {
        $errores[] = "El campo estacionamiento es obligatorio";
    }
    if (!$vendedorid) {
        $errores[] = "El campo vendedor es obligatorio";
    }

    // validamos por tamaño las imagenes(100kb máximo)
    $medida = 1024 * 1024; // 1 MB
    if ($imagen['size'] > $medida) {
        $errores[] = "la imagen es muy pesada";
    }

    //revisamos que el array de errores este vacio
    if (empty($errores)) {

        /** Subida de archivos **/

        // creamos carpetas
        $carpetaImagenes = "../../imagenes/";
        if (!is_dir($carpetaImagenes)) { //pregunta si no existe la carpeta ingresara y creara la carpeta.
            mkdir($carpetaImagenes);
        }

        if ($imagen['name']) {

            // Eliminar la imagen anterior si existe
            $rutaImagenAnterior = $carpetaImagenes . $imagenProp;

            // file_exists() Verifica si el archivo realmente existe en esa ruta. true o false
            if (file_exists($rutaImagenAnterior)) {
                unlink($rutaImagenAnterior); // unlink() Borra el archivo de manera definitiva del disco (del servidor).
            }

            //generar un nombre unico
            $nombreImagenes = md5(uniqid(rand(rand(), true))) . '.jpg';
        } else {
            $nombreImagenes = $imagenProp; // mantener la imagen anterior
        }

        // Subir la imagen
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagenes);

        // //actualizamos
        $stmt = $db->prepare("UPDATE propiedades  SET 
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
        $stmt->bind_param(
            "sissiiisii",
            $titulo,
            $precio,
            $nombreImagenes,
            $descripcion,
            $habitaciones,
            $wc,
            $estacionamiento,
            $creado,
            $vendedorid,
            $id
        );
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
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

    <?php if (!empty($errores)): ?>
        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="actualizar.php?id=<?php echo $id; ?>" method="POST" class="formulario" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" value="Actualizar propiedad" class="boton boton-verde">
    </form>
</main>

<?php
incluirTemplates('footer', false);
?>