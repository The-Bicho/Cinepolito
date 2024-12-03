<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "Cinepolito", 3308);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el ID de la película de la URL
$id_pelicula = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Consulta para obtener los detalles de la película
$query = "SELECT * FROM peliculas WHERE ID = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_pelicula);
$stmt->execute();
$resultado = $stmt->get_result();
$pelicula = $resultado->fetch_assoc();

// Si no se encuentra la película, redirigir al index
if (!$pelicula) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pelicula['Pelicula']); ?> - Detalles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .pelicula-imagen {
            max-height: 600px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }
        .detalles-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <img src="img/<?php echo htmlspecialchars($pelicula['Pelicula']); ?>.png" 
                     class="pelicula-imagen rounded" 
                     alt="<?php echo htmlspecialchars($pelicula['Pelicula']); ?>">
            </div>
            <div class="col-md-6">
                <div class="detalles-container">
                    <h1 class="mb-4"><?php echo htmlspecialchars($pelicula['Pelicula']); ?></h1>
                    
                    <div class="mb-4">
                        <h5>Sinopsis:</h5>
                        <p class="text-justify">
                            <?php echo nl2br(htmlspecialchars($pelicula['Sinopsis'])); ?>
                        </p>
                    </div>

                    <div class="mb-3">
                        <h5>Género:</h5>
                        <p><?php echo htmlspecialchars($pelicula['Genero']); ?></p>
                    </div>

                    <div class="mb-3">
                        <h5>Duración:</h5>
                        <p><?php echo htmlspecialchars($pelicula['Duracion']); ?> minutos</p>
                    </div>

                    <div class="mb-3">
                        <h5>Clasificación:</h5>
                        <p><?php echo htmlspecialchars($pelicula['Clasificacion']); ?></p>
                    </div>

                    <div class="mb-3">
                        <h5>Idioma:</h5>
                        <p><?php echo htmlspecialchars($pelicula['Idioma']); ?></p>
                    </div>

                    <!-- Botón para comprar boletos -->
                    <a href="Asientos.php?id=<?php echo $pelicula['ID']; ?>" 
                       class="btn btn-primary btn-lg">
                        Comprar Boletos
                    </a>

                    <!-- Botón para regresar -->
                    <a href="index.php" class="btn btn-secondary btn-lg ms-2">
                        Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">© 2024 Cine Ejemplo. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>