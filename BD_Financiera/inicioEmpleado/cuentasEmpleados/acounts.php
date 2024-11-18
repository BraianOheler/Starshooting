<?php
// Incluir archivo de conexión a la base de datos
include("../../Conexion_BD_FinancieraStarshooting.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear o actualizar cuenta
    if (isset($_POST['guardar'])) {
        $ID_Cuenta = $_POST['ID_Cuenta'] ?? null; // Para identificar si es edición o creación
        $Numero_Cuenta = $_POST['Numero_Cuenta'];
        $Tipo_Cuenta = $_POST['Tipo_Cuenta'];
        $Saldo = $_POST['Saldo'];
        $Fecha_Apertura = $_POST['Fecha_Apertura'];
        $Estado = $_POST['Estado'];
        $ID_Cliente = $_POST['ID_Cliente'];

        if ($ID_Cuenta) {
            // Actualizar cuenta existente
            $query = "UPDATE cuenta SET 
                        Numero_Cuenta = ?, 
                        Tipo_Cuenta = ?, 
                        Saldo = ?, 
                        Fecha_Apertura = ?, 
                        Estado = ?, 
                        ID_Cliente = ? 
                      WHERE ID_Cuenta = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ssdssii", $Numero_Cuenta, $Tipo_Cuenta, $Saldo, $Fecha_Apertura, $Estado, $ID_Cliente, $ID_Cuenta);
        } else {
            // Insertar nueva cuenta
            $query = "INSERT INTO cuenta (Numero_Cuenta, Tipo_Cuenta, Saldo, Fecha_Apertura, Estado, ID_Cliente) 
                      VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ssdssi", $Numero_Cuenta, $Tipo_Cuenta, $Saldo, $Fecha_Apertura, $Estado, $ID_Cliente);
        }

        if ($stmt->execute()) {
            header("Location: acounts.php"); // Redirigir tras guardar
            exit;
        } else {
            die("Error al guardar la cuenta: " . $stmt->error);
        }
    }

    // Eliminar cuenta
    if (isset($_POST['eliminar'])) {
        $ID_Cuenta = $_POST['ID_Cuenta'];
        $query = "DELETE FROM cuenta WHERE ID_Cuenta = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param("i", $ID_Cuenta);

        if ($stmt->execute()) {
            header("Location: acounts.php"); // Redirigir tras eliminar
            exit;
        } else {
            die("Error al eliminar la cuenta: " . $stmt->error);
        }
    }
}

// Obtener datos para listar en la tabla
$query = "SELECT * FROM cuenta";
$resultado = mysqli_query($link, $query);

