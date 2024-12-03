<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "Cinepolito", 3308);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener las películas
$query = "SELECT * FROM peliculas";
$result = $conexion->query($query);

// Si se encontraron películas, las asignamos a un arreglo
$peliculas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $peliculas[] = $row;
    }
}

$conexion->close();
?>

<!-- Sección Ver Películas -->
<section id="verPeliculas" class="container my-5 section-content">
    <h2 class="text-center">Películas</h2>

    <?php if (!empty($peliculas)): ?>
        <!-- Tabla de Bootstrap -->
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Película</th>
                    <th>Fecha de Estreno</th>
                    <th>Clasificación</th>
                    <th>Género</th>
                    <th>Costo del Boleto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($peliculas as $pelicula): ?>
                    <tr>
                        
                        <td><?php echo htmlspecialchars($pelicula['Pelicula']); ?></td>
                        <td><?php echo htmlspecialchars($pelicula['Estreno']); ?></td>
                        <td><?php echo htmlspecialchars($pelicula['Clasificacion']); ?></td>
                        <td><?php echo htmlspecialchars($pelicula['Genero']); ?></td>
                        <td><?php echo htmlspecialchars($pelicula['Precio']); ?> $</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se han registrado películas aún.</p>
    <?php endif; ?>
</section>