<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "cinepolito", 3308);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
// Consulta para obtener los alimentos
$sql = "SELECT nombre, precio, categoria, imagen FROM alimentos ORDER BY categoria";
$resultado = $conexion->query($sql);
// Organizar los alimentos por categoría
$alimentos = [];
while ($fila = $resultado->fetch_assoc()) {
    $alimentos[$fila['categoria']][] = $fila;
}
// Recuperar datos de sesión (asientos y total de boletos)
$asientos_seleccionados = $_SESSION['asientos'] ?? 'Ninguno';
$total_boletos = $_SESSION['total'] ?? '0.00';
// Cerrar conexión
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinepolito</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }
        header {
            background-color: #222;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .content {
            max-width: 900px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .seating {
            display: grid;
            grid-template-columns: repeat(9, 1fr);
            gap: 10px;
            justify-content: center;
            margin-bottom: 20px;
        }
        .seat {
            width: 40px;
            height: 40px;
            background-color: #ddd;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            line-height: 40px;
        }
        .seat.selected {
            background-color: #6c5ce7;
            color: white;
        }
        .seat.occupied {
            background-color: #555;
            cursor: not-allowed;
        }
        .summary, .foods, .payment-options {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .food-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .food-item input {
            width: 40px;
            text-align: center;
        }
        .button {
            display: inline-block;
            background-color: #333;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
            cursor: pointer;
        }
        footer {
            text-align: center;
            padding: 15px;
            background-color: #222;
            color: white;
        }
    </style>
</head>

<body>



<!-- Sección Alimentos -->
<section id="alimentos" class="container my-5 section-content">
    <h2 class="text-center mb-5">Alimentos</h2>

    <div class="row">
        <!-- Lista de alimentos (75% ancho) -->
        <div class="col-md-8">
            <?php foreach ($alimentos as $categoria => $items): ?>
                <h3 class="mb-4"><?= htmlspecialchars($categoria) ?></h3>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php foreach ($items as $item): ?>
                        <div class="col">
                            <div class="card h-100">
                                
                                <img src="<?= htmlspecialchars($item['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['nombre']) ?>">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?= htmlspecialchars($item['nombre']) ?></h5>
                                    <p class="card-text">$<?= number_format($item['precio'], 2) ?></p>

                                    <div class="d-flex justify-content-center align-items-center mb-3">
                                        <label class="me-2">Cantidad:</label>
                                        <input type="number" class="form-control quantity-input" min="1" max="10" style="width: 80px;">
                                    </div>
                                        <!-- Botón agregar al carrito -->
                                    <button class="btn btn-primary w-100" onclick="agregarAlCarrito('<?= htmlspecialchars($item['nombre']) ?>', <?= $item['precio'] ?>, this)">
                                        Agregar al carrito
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <hr class="my-5"> <!-- Línea separadora -->
            <?php endforeach; ?>
        </div>

            <!-- Carrito (25% ancho) -->
            <div class="col-md-4">
            <div class="card-body">
                    <!-- Información de boletos seleccionados -->
                    <h5 class="text-center">Boletos Seleccionados:</h5>
                    <p class="text-center"><strong>Asientos:</strong> <?php echo htmlspecialchars($asientos_seleccionados); ?></p>
                    <p class="text-center"><strong>Total Boletos:</strong> $<?php echo htmlspecialchars($total_boletos); ?></p>
                    <hr>
                    <!-- Carrito de alimentos -->
                    <ul id="carrito-lista" class="list-group mb-3">
                        <!-- Aquí se agregarán los ítems seleccionados -->
                    </ul>
                    <h5 class="text-center">Total Alimentos: $<span id="total-carrito">0.00</span></h5>
                    <h4 class="text-center mt-3">Total General: $<span id="total-general"><?php echo htmlspecialchars($total_boletos); ?></span></h4>
                    <button class="btn btn-success w-100 mt-3" onclick="finalizarCompra()">Finalizar Compra</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Formulario oculto para envío de datos -->
    <form id="form-finalizar" action="procesar_compra.php" method="POST">
        <input type="hidden" name="asientos" value="<?php echo htmlspecialchars($asientos_seleccionados); ?>">
        <input type="hidden" name="total_boletos" value="<?php echo htmlspecialchars($total_boletos); ?>">
        <input type="hidden" name="total_alimentos" id="input-total-alimentos">
        <input type="hidden" name="total_general" id="input-total-general">
    </form>
</section>

<!-- Script JavaScript para manejar el carrito -->
<script>
    // Variables globales para totales
let totalBoletos = parseFloat(<?php echo json_encode($total_boletos); ?>);
let totalAlimentos = 0;

// Función para agregar al carrito
function agregarAlCarrito(nombre, precio, elemento) {
    const cantidad = parseInt(elemento.previousElementSibling.querySelector('.quantity-input').value) || 1;
    const totalItem = precio * cantidad;

    // Agregar el ítem al carrito visual
    const carritoLista = document.getElementById('carrito-lista');
    const item = document.createElement('li');
    item.className = 'list-group-item d-flex justify-content-between align-items-center';
    item.innerHTML = `${nombre} (x${cantidad}) <span>$${totalItem.toFixed(2)}</span>`;
    carritoLista.appendChild(item);

    // Actualizar total de alimentos
    totalAlimentos += totalItem;
    actualizarTotalGeneral();
}

// Función para actualizar total general
function actualizarTotalGeneral() {
    document.getElementById('total-carrito').innerText = totalAlimentos.toFixed(2);
    document.getElementById('total-general').innerText = (totalBoletos + totalAlimentos).toFixed(2);
}

// Finalizar compra
function finalizarCompra() {
    // Aquí puedes enviar los datos a un backend para procesamiento
    alert('Compra finalizada. ¡Gracias por su compra!');
    // Ejemplo de redirección:
    // window.location.href = 'confirmacion.php';
}

</script>

</body>
</html>