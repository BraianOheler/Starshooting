<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Financiera Starshooting</title>
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
        /* Ajustes del contenedor de registro */
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
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <?php
        if (isset($_POST['enviar'])) {
            $nombre = $_POST['Username'];
            $password = $_POST['PasswordHash'];
            $Rol = $_POST['Rol'];
            $ID_cliente = $_POST['ID_cliente'];
        
            if ($nombre !== $_POST['UsernameConfirm']) {
                echo "<script>alert('Los nombres de usuario no coinciden.'); location.assign('../Registro/Registro.php');</script>";
                exit;
            }
        
            if ($password !== $_POST['PasswordHashConfirm']) {
                echo "<script>alert('Las contraseñas no coinciden.'); location.assign('../Registro/Registro.php');</script>";
                exit;
            }

        
            include("../Conexion_BD_FinancieraStarshooting.php");
        
            $sql = "INSERT INTO usuarios (Username, PasswordHash, Rol, ID_cliente) VALUES ('$nombre', '$password', '$Rol',
            '$ID_cliente')";
        
            $resultado = mysqli_query($link, $sql);
        
            if ($resultado) {
                echo "<script>
                        alert('Los datos fueron ingresados correctamente');
                        location.assign('../LoginFinanciera/Login.php');
                      </script>";
            } else {
                echo "<script>
                        alert('No fue posible ingresar los datos...');
                        location.assign('../Registro/Registro.php');
                      </script>";
            }
        
            mysqli_close($link);
        }
    ?>




    <div class="login-container">
        <h1>Crear Cuenta</h1>
        <!-- Formulario con método POST -->
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <input type="text" name="Username" placeholder="Ingrese su Usuario" required>
            <input type="text" name="UsernameConfirm" placeholder="Repita su Usuario" required>
            <br>
            <input type="password" name="PasswordHash" placeholder="Ingrese una Contraseña" required>
            <input type="password" name="PasswordHashConfirm" placeholder="Repita la Contraseña" required>
            
            <select name="Rol" required>
                <option value="" disabled selected>Selecciona un rol</option>
                <option value="cliente">Cliente</option>
                <option value="empleado">Empleado</option>
                <option value="administrador">Administrador</option>
            </select>
            <br>
             <input type="text" name="ID_cliente" placeholder="Ingrese su ID de Cliente" required>
            
            <button type="submit" name="enviar">Crear Cuenta</button>
        </form>
    </div>
</body>
</html>
