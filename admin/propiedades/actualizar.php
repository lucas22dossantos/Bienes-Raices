<?php
require '../../includes/app.php';

use App\Propiedad;
use App\Vendedor;

use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;


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
$vendedores = Vendedor::todas();

//arreglo con mensajes de error
$errores = Propiedad::getErrores();

//ejecuta el codigo despues que el usuario envia el furmulario.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // debuguear($_POST);
    $args = $_POST['propiedad'];

    $propiedad->sincronizar($args);
    // Asegurarse que la propiedad correcta tenga el valor del select
    if (isset($args['vendedores_id'])) {
        $propiedad->vendedorid = $args['vendedores_id'];
    }

    // validacion
    $errores = $propiedad->validar();

    // Generar nombre único para la imagen
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    //revisamos que el array de errores este vacio
    if (empty($errores)) {

        $imagen = $_FILES['propiedad']['imagen'] ?? null;

        // Procesar imagen si hay una nueva
        if ($imagen && $imagen['tmp_name']) {
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            $manager = new Image(new Driver());
            $img = $manager->read($imagen['tmp_name'])
                ->resize(800, 600)
                ->toJpeg(85);

            $img->save(CARPETA_IMAGENES . $nombreImagen);

            $propiedad->imagen = $nombreImagen;
        }

        $propiedad->guardar();
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