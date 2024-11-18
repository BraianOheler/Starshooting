<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Financiera Starshooting</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
    <style>
        /* Estilos para el fondo de la página */
        body {
            background-image: url('fondoLogin.png'); /* Asegúrate de que esta ruta sea correcta */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            margin: 0; /* Elimina márgenes por defecto */
        }
        /* Ajustes del contenedor de login */
        .login-container {
            background-color: rgba(255, 255, 255, 0.9); /* Fondo semitransparente */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        /* Estilos de los inputs y botones */
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #3a6ebc;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #335d99;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        p {
            margin-top: 15px;
        }
    </style>
</head> 
<body>

<?php
if (isset($_POST['enviar'])) {

    // Verificamos si se han ingresado todos los datos
    if (empty($_POST['ID_usuario']) || empty($_POST['Username']) || empty($_POST['PasswordHash']) || empty($_POST['Rol'])) {
        echo "<script>
        alert('El ID, nombre de usuario, la contraseña o el rol no han sido ingresados');
        location.assign('Login.php');
        </script>";
        exit;
    }

    include("../Conexion_BD_FinancieraStarshooting.php");

    // Obtener los datos del formulario
    $ID_usuario = $_POST['ID_usuario']; // Puede ser cliente o empleado
    $username = $_POST['Username'];
    $passwordHash = $_POST['PasswordHash'];
    $Rol = $_POST['Rol']; // El rol puede ser 'cliente' o 'empleado'

    // Primero verificamos si el ID es de un cliente
    if ($Rol == 'Cliente') {
        $sql_cliente = "SELECT * FROM usuarios WHERE ID_cliente = '$ID_usuario' AND Username = '$username' AND PasswordHash = '$passwordHash' AND Rol = 'Cliente'";
        $resultado_cliente = mysqli_query($link, $sql_cliente);

        if ($fila_cliente = mysqli_fetch_assoc($resultado_cliente)) {
            // Si el usuario es cliente
            echo "<script>
            alert('¡Bienvenido Cliente!');
            location.assign('../inicioCliente/home.html'); 
            </script>";
        } else {
            echo "<script>
            alert('El nombre de usuario, la contraseña o el ID de cliente ingresado son incorrectos');
            location.assign('Login.php');
            </script>";
        }
    }
    // Si no es un cliente, verificamos si es un empleado
    elseif ($Rol == 'Empleado') {
        $sql_empleado = "SELECT * FROM usuarios WHERE ID_empleado = '$ID_usuario' AND Username = '$username' AND PasswordHash = '$passwordHash' AND Rol = 'Empleado'";
        $resultado_empleado = mysqli_query($link, $sql_empleado);

        if ($fila_empleado = mysqli_fetch_assoc($resultado_empleado)) {
            // Si el usuario es empleado
            echo "<script>
            alert('¡Bienvenido Empleado!');
            location.assign('../inicioEmpleado/home.html');
            </script>";
        } else {
            echo "<script>
            alert('El nombre de usuario, la contraseña o el ID de empleado ingresado son incorrectos');
            location.assign('Login.php');
            </script>";
        }
    }
    else {
        echo "<script>
        alert('El rol ingresado es incorrecto');
        location.assign('Login.php');
        </script>";
    }

    mysqli_close($link);
}
?>


    <div class="login-container">
    <h2>Iniciar Sesión</h2>
    <form id="loginForm" method="POST">
        <input type="text" name="ID_usuario" placeholder="Ingrese su ID de cliente o empleado" required>
        <br>
        <input type="text" name="Username" placeholder="Ingrese su usuario" required>
        <br>
        <input type="password" name="PasswordHash" placeholder="Ingrese su Contraseña" required>
        <br>
        <!-- Desplegable para seleccionar el rol -->
        <select name="Rol" required>
            <option value="">Seleccione su rol</option>
            <option value="Cliente">Cliente</option>
            <option value="Empleado">Empleado</option>
            <option value="Administrador">Administrador</option>
        </select>
        <br>
        <button type="submit" name="enviar" value="INGRESAR">Iniciar Sesión</button>
    </form>
    <br>
    <a href="../Registro/Registro.php">No tienes una cuenta? Haz clic aquí para Registrarte</a>
    <p id="errorMessage" style="color: red;"></p>
</div>

</body>
</html>
