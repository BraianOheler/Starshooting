<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$database = "financiera_starshooting";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Manejo de acciones CRUD
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
        $Fecha_Pago = $_POST['Fecha_Pago'];
        $Monto = $_POST['Monto'];
        $Medio_Pago = $_POST['Medio_Pago'];
        $ID_Prestamo = $_POST['ID_Prestamo'];

        $sql = "INSERT INTO pago (Fecha_Pago, Monto, Medio_Pago, ID_Prestamo) VALUES ('$Fecha_Pago', '$Monto', '$Medio_Pago', '$ID_Prestamo')";
        $conn->query($sql);
    }

    if (isset($_POST['update'])) {
        $ID_Pago = $_POST['ID_Pago'];
        $Fecha_Pago = $_POST['Fecha_Pago'];
        $Monto = $_POST['Monto'];
        $Medio_Pago = $_POST['Medio_Pago'];
        $ID_Prestamo = $_POST['ID_Prestamo'];

        $sql = "UPDATE pago SET Fecha_Pago='$Fecha_Pago', Monto='$Monto', Medio_Pago='$Medio_Pago', ID_Prestamo='$ID_Prestamo' WHERE ID_Pago=$ID_Pago";
        $conn->query($sql);
    }

    if (isset($_POST['delete'])) {
        $ID_Pago = $_POST['ID_Pago'];
        $sql = "DELETE FROM pago WHERE ID_Pago=$ID_Pago";
        $conn->query($sql);
    }
}

// Obtener todos los pagos
$pagos = $conn->query("SELECT * FROM pago");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Pagos</title>
    <link rel="stylesheet" href="papo.css">

</head>
<body>
    <!-- Barra de Navegación -->
    <div class="navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                <h1 style="color: white;">Gestión de Pagos</h1>
            </div>
        </div>
    </div>

    <!-- Sección Principal -->
    <div class="main-section">
        <div class="content">
            <h1>Agregar Nuevo Pago</h1>
            <form method="POST">
                <label for="Fecha_Pago">Fecha de Pago:</label>
                <input type="date" id="Fecha_Pago" name="Fecha_Pago" required>
                <label for="Monto">Monto:</label>
                <input type="number" id="Monto" name="Monto" step="0.01" required>
                <label for="Medio_Pago">Medio de Pago:</label>
                <input type="text" id="Medio_Pago" name="Medio_Pago" maxlength="30" required>
                <label for="ID_Prestamo">ID del Préstamo:</label>
                <input type="number" id="ID_Prestamo" name="ID_Prestamo" required>
                <button type="submit" name="create" class="action-button">Guardar</button>
            </form>
        </div>
    </div>

    <!-- Tabla de Pagos -->
    <div class="accounts-section">
        <h2>Lista de Pagos</h2>
        <table border="1" width="100%" style="text-align: center;">
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Medio</th>
                <th>ID Préstamo</th>
                <th>Acciones</th>
            </tr>
            <?php while ($pago = $pagos->fetch_assoc()): ?>
            <tr>
                <form method="POST">
                    <td><input type="hidden" name="ID_Pago" value="<?= $pago['ID_Pago'] ?>"><?= $pago['ID_Pago'] ?></td>
                    <td><input type="date" name="Fecha_Pago" value="<?= $pago['Fecha_Pago'] ?>" required></td>
                    <td><input type="number" name="Monto" step="0.01" value="<?= $pago['Monto'] ?>" required></td>
                    <td><input type="text" name="Medio_Pago" value="<?= $pago['Medio_Pago'] ?>" maxlength="30" required></td>
                    <td><input type="number" name="ID_Prestamo" value="<?= $pago['ID_Prestamo'] ?>" required></td>
                    <td>
                        <button type="submit" name="update" class="action-button">Actualizar</button>
                        <button type="submit" name="delete" class="action-button" style="background: red;">Eliminar</button>
                    </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Pie de Página -->
    <footer>
        <p>Gestión de Pagos - © 2024</p>
    </footer>
</body>
</html>
