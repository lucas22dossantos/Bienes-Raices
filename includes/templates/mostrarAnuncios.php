<?php 
    //base de datos
    require __DIR__ . '/../config/database.php';

    $db = conectarBD();

    // Usar el límite pasado, o 3 por defecto si no existe
    if(!isset($limite)) {
        $limite = 3;
    }
    
    // escribir el query
    $query = 'SELECT * FROM propiedades LIMIT ' . $limite;

    // consultar la base de datos
    $consulta = mysqli_query($db, $query);
?>


<div class="contenedor-anuncios">
    <?php while($propiedades = mysqli_fetch_assoc($consulta)): ?>
            <div class="anuncio">
            <picture>
                <img src="/imagenes/<?php echo $propiedades['imagen']; ?>" alt="">
            </picture>

            <div class="contenido-anuncio">
                <h3><?php echo $propiedades['titulo']; ?></h3>
                <p>
                <?php echo $propiedades['descripcion']; ?>
                </p>
                <p class="precio"><?php echo $propiedades['precio']; ?></p>

                <ul class="icono-caracteristicas">
                <li>
                    <img
                    class="icono"
                    loading="lazy"
                    src="/build/img/icono_wc.svg"
                    alt="Icono WC"
                    />
                    <p><?php echo $propiedades['wc']; ?></p>
                </li>
                <li>
                    <img
                    class="icono"
                    loading="lazy"
                    src="/build/img/icono_estacionamiento.svg"
                    alt="Icono estacionamiento"
                    />
                    <p><?php echo $propiedades['estacionamiento']; ?></p>
                </li>
                <li>
                    <img
                    class="icono"
                    loading="lazy"
                    src="/build/img/icono_dormitorio.svg"
                    alt="Icono dormitorio"
                    />
                    <p><?php echo $propiedades['habitaciones']; ?></p>
                </li>
                </ul>

                <a href="anuncio.php?id=<?php echo $propiedades['id']; ?>" class="boton boton-amarillo-block">
                Ver propiedades
                </a>
            </div>
            </div>
    <?php endwhile; ?>
</div>

 
<?php
    //cerramos la conexionde la db 
    mysqli_close($db); 
?>
        
    