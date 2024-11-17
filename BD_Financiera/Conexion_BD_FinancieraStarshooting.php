<?php
$nombrebd = "financiera_starshooting";
$nombreServidor = "localhost";
$nombreUsuario = "root";
$contrasbd = "";

// Crear conexión
$link = mysqli_connect($nombreServidor, $nombreUsuario, $contrasbd, $nombrebd);

// Verificar la conexión
if ($link) {
    echo "Bienvenido a la página web de FINANCIERA STARSHOOTING, la conexión ha sido exitosa a la base de datos: " . $nombrebd;
} else {
    // Mostrar mensaje de error si la conexión falla
    echo "Error de conexión: " . mysqli_connect_error();
}
?>