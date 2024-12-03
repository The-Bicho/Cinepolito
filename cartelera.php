<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "Cinepolito", 3308);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener las películas
$query = "SELECT * FROM peliculas";
$result = $conexion->query($query);

// Guardar los resultados en un arreglo
$peliculas = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $peliculas[] = $row;
    }
}
?>
<!-- Sección Cartelera -->
<section id="cartelera" class="container my-5 section-content" style="display: block;">
    <h2 class="text-center mb-5">Cartelera</h2>
    
    <?php if (!empty($peliculas)): ?>
    <!-- Aquí se utiliza el código de Bootstrap que me proporcionaste -->
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php foreach ($peliculas as $pelicula): ?>
        <div class="col">
            <div class="card h-100">
                <!-- Mostrar la imagen de la película -->
                <img src="img/<?php echo htmlspecialchars($pelicula['Pelicula']); ?>.png" class="card-img-top card-img-small" 
                alt="<?php echo htmlspecialchars($pelicula['Pelicula']); ?>">
              
                <div class="card-body text-center">
                    <!-- Título de la película -->
                    <h5 class="card-title"><?php echo htmlspecialchars($pelicula['Pelicula']); ?></h5>
                    <!-- Botón para ver detalles -->
                    <!--<a href="#Gladiador_detalles" class="btn btn-primary" onclick="showSection('Gladiador_detalles')">Detalles</a>-->
                    <button href="Gladiador_detalles.php" class="btn btn-primary" onclick="showSection('<?php echo htmlspecialchars($pelicula['ID']); ?>')">Detalles</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <p class="text-center">No hay películas disponibles en la cartelera actualmente.</p>
    <?php endif; ?>
</section>