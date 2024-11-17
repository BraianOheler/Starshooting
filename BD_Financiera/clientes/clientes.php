<?php
$clientes = [
    ["id" => 1, "nombre" => "Juan Pérez", "email" => "juan@example.com"],
    ["id" => 2, "nombre" => "María López", "email" => "maria@example.com"],
    ["id" => 3, "nombre" => "Carlos Ramírez", "email" => "carlos@example.com"]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Gestión de Clientes</h1>
    </header>
    <main class="container">
        <h2>Lista de Clientes</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?php echo $cliente["id"]; ?></td>
                    <td><?php echo $cliente["nombre"]; ?></td>
                    <td><?php echo $cliente["email"]; ?></td>
                    <td>
                        <a href="editar_cliente.php?id=<?php echo $cliente["id"]; ?>">Editar</a>
                        <a href="eliminar_cliente.php?id=<?php echo $cliente["id"]; ?>" onclick="return confirm('¿Seguro que deseas eliminar este cliente?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="crear_cliente.php" class="button">Agregar Cliente</a>
    </main>
    <footer>&copy; 2024 Sistema de Préstamos</footer>
</body>
</html>
