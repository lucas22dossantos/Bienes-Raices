<?php
require '../includes/funciones.php';
$auth = estaAutenticada();

if (!$auth) {
    header('Location: ../src/html/login.php'); // o donde tengas el login
    exit;
}


// importar la conexion
require '../includes/config/database.php';
$db = conectarBD();

// escribir el query
$query = 'SELECT * FROM propiedades';

// consultar la base de datos
$consulta = mysqli_query($db, $query);

// mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        //Eliminar el archivo
        $query = 'SELECT imagen FROM propiedades WHERE id =' . $id;

        $resultado = mysqli_query($db, $query);
        $propiedades = mysqli_fetch_assoc($resultado);

        unlink('../imagenes/' . $propiedades['imagen']);

        // Elimina la propiedad
        $query = 'DELETE FROM propiedades WHERE id =' . $id;

        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            header('Location: /admin?resultado=3');
        }
    }
}

// incluye un template
incluirTemplates('header', false);

?>
<main class="contenedor seccion">
    <h1>Administrador de bienes raices</h1>

    <?php if (intval($resultado) === 1):  ?>
        <p class="alerta exito"> Anuncio creado correctamente</p>
    <?php elseif (intval($resultado) === 2): ?>
        <p class="alerta exito"> Anuncio actualizado correctamente</p>
    <?php elseif (intval($resultado) === 3): ?>
        <p class="alerta exito"> Anuncio eliminado correctamente</p>
    <?php endif ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody> <!--mostrar los resultados de la consulta -->
            <?php while ($propiedades = mysqli_fetch_assoc($consulta)): ?>
                <tr>
                    <td><?php echo $propiedades['id']; ?></td>
                    <td><?php echo $propiedades['titulo']; ?></td>
                    <td><?php echo $propiedades['precio']; ?></td>
                    <td> <img src="/imagenes/<?php echo $propiedades['imagen']; ?>" alt=""></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedades['id']; ?>">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">
                        </form>
                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedades['id']; ?>"
                            class="boton-amarillo-block">actualizar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>



</main>

<?php

//cerrar la conexion a la db.
mysqli_close($db);

incluirTemplates('footer', false);
?>