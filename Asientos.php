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

// Obtener el precio de la película de la base de datos
$precio_base = $pelicula['Precio'];

// Consulta para obtener los asientos ocupados
$query_asientos = "SELECT asientos FROM compras WHERE id_pelicula = ?";
$stmt_asientos = $conexion->prepare($query_asientos);
$stmt_asientos->bind_param("i", $id_pelicula);
$stmt_asientos->execute();
$resultado_asientos = $stmt_asientos->get_result();

// Crear array de asientos ocupados
$asientos_ocupados = [];
while ($row = $resultado_asientos->fetch_assoc()) {
    $asientos_fila = explode(',', $row['asientos']);
    $asientos_ocupados = array_merge($asientos_ocupados, $asientos_fila);
}
// Obtener los parámetros de la URL
$id_pelicula = $_GET['id'] ?? null;
$horario_seleccionado = $_GET['horario'] ?? null;

// Validación simple
if (!$id_pelicula || !$horario_seleccionado) {
    die("Error: Falta información de la película o el horario.");
}
// Consulta para obtener los alimentos
$sql = "SELECT nombre, precio, categoria, imagen FROM alimentos ORDER BY categoria";
$resultado = $conexion->query($sql);
// Organizar los alimentos por categoría
$alimentos = [];
while ($fila = $resultado->fetch_assoc()) {
    $alimentos[$fila['categoria']][] = $fila;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar Boletos - <?php echo htmlspecialchars($pelicula['Pelicula']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .sala-cine {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            text-align: center;
        }
        .pantalla {
            background-color: #adb5bd;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            color: white;
            font-weight: bold;
        }
        .asiento {
            width: 40px;
            height: 40px;
            margin: 4px;
            display: inline-block;
            text-align: center;
            cursor: pointer;
            position: relative;
        }
        .asiento i {
            font-size: 32px;
            line-height: 40px;
        }
        .disponible i {
            color: #198754;
        }
        .seleccionado i {
            color: #0d6efd;
        }
        .ocupado i {
            color: #dc3545;
            cursor: not-allowed;
        }
        .asiento .numero-asiento {
            position: absolute;
            font-size: 11px;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            color: white;
            z-index: 1;
        }
        .fila {
            margin-bottom: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .numero-fila {
            display: inline-block;
            width: 30px;
            text-align: right;
            margin-right: 10px;
            font-weight: bold;
        }
        .resumen-compra {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .pasillo {
            width: 60px;
            display: inline-block;
        }
        .wheelchair i {
            color: #9333ea;
        }
        .resumen-compra {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .pelicula-info {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
        }
        
        .pelicula-info img {
            width: 100%;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .pelicula-info h5 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .pelicula-info p {
            color: #6c757d;
            margin-bottom: 0.25rem;
        }
        .titulo-seleccion {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .asiento.ocupado {
            cursor: not-allowed;
        }
        .asiento.ocupado i {
            color: #dc3545;
        }
        .asiento.wheelchair {
            cursor: pointer;
        }
        .asiento.wheelchair i {
            color: #9333ea;
        }
        .asiento.wheelchair.seleccionado i {
            color: #0d6efd;
        }
        .asiento.wheelchair.ocupado i {
            color: #dc3545; /* Rojo para silla de ruedas ocupada */
        }
        
        .asiento.wheelchair.ocupado {
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container my-5">
        <div class="row">
            <div class="col-md-8">
                <h2 class="titulo-seleccion">Selección de Asientos</h2>
                
                <!-- Leyenda de asientos en horizontal -->
                <div class="d-flex justify-content-center align-items-center mb-4">
                    <div class="d-flex align-items-center me-4">
                        <div class="asiento disponible me-2">
                            <i class="fa-solid fa-couch"></i>
                        </div>
                        <span>Disponible</span>
                    </div>
                    <div class="d-flex align-items-center me-4">
                        <div class="asiento seleccionado me-2">
                            <i class="fa-solid fa-couch"></i>
                        </div>
                        <span>Seleccionado</span>
                    </div>
                    <div class="d-flex align-items-center me-4">
                        <div class="asiento ocupado me-2">
                            <i class="fa-solid fa-couch"></i>
                        </div>
                        <span>Ocupado</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="asiento wheelchair me-2">
                            <i class="fa-solid fa-wheelchair"></i>
                        </div>
                        <span>Silla de Ruedas</span>
                    </div>
                </div>
                
                <div class="sala-cine">
                    <div class="pantalla">PANTALLA</div>
                    
                    <?php
                    // Generar la sala de cine
                    $filas = 8;
                    $asientos_por_seccion = 5; // Asientos a cada lado del pasillo
                    $letras_fila = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                    
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<div class="fila">';
                        echo '<span class="numero-fila">' . $letras_fila[$i] . '</span>';
                        
                        // Primera sección de asientos
                        for ($j = 1; $j <= $asientos_por_seccion; $j++) {
                            $asiento_id = $letras_fila[$i] . $j;
                            $es_wheelchair = ($i == $filas-1 && $j == 1);
                            $esta_ocupado = in_array($asiento_id, $asientos_ocupados);
                            
                            $tipo_asiento = $es_wheelchair ? 
                                ($esta_ocupado ? 'wheelchair ocupado' : 'wheelchair') : 
                                ($esta_ocupado ? 'ocupado' : 'disponible');
                            
                            echo '<div class="asiento ' . $tipo_asiento . '" 
                                      data-fila="' . $letras_fila[$i] . '" 
                                      data-asiento="' . $j . '"
                                      onclick="seleccionarAsiento(this)">
                                    <i class="fa-solid ' . ($es_wheelchair ? 'fa-wheelchair' : 'fa-couch') . '"></i>
                                    <span class="numero-asiento">' . $j . '</span>
                                  </div>';
                        }
                        
                        // Pasillo central
                        echo '<div class="pasillo"></div>';
                        
                        // Segunda sección de asientos
                        for ($j = $asientos_por_seccion + 1; $j <= $asientos_por_seccion * 2; $j++) {
                            $asiento_id = $letras_fila[$i] . $j;
                            $es_wheelchair = ($i == $filas-1 && $j == $asientos_por_seccion * 2);
                            $esta_ocupado = in_array($asiento_id, $asientos_ocupados);
                            
                            $tipo_asiento = $es_wheelchair ? 
                                ($esta_ocupado ? 'wheelchair ocupado' : 'wheelchair') : 
                                ($esta_ocupado ? 'ocupado' : 'disponible');
                            
                            echo '<div class="asiento ' . $tipo_asiento . '" 
                                      data-fila="' . $letras_fila[$i] . '" 
                                      data-asiento="' . $j . '"
                                      onclick="seleccionarAsiento(this)">
                                    <i class="fa-solid ' . ($es_wheelchair ? 'fa-wheelchair' : 'fa-couch') . '"></i>
                                    <span class="numero-asiento">' . $j . '</span>
                                  </div>';
                        }
                        
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="resumen-compra">
                    <h3 class="mb-4">Resumen de Compra</h3>
                    
                    <!-- Información de la película -->
                    <div class="pelicula-info mb-4">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <img src="img/<?php echo htmlspecialchars($pelicula['Pelicula']); ?>.png" 
                                     class="img-fluid rounded" 
                                     alt="<?php echo htmlspecialchars($pelicula['Pelicula']); ?>">
                            </div>
                            <div class="col-8">
                                <h5 class="mb-2"><?php echo htmlspecialchars($pelicula['Pelicula']); ?></h5>
                                <p class="mb-1"><small>Clasificación: <?php echo htmlspecialchars($pelicula['Clasificacion']); ?></small></p>
                                <p class="mb-1"><small>Duración: <?php echo htmlspecialchars($pelicula['Duracion']); ?> min</small></p>
                            </div>
                        </div>
                    </div>

                    <!-- Línea divisoria -->
                    <hr class="my-3">
                    
                    <!-- Mostrar horario seleccionado -->
                    <div class="mb-3">
                        <strong>Horario Seleccionado:</strong>
                        <p><?php echo htmlspecialchars($horario_seleccionado); ?></p>
                    </div>

                    <!-- Detalles de la compra -->
                    <div class="mb-3">
                        <strong>Precio por Asiento:</strong>
                        <p>$<?php echo number_format($precio_base, 2); ?></p>
                    </div>

                    <div class="mb-3">
                        <strong>Número de Asientos:</strong>
                        <p id="numero-asientos">0</p>
                    </div>

                    <div class="mb-3">
                        <strong>Asientos Seleccionados:</strong>
                        <p id="asientos-seleccionados">Ninguno</p>
                    </div>
                    <div class="mb-3">
                        <strong>Alimentos Seleccionados:</strong>
                        <p id="asientos-seleccionados">Ninguno</p>
                    </div>
                    <div class="mb-3">
                        <strong>Total Alimentos:</strong>
                        <p id="asientos-seleccionados">Ninguno</p>
                    </div>
                    <div class="mb-3">
                        <strong>Total Asientos:</strong>
                        <p id="asientos-seleccionados">Ninguno</p>
                    </div>
                    <div class="mb-4">
                        <strong>Total a Pagar:</strong>
                        <p id="total-pagar">$0.00</p>
                    </div>
                    
                    <form id="forma-compra" action="pagos.php" method="POST">
                        <!-- Datos de la película -->
                        <input type="hidden" name="id_pelicula" value="<?php echo $id_pelicula; ?>">
                        <input type="hidden" name="nombre_pelicula" value="<?php echo htmlspecialchars($pelicula['Pelicula']); ?>">
                        <input type="hidden" name="horario" value="<?php echo htmlspecialchars($horario_seleccionado); ?>">
                        <input type="hidden" name="clasificacion" value="<?php echo htmlspecialchars($pelicula['Clasificacion']); ?>">
                        <input type="hidden" name="duracion" value="<?php echo htmlspecialchars($pelicula['Duracion']); ?>">
                        
                        <!-- Datos de los asientos -->
                        <input type="hidden" name="asientos" id="asientos-input">
                        <input type="hidden" name="numero_asientos" id="numero-asientos-input">
                        
                        <!-- Datos del pago -->
                        <input type="hidden" name="precio_unitario" value="<?php echo $precio_base; ?>">
                        <input type="hidden" name="total_pagar" id="total-pagar-input">
                        <!-- Botón redireccionar a Alimentos -->
                        <button type="submit" class="btn btn-primary btn-lg w-100" id="btn-comprar" disabled>
                            Confirmar Compra
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                                        <input type="number" class="form-control quantity-input" onchange="alerta(this,<?= number_format($item['precio'], 2) ?>)" min="1" max="10" style="width: 80px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <hr class="my-5"> <!-- Línea separadora -->
            <?php endforeach; ?>
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
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">© 2024 Cine Ejemplo. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        let asientosSeleccionados = [];
        const precioBase = <?php echo $precio_base; ?>;

        function seleccionarAsiento(elemento) {
            // Verificar si el asiento está ocupado (incluye wheelchair ocupado)
            if (elemento.classList.contains('ocupado')) {
                return;
            }
            
            const fila = elemento.dataset.fila;
            const asiento = elemento.dataset.asiento;
            const asientoId = `${fila}${asiento}`;
            
            if (elemento.classList.contains('seleccionado')) {
                elemento.classList.remove('seleccionado');
                // No necesitamos agregar 'disponible' si es wheelchair
                if (!elemento.classList.contains('wheelchair')) {
                    elemento.classList.add('disponible');
                }
                asientosSeleccionados = asientosSeleccionados.filter(a => a !== asientoId);
            } else {
                // No necesitamos quitar 'disponible' si es wheelchair
                if (!elemento.classList.contains('wheelchair')) {
                    elemento.classList.remove('disponible');
                }
                elemento.classList.add('seleccionado');
                asientosSeleccionados.push(asientoId);
            }
            
            actualizarResumen();
        }

        function actualizarResumen() {
            const asientosElement = document.getElementById('asientos-seleccionados');
            const numeroAsientosElement = document.getElementById('numero-asientos');
            const totalElement = document.getElementById('total-pagar');
            const btnComprar = document.getElementById('btn-comprar');
            
            // Actualizar campos visibles
            const numAsientos = asientosSeleccionados.length;
            const totalPagar = numAsientos * precioBase;
            
            numeroAsientosElement.textContent = numAsientos;
            
            if (numAsientos > 0) {
                asientosElement.textContent = asientosSeleccionados.join(', ');
                totalElement.textContent = `$${totalPagar.toFixed(2)}`;
                btnComprar.disabled = false;
                
                // Actualizar campos ocultos del formulario
                document.getElementById('asientos-input').value = asientosSeleccionados.join(',');
                document.getElementById('numero-asientos-input').value = numAsientos;
                document.getElementById('total-pagar-input').value = totalPagar.toFixed(2);
            } else {
                asientosElement.textContent = 'Ninguno';
                totalElement.textContent = '$0.00';
                btnComprar.disabled = true;
                
                // Limpiar campos ocultos
                document.getElementById('asientos-input').value = '';
                document.getElementById('numero-asientos-input').value = '0';
                document.getElementById('total-pagar-input').value = '0';
            }
        }
        // Actualizar total de alimentos
        function updateFoodTotal(input) {
            const price = parseFloat(input.dataset.price);
            const quantity = parseInt(input.value) || 0;
            const currentTotal = price * quantity;

            // Recalcular el total general de alimentos
            foodTotal = Array.from(document.querySelectorAll('.foods input'))
                .reduce((sum, item) => sum + (parseFloat(item.dataset.price) * (parseInt(item.value) || 0)), 0);

            document.getElementById('final-food-total').innerText = foodTotal.toFixed(2);
            updateFinalTotal();
        }

        // Actualizar total general
        function updateFinalTotal() {
            const seatsTotal = selectedSeats * seatPrice;
            const finalTotal = seatsTotal + foodTotal;
            document.getElementById('final-total').innerText = finalTotal.toFixed(2);
        }
        function alerta(objeto,numero){
alert(objeto.parent);
        
alert(numero*parseInt(objeto.value));
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>