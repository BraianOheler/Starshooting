<?php
// Incluir archivo de conexión a la base de datos
include("../../Conexion_BD_FinancieraStarshooting.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear o actualizar préstamo
    if (isset($_POST['guardar'])) {
        $ID_Prestamo = $_POST['ID_Prestamo'] ?? null; // Para identificar si es edición o creación
        $Monto_Prestamo = $_POST['Monto_Prestamo'];
        $Tasa_Interes = $_POST['Tasa_Interes'];
        $Plazo = $_POST['Plazo'];
        $Estado = $_POST['Estado'];
        $ID_cliente = $_POST['ID_cliente'];
        $ID_Cuenta = $_POST['ID_Cuenta'];
        $ID_Empleado = $_POST['ID_Empleado'];

        if ($ID_Prestamo) {
            // Actualizar préstamo existente
            $query = "UPDATE prestamo SET 
                        Monto_Prestamo = ?, 
                        Tasa_Interes = ?, 
                        Plazo = ?, 
                        Estado = ?, 
                        ID_cliente = ?, 
                        ID_Cuenta = ?, 
                        ID_Empleado = ? 
                      WHERE ID_Prestamo = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ddisiiii", $Monto_Prestamo, $Tasa_Interes, $Plazo, $Estado, $ID_cliente, $ID_Cuenta, $ID_Empleado, $ID_Prestamo);
        } else {
            // Insertar nuevo préstamo
            $query = "INSERT INTO prestamo (Monto_Prestamo, Tasa_Interes, Plazo, Estado, ID_cliente, ID_Cuenta, ID_Empleado) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ddisiii", $Monto_Prestamo, $Tasa_Interes, $Plazo, $Estado, $ID_cliente, $ID_Cuenta, $ID_Empleado);
        }

        if ($stmt->execute()) {
            header("Location: pres.php"); // Redirigir tras guardar
            exit;
        } else {
            die("Error al guardar el préstamo: " . $stmt->error);
        }
    }

    // Eliminar préstamo
    if (isset($_POST['eliminar'])) {
        $ID_Prestamo = $_POST['ID_Prestamo'];
        $query = "DELETE FROM prestamo WHERE ID_Prestamo = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param("i", $ID_Prestamo);

        if ($stmt->execute()) {
            header("Location: pres.php"); // Redirigir tras eliminar
            exit;
        } else {
            die("Error al eliminar el préstamo: " . $stmt->error);
        }
    }
}

// Obtener datos para listar en la tabla
$query = "SELECT * FROM prestamo";
$resultado = mysqli_query($link, $query);

// Obtener datos de un préstamo para editar
$prestamoEdit = [];
if (isset($_GET['edit'])) {
    $ID_Prestamo = intval($_GET['edit']);

    if (!$ID_Prestamo) {
        die("ID de préstamo no válido.");
    }

    $query = "SELECT * FROM prestamo WHERE ID_Prestamo = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $ID_Prestamo);
    $stmt->execute();
    $result = $stmt->get_result();
    $prestamoEdit = $result->fetch_assoc();

    if (!$prestamoEdit) {
        die("No se encontró el préstamo especificado.");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Préstamos</title>
    <link rel="stylesheet" href="presView.css">
</head>
<body>
    <div class="crud-container">
        <h1><?php echo isset($prestamoEdit['ID_Prestamo']) ? 'Editar Préstamo' : 'Crear Nuevo Préstamo'; ?></h1>

        <!-- Formulario -->
        <form method="POST" action="pres.php">
            <input type="hidden" name="ID_Prestamo" value="<?php echo htmlspecialchars($prestamoEdit['ID_Prestamo'] ?? ''); ?>">

            <label for="Monto_Prestamo">Monto del Préstamo:</label>
            <input type="number" step="0.01" id="Monto_Prestamo" name="Monto_Prestamo" 
                   value="<?php echo htmlspecialchars($prestamoEdit['Monto_Prestamo'] ?? ''); ?>" required>

            <label for="Tasa_Interes">Tasa de Interés (%):</label>
            <input type="number" step="0.01" id="Tasa_Interes" name="Tasa_Interes" 
                   value="<?php echo htmlspecialchars($prestamoEdit['Tasa_Interes'] ?? ''); ?>" required>

            <label for="Plazo">Plazo (Meses):</label>
            <input type="number" id="Plazo" name="Plazo" 
                   value="<?php echo htmlspecialchars($prestamoEdit['Plazo'] ?? ''); ?>" required>

            <label for="Estado">Estado:</label>
            <select id="Estado" name="Estado" required>
                <option value="Activo" <?php echo isset($prestamoEdit['Estado']) && $prestamoEdit['Estado'] == 'Activo' ? 'selected' : ''; ?>>Activo</option>
                <option value="Inactivo" <?php echo isset($prestamoEdit['Estado']) && $prestamoEdit['Estado'] == 'Inactivo' ? 'selected' : ''; ?>>Inactivo</option>
            </select>

            <label for="ID_cliente">ID del Cliente:</label>
            <input type="number" id="ID_cliente" name="ID_cliente" 
                   value="<?php echo htmlspecialchars($prestamoEdit['ID_cliente'] ?? ''); ?>" required>

            <label for="ID_Cuenta">ID de la Cuenta:</label>
            <input type="number" id="ID_Cuenta" name="ID_Cuenta" 
                   value="<?php echo htmlspecialchars($prestamoEdit['ID_Cuenta'] ?? ''); ?>" required>

            <label for="ID_Empleado">ID del Empleado:</label>
            <input type="number" id="ID_Empleado" name="ID_Empleado" 
                   value="<?php echo htmlspecialchars($prestamoEdit['ID_Empleado'] ?? ''); ?>" required>

            <button type="submit" name="guardar">Guardar</button>
        </form>

        <!-- Tabla -->
        <h2>Listado de Préstamos</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Monto</th>
                <th>Interés</th>
                <th>Plazo</th>
                <th>Estado</th>
                <th>ID Cliente</th>
                <th>ID Cuenta</th>
                <th>ID Empleado</th>
                <th>Acciones</th>
            </tr>
            <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($fila['ID_Prestamo']); ?></td>
                    <td><?php echo htmlspecialchars($fila['Monto_Prestamo']); ?></td>
                    <td><?php echo htmlspecialchars($fila['Tasa_Interes']); ?></td>
                    <td><?php echo htmlspecialchars($fila['Plazo']); ?></td>
                    <td><?php echo htmlspecialchars($fila['Estado']); ?></td>
                    <td><?php echo htmlspecialchars($fila['ID_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($fila['ID_Cuenta']); ?></td>
                    <td><?php echo htmlspecialchars($fila['ID_Empleado']); ?></td>
                    <td>
                        <a href="pres.php?edit=<?php echo $fila['ID_Prestamo']; ?>">Editar</a>
                        <form method="POST" action="pres.php" style="display:inline;">
                            <input type="hidden" name="ID_Prestamo" value="<?php echo $fila['ID_Prestamo']; ?>">
                            <button type="submit" name="eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>