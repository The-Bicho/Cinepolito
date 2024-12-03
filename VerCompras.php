<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "Cinepolito", 3308);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener las compras
$query = "SELECT * FROM compras";
$result = $conexion->query($query);

// Si se encontraron compras, se asignan a un arreglo
$compras = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $compras[] = $row;
    }
}

$conexion->close();
?>

<!-- Sección Ver Compras -->
<section id="verCompras" class="container my-5 section-content">
    <h2 class="text-center">Listado de Compras</h2>

    <?php if (!empty($compras)): ?>
        <!-- Tabla de Bootstrap -->
        <table class="table table-striped table-bordered table-hover table-dark">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Asientos</th>
                    <th>Número de Asientos</th>
                    <th>Total a Pagar</th>
                    <th>Método de Pago</th>
                    <th>Fecha de Compra</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($compras as $compra): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($compra['id']); ?></td>
                        <td><?php echo htmlspecialchars($compra['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($compra['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($compra['email']); ?></td>
                        <td><?php echo htmlspecialchars($compra['asientos']); ?></td>
                        <td><?php echo htmlspecialchars($compra['numero_asientos']); ?></td>
                        <td><?php echo htmlspecialchars($compra['total_pagar']); ?></td>
                        <td><?php echo ($compra['metodo_pago'] == 0) ? 'Efectivo' : 'Tarjeta'; ?></td>
                        <td><?php echo htmlspecialchars($compra['fecha_compra']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center text-white">No se han registrado compras aún.</p>
    <?php endif; ?>
</section>
