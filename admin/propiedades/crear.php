<?php
require '../../includes/app.php';

use App\Propiedad;
use App\Vendedor;

use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;

$auth = estaAutenticada();

// funcion de autenticacion
estaAutenticada();

$propiedad = new Propiedad;

incluirTemplates('header', false);

//consulta para obtener todos los vendedores
$vendedores = Vendedor::todas();

//arreglo con mensajes de error
$errores = Propiedad::getErrores();

//ejecuta el codigo despues que el usuario envia el furmulario.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // crear una nueva instancia
    $propiedad = new Propiedad($_POST['propiedad']);

    // Verificar si se subió una imagen
    if (
        isset($_FILES['propiedad']['tmp_name']['imagen']) &&
        $_FILES['propiedad']['error']['imagen'] === UPLOAD_ERR_OK
    ) {
        $imagen = [
            'name' => $_FILES['propiedad']['name']['imagen'],
            'type' => $_FILES['propiedad']['type']['imagen'],
            'tmp_name' => $_FILES['propiedad']['tmp_name']['imagen'],
            'error' => $_FILES['propiedad']['error']['imagen'],
            'size' => $_FILES['propiedad']['size']['imagen']
        ];

        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        $propiedad->imagen = $nombreImagen;
    } else {
        $imagen = null;
    }


    // validar
    $errores = $propiedad->validar();

    if (empty($errores)) {

        // Crear carpeta si no existe
        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES, 0777, true);
        }

        if ($imagen) {
            // Procesar la imagen con Intervention
            try {
                $manager = new Image(new Driver());

                $img = $manager->read($imagen['tmp_name'])
                    ->resize(800, 600)
                    ->toJpeg(85);

                // Guardar la imagen en la carpeta destino
                $img->save(CARPETA_IMAGENES . $nombreImagen);

                // Asignar el nombre a la propiedad
                $propiedad->imagen = $nombreImagen;

                // Guardar en base de datos
                $propiedad->guardar();
            } catch (Exception $e) {
                $errores[] = "Error al procesar la imagen: " . $e->getMessage();
            }
        }
    }
}

?>
<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/admin/" class="boton boton-verde">Volver</a>

    <?php if (!empty($errores)): ?>
        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>



    <form action="/admin/propiedades/crear.php" method="POST" class="formulario" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" value="Crear propiedad" class="boton boton-verde">
    </form>
</main>

<?php
incluirTemplates('footer', false);
?>