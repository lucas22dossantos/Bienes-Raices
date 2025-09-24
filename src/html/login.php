<?php 
session_start();

//conexion a la bd
    require '../../includes/config/database.php';
    $db = conectarBD();

//auntenticar el usuario
    $errores = [];
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST['contraseña']);

        if(!$email){
            $errores[] = 'Correo inválido';
        }
        if(!$password){
            $errores[] =  'El campo contraseña es obligatorio';
        }

        if(empty($errores)){
            //revisa si el usuario existe
            $stmt = $db->prepare("SELECT * FROM usuario WHERE correo = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows) {
                $usuario = $resultado->fetch_assoc();
                
                // verificar si la contraseña es correcta
                $auth = password_verify($password, $usuario['contrasena']);

                if($auth){
                
                    // llenar el arreglo de la sesión
                    $_SESSION['usuario'] = $usuario['correo'];
                    $_SESSION['login'] = true;

                    header('Location: ../../admin/');

                }else{
                    $errores[] = "La contraseña es incorrecta";
                }

            } else {
                $errores[] = "El usuario no existe";
            }

        }
    }

// incluimos el header
    require __DIR__ . '../../../includes/funciones.php';
    incluirTemplates('header', $inicio = false);
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>

    <?php foreach($errores as $error) :?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach?>

    <form method="POST" class="formulario">
        <fieldset>
          <legend>Correo y Contraseña</legend>

          <label for="email">Email:</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="Tu correo electrónico"
            required
          />

          <label for="contraseña">Contraseña:</label>
          <input
            type="password"
            id="contraseña"
            name="contraseña"
            placeholder="Tu contraseña"
            required 
          />

        </fieldset>

        <input type="submit" value="Iniciar sesión" class="boton boton-verde">
    </form>
</main>

<?php
    incluirTemplates('footer', $inicio = false);
?>