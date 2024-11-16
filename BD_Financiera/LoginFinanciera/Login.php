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

    if(empty($_POST['Username']) || empty($_POST['PasswordHash'])) {
        echo "<script>
        alert('El nombre de usuario o la contraseña no han sido ingresados');
        location.assign('Login.php');
        </script>";
    } else {
        include("../Conexion_BD_FinancieraStarshooting.php");

        // Usar las variables correctas para las columnas de la base de datos
        $username = $_POST['Username'];
        $passwordHash = $_POST['PasswordHash'];
        $Rol = $_POST['Rol'];

        // Consulta usando las variables correctas
       $sql = "SELECT * FROM usuarios WHERE Username = '$username' AND PasswordHash = '$passwordHash' AND Rol = '$Rol'";

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
        <!-- Agregar el método POST y acción del formulario -->
        <form id="loginForm" method="POST">
            <input type="text" name="Username" placeholder="🧑 Usuario" required>
            <input type="password" name="PasswordHash" placeholder="🔒 Contraseña" required>
            <select name="Rol" required>
                <option value="" disabled selected>Selecciona un rol</option>
                <option value="cliente">Cliente</option>
                <ul></ul>
                <option value="empleado">Empleado</option>
                <option value="administrador">Administrador</option>
            </select>
            <ul>           






















            </ul>
            
            <button type="submit" name="enviar" value="INGRESAR"> Iniciar Sesión </button>
            
        </form>
      
        <p id="errorMessage" style="color: red;"></p>
    </div>
    <a href="../Registro/Registro.php" target="_blank">No tienes una cuenta? Click aqui para "Registrarse"</a>

</a>

</body>
</html>
