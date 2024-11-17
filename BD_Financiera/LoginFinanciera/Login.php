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

if(isset($_POST['enviar'])) {

    if(empty($_POST['ID_cliente'] || $_POST['Username']) || empty($_POST['PasswordHash'])) {
        echo "<script>
        alert('El ID_cliente o nombre de usuario o la contraseña no han sido ingresados');
        location.assign('Login.php');
        </script>";
    } else {
        include("../Conexion_BD_FinancieraStarshooting.php");

        // Usar las variables correctas para las columnas de la base de datos
        $ID_cliente = $_POST['ID_cliente'];
        $username = $_POST['Username'];
        $passwordHash = $_POST['PasswordHash'];
        $Rol = $_POST['Rol'];

        // Consulta usando las variables correctas
       $sql = "SELECT * FROM usuarios WHERE ID_cliente = '$ID_cliente' AND Username = '$username' AND PasswordHash = '$passwordHash' AND Rol = '$Rol'";

        $resultado = mysqli_query($link, $sql);

        if($fila = mysqli_fetch_assoc($resultado)) {
            echo "<script>
            alert('¡Bienvenido querido Usuario!');
            location.assign('../homeFinanciera/home.html');
            </script>";
        } else {
            echo "<script>
            alert('El nombre de usuario , la contraseña o el rol ingresado son incorrectos');
            location.assign('Login.php');
            </script>";
        }
        mysqli_close($link);
    }
}
?>

       <div class="login-container">
    <h2>Iniciar Sesión</h2>
    <form id="loginForm" method="POST">
        <input type="text" name="ID_cliente" placeholder="Ingrese su ID de cliente" required>
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
