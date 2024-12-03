<?php
$conexion = new mysqli("localhost", "root", "", "Cinepolito", 3308);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pelicula = $_POST['nombrePelicula'];
    $fecha = $_POST['fechaEstreno'];
    $clasificacion = $_POST['clasificacion'];
    $genero = $_POST['genero'];
    $precio = $_POST['costoBoleto'];  // Asegúrate de usar 'costoBoleto' que es el nombre en tu formulario

    // Consulta preparada para insertar los datos
    $stmt = $conexion->prepare("INSERT INTO peliculas (Pelicula, estreno, clasificacion, genero, precio) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $pelicula, $fecha, $clasificacion, $genero, $precio);

    if ($stmt->execute()) {
        echo "Película registrada con éxito.";
    } else {
        echo "Error al registrar la película.";
    }
    $stmt->close();
}
$conexion->close();
?>

<!-- Sección Agregar Películas -->
<section id="agregarPeliculas" class="container my-5 section-content">
    <h2>Agregar Películas</h2>
    <form action="guardar_pelicula.php" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="nombrePelicula" class="form-label">Película</label>
            <input type="text" name="nombrePelicula" id="nombrePelicula" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="fechaEstreno" class="form-label">Fecha de Estreno</label>
            <input type="date" name="fechaEstreno" id="fechaEstreno" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="clasificacion" class="form-label">Clasificación</label>
            <select name="clasificacion" id="clasificacion" class="form-select" required>
                <option value="">Selecciona una clasificación</option>
                <option value="A">A - Para todo público</option>
                <option value="B">B - Supervisión de padres</option>
                <option value="B-12">PG-12 - Mayores de 12 años</option>
                <option value="B-15">B-15 - Mayores de 15 años</option>
                <option value="C">C - Solo adultos</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="genero" class="form-label">Género</label>
            <select name="genero" id="genero" class="form-select" required>
                <option value="Comedia">Comedia</option>
                <option value="Drama">Drama</option>
                <option value="Terror">Terror</option>
                <option value="Romance">Romance</option>
                <option value="Aventura">Aventura</option>
                <option value="Acción">Acción</option>
                <option value="Fantasía">Fantasía</option>
                <option value="Musicales">Animada</option>
                <option value="Misterio">Misterio</option>
                <option value="Ciencia ficción">Ciencia ficción</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="costoBoleto" class="form-label">Costo del Boleto</label>
            <input type="number" name="costoBoleto" id="costoBoleto" class="form-control" step="0.01" min="0" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Película</button>
        <button type="reset" class="btn btn-primary">Borrar</button>
    </form>
</section>