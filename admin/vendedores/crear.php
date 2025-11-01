<?php
require '../../includes/app.php';

use App\Vendedor;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;

$auth = estaAutenticada();

// funcion de autenticacion
estaAutenticada();

$vendedor = new Vendedor;

//arreglo con mensajes de error
$errores = Vendedor::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
}

incluirTemplates('header', false);


?>
<main class="contenedor seccion">
    <h1>Registrar Vendedor</h1>

    <a href="/admin/" class="boton boton-verde">Volver</a>

    <?php if (!empty($errores)): ?>
        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>



    <form action="/admin/vendedores/crear.php" method="POST" class="formulario">

        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
    </form>
</main>

<?php
incluirTemplates('footer', false);
?>