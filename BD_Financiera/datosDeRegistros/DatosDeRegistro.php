<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Financiera Starshooting</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
    <style>
        body {
            background-image: url('fondoLogin.png'); /* Asegúrate de que esta ruta sea correcta */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #3a6ebc;
            color: white;
            border: none;
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
    </style>
</head>
<body>

    <?php 
        
        if (isset($_POST['enviar'])){
            $Nombre = $_POST['Nombre'];
            $Apellido = $_POST['Apellido'];
            $Direccion = $_POST['Direccion'];
            $Telefono = $_POST['Telefono'];
            $Email = $_POST['Email'];
            $Fecha_nacimiento = $_POST['Fecha_nacimiento'];
            $Tipo_cliente = $_POST['Tipo_cliente'];

            include("../Conexion_BD_FinancieraStarshooting.php");

            $sql = "INSERT INTO cliente (Nombre,Apellido,Direccion,Telefono,Email,Fecha_nacimiento,Tipo_cliente)
            values ('$Nombre', '$Apellido', '$Direccion','$Telefono', '$Email', '$Fecha_nacimiento','$Tipo_cliente')";

            $resultado = mysqli_query($link, $sql);


            if ($resultado) {
                $ID_cliente = mysqli_insert_id($link);
                echo "<script>
                        alert('Registro exitoso. Su ID de cliente es: $ID_cliente no lo olvide pues lo necesitara para iniciar sesion');
                        location.assign('../LoginFinanciera/Login.php');
                      </script>";
            } else {
                echo "<script>
                        alert('Error al registrar. Intente nuevamente.');
                        location.assign('../Registro/Registro.php');
                      </script>";
            }
        
            mysqli_close($link);

        }


     ?>



    <div class="login-container">
        <h1>Registro de Cliente</h1>
        <!-- Formulario consolidado -->
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <!-- Datos personales -->
            <input type="text" name="Nombre" placeholder="Ingrese su Nombre" required>
            <input type="text" name="Apellido" placeholder="Ingrese su Apellido" required>
            <input type="text" name="Direccion" placeholder="Ingrese su Dirección" required>
            <input type="tel" name="Telefono" placeholder="Ingrese su Teléfono" pattern="[0-9]{10}" required>
            
            <!-- Datos de cuenta -->
            <input type="email" name="Email" placeholder="Ingrese su Email" required>

             <!-- Datos adicionales -->
            <label for="dob">Fecha de Nacimiento:</label>
            <input type="date" id="dob" name="Fecha_nacimiento" required>

            <select name="Tipo_cliente" required>
                <option value="" disabled selected>Seleccione Tipo de Cliente</option>
                <option value="Juridico">Jurídico</option>
                <option value="Fisico">Físico</option>
            </select>
            
            <!-- Botón de envío -->
            <button type="submit" name="enviar">Registrar</button>
        </form>
    </div>
</body>
</html>
