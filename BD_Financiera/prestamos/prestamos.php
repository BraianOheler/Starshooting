<?php
$prestamos = [
    ["id" => 1, "cliente" => "Juan Pérez", "monto" => 5000, "estado" => "Pendiente"],
    ["id" => 2, "cliente" => "María López", "monto" => 10000, "estado" => "Aprobado"]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Préstamos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Gestión de Préstamos</h1>
    </header>
    <main class="container">
        <h2>Lista de Préstamos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Monto</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prestamos as $prestamo): ?>
                <tr>
                    <td><?php echo $prestamo["id"]; ?></td>
                    <td><?php echo $prestamo["cliente"]; ?></td>
                    <td>$<?php echo number_format($prestamo["monto"], 2); ?></td>
                    <td><?php echo $prestamo["estado"]; ?></td>
                    <td>
                        <a href="editar_prestamo.php?id=<?php echo $prestamo["id"]; ?>">Editar</a>
                        <a href="eliminar_prestamo.php?id=<?php echo $prestamo["id"]; ?>" onclick="return confirm('¿Seguro que deseas eliminar este préstamo?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="crear_prestamo.php" class="button">Registrar Préstamo</a>
    </main>
    <footer>&copy; 2024 Sistema de Préstamos</footer>
</body>
</html>
