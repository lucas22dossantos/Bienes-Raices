<?php  

//conectar a la db

require  '../../includes/config/database.php';
$db = conectarBD();

// crear un email y contraseña

$email='email@gmail.com';
$contraseña = "1234";


// query para crear un usuario
$stmt = $db->prepare("INSERT INTO usuario (correo, contrasena) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $contraseña);

// ejecutar
$resultado = $stmt->execute();
            
if($resultado){
    echo "Usuario creado correctamente";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$db->close();
            
?>