// Obtener datos de una cuenta para editar
$cuentaEdit = [];
if (isset($_GET['edit'])) {
    $ID_Cuenta = intval($_GET['edit']);

    if (!$ID_Cuenta) {
        die("ID de cuenta no válido.");
    }

    $query = "SELECT * FROM cuenta WHERE ID_Cuenta = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $ID_Cuenta);
    $stmt->execute();
    $result = $stmt->get_result();
    $cuentaEdit = $result->fetch_assoc();

    if (!$cuentaEdit) {
        die("No se encontró la cuenta especificada.");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Cuentas</title>
    <style>
    body {
        background-image: url('fondoLogin.png');
        background-size: cover;
        background-position: center;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .crud-container {
        background-color: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 15px;
        max-width: 900px;
        margin: 50px auto;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    h1, h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    input, select, button {
        width: 100%;
        margin: 10px 0;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
    }

    input:focus, select:focus {
        outline: none;
        border-color: #3a6ebc;
        box-shadow: 0 0 4px rgba(58, 110, 188, 0.8);
    }

    button {
        background-color: #3a6ebc;
        color: white;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #2e5b99;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
        font-size: 14px;
    }

    th {
        background-color: #3a6ebc;
        color: white;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    td a {
        color: #3a6ebc;
        text-decoration: none;
        font-weight: bold;
        margin-right: 10px;
    }

    td a:hover {
        text-decoration: underline;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    @media (max-width: 768px) {
        .crud-container {
            padding: 20px;
            width: 95%;
        }

        th, td {
            font-size: 12px;
        }

        button {
            font-size: 14px;
        }
    }
</style>


</head>
<body>
    <h1><?php echo isset($cuentaEdit['ID_Cuenta']) ? 'Editar Cuenta' : 'Crear Nueva Cuenta'; ?></h1>

    <!-- Formulario -->
<form method="POST" action="acounts.php">
    <!-- Campo oculto para ID_Cuenta, solo se llena si estamos editando -->
    <input type="hidden" name="ID_Cuenta" value="<?php echo htmlspecialchars($cuentaEdit['ID_Cuenta'] ?? ''); ?>">

    <label for="Numero_Cuenta">Número de Cuenta:</label>
    <input type="text" id="Numero_Cuenta" name="Numero_Cuenta" 
           value="<?php echo htmlspecialchars($cuentaEdit['Numero_Cuenta'] ?? ''); ?>" required>

    <label for="Tipo_Cuenta">Tipo de Cuenta:</label>
    <select id="Tipo_Cuenta" name="Tipo_Cuenta" required>
        <option value="Cuenta Corriente" <?php echo isset($cuentaEdit['Tipo_Cuenta']) && $cuentaEdit['Tipo_Cuenta'] == 'Cuenta Corriente' ? 'selected' : ''; ?>>Cuenta Corriente</option>
        <option value="Caja de Ahorro" <?php echo isset($cuentaEdit['Tipo_Cuenta']) && $cuentaEdit['Tipo_Cuenta'] == 'Caja de Ahorro' ? 'selected' : ''; ?>>Caja de Ahorro</option>
    </select>

    <label for="Saldo">Saldo:</label>
    <input type="number" step="0.01" id="Saldo" name="Saldo" 
           value="<?php echo htmlspecialchars($cuentaEdit['Saldo'] ?? ''); ?>" required>

    <label for="Fecha_Apertura">Fecha de Apertura:</label>
    <input type="date" id="Fecha_Apertura" name="Fecha_Apertura" 
           value="<?php echo htmlspecialchars($cuentaEdit['Fecha_Apertura'] ?? ''); ?>" required>

    <label for="Estado">Estado:</label>
    <select id="Estado" name="Estado" required>
        <option value="Activo" <?php echo isset($cuentaEdit['Estado']) && $cuentaEdit['Estado'] == 'Activo' ? 'selected' : 'selected'; ?>>Activo</option>
        <option value="Inactivo" <?php echo isset($cuentaEdit['Estado']) && $cuentaEdit['Estado'] == 'Inactivo' ? 'selected' : ''; ?>>Inactivo</option>
    </select>

    <label for="ID_Cliente">ID del Cliente:</label>
    <input type="number" id="ID_Cliente" name="ID_Cliente" 
           value="<?php echo htmlspecialchars($cuentaEdit['ID_Cliente'] ?? ''); ?>" required>

    <button type="submit" name="guardar">Guardar</button>
</form>


    <!-- Tabla para mostrar las cuentas -->
    <h2>Listado de Cuentas</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Número</th>
            <th>Tipo</th>
            <th>Saldo</th>
            <th>Fecha de Apertura</th>
            <th>Estado</th>
            <th>ID Cliente</th>
            <th>Acciones</th>
        </tr>
        <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td><?php echo htmlspecialchars($fila['ID_Cuenta']); ?></td>
                <td><?php echo htmlspecialchars($fila['Numero_Cuenta']); ?></td>
                <td><?php echo htmlspecialchars($fila['Tipo_Cuenta']); ?></td>
                <td><?php echo htmlspecialchars($fila['Saldo']); ?></td>
                <td><?php echo htmlspecialchars($fila['Fecha_Apertura']); ?></td>
                <td><?php echo htmlspecialchars($fila['Estado']); ?></td>
                <td><?php echo htmlspecialchars($fila['ID_Cliente']); ?></td>
                <td>
                    <a href="acounts.php?edit=<?php echo $fila['ID_Cuenta']; ?>">Editar</a>
                    <form method="POST" action="acounts.php" style="display:inline;">
                        <input type="hidden" name="ID_Cuenta" value="<?php echo $fila['ID_Cuenta']; ?>">
                        <button type="submit" name="eliminar">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
