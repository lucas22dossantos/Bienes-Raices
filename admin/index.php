<?php

// importar la conexion
require '../includes/config/database.php';
$db = conectarBD();

// escribir el query
$query = 'SELECT * FROM propiedades';

// consultar la base de datos
$consulta = mysqli_query($db, $query);

// mensaje condicional
$resultado = isset($_GET['resultado']) ?? null;

// incluye un template
require '../includes/funciones.php';
incluirTemplates('header',false);

?>
<main class="contenedor seccion">
    <h1>Administrador de bienes raices</h1>

    <?php if(intval($resultado) === 1):  ?>
        <p class="alerta exito">Anuncio creado correctamente</p>
    <?php elseif(intval($resultado) === 2): ?>
        <p class="alerta exito">Anuncio actualizado correctamente</p>
    <?php endif?>

    <a href="propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

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
        <?php while( $propiedades = mysqli_fetch_assoc($consulta)): ?>
        <tr>
            <td><?php echo $propiedades['id']; ?></td>
            <td><?php echo $propiedades['titulo']; ?></td>
            <td><?php echo $propiedades['precio']; ?></td>
            <td> <img src="/imagenes/<?php echo $propiedades['imagen']; ?>" alt=""></td>
            <td>
                <a href="#">Eliminar</a>
                <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedades['id']; ?>">actulizar</a>
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