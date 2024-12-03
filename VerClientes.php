<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "Cinepolito", 3308);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener los clientes
$query = "SELECT * FROM cliente";
$result = $conexion->query($query);

// Si se encontraron clientes, los asignamos a un arreglo
$clientes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
}

$conexion->close();
?>
<!-- Sección Ver Clientes -->
<section id="verClientes" class="container my-5 section-content">
    <h2 class="text-center">Clientes</h2>

    <?php if (!empty($clientes)): ?>
        <!-- Tabla de Bootstrap -->
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Correo Electrónico</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cliente['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['Apellido']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['Correo']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['Telefono']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se han registrado clientes aún.</p>
    <?php endif; ?>
</section>