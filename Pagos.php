<?php
// Verificar si se recibieron los datos
if (!isset($_POST['id_pelicula']) || !isset($_POST['asientos']) || !isset($_POST['total_pagar'])) {
    header("Location: index.php");
    exit();
}

// Obtener los datos enviados
$id_pelicula = $_POST['id_pelicula'];
$nombre_pelicula = $_POST['nombre_pelicula'];
$clasificacion = $_POST['clasificacion'];
$duracion = $_POST['duracion'];
$asientos = $_POST['asientos'];
$numero_asientos = $_POST['numero_asientos'];
$precio_unitario = $_POST['precio_unitario'];
$total_pagar = $_POST['total_pagar'];

// Guardar los datos en la sesión
session_start();
$_SESSION['datos_compra'] = [
    'id_pelicula' => $id_pelicula,
    'nombre_pelicula' => $nombre_pelicula,
    'clasificacion' => $clasificacion,
    'duracion' => $duracion,
    'asientos' => $asientos,
    'numero_asientos' => $numero_asientos,
    'precio_unitario' => $precio_unitario,
    'total_pagar' => $total_pagar
];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago de Boletos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container my-5">
        <div class="row">
            <!-- Columna izquierda: Datos personales y método de pago -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Datos Personales</h4>
                    </div>
                    <div class="card-body">
                        <form id="forma-pago" method="POST" action="procesar_pago.php" onsubmit="return validarFormulario()">
                            <!-- Datos personales -->
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="nombre" 
                                       name="nombre" 
                                       required 
                                       pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+" 
                                       title="Solo se permiten letras y espacios"
                                       oninvalid="this.setCustomValidity('Por favor, ingresa tu nombre')"
                                       oninput="this.setCustomValidity('')">
                                <div class="invalid-feedback">
                                    Por favor, ingresa tu nombre.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="apellido" 
                                       name="apellido" 
                                       required
                                       pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
                                       title="Solo se permiten letras y espacios"
                                       oninvalid="this.setCustomValidity('Por favor, ingresa tu apellido')"
                                       oninput="this.setCustomValidity('')">
                                <div class="invalid-feedback">
                                    Por favor, ingresa tu apellido.
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="email" class="form-label">Correo Electrónico *</label>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       required
                                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                       title="Ingresa un correo electrónico válido"
                                       oninvalid="this.setCustomValidity('Por favor, ingresa un correo electrónico válido')"
                                       oninput="this.setCustomValidity('')">
                                <div class="invalid-feedback">
                                    Por favor, ingresa un correo electrónico válido.
                                </div>
                            </div>

                            <!-- Método de pago -->
                            <h4 class="mb-3">Método de Pago *</h4>
                            <div class="mb-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="metodo_pago" 
                                           id="tarjeta" 
                                           value="tarjeta" 
                                           required
                                           checked>
                                    <label class="form-check-label" for="tarjeta">
                                        <i class="fas fa-credit-card me-2"></i>Tarjeta de Crédito/Débito
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="metodo_pago" 
                                           id="paypal" 
                                           value="paypal">
                                    <label class="form-check-label" for="paypal">
                                        <i class="fab fa-paypal me-2"></i>PayPal
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="metodo_pago" 
                                           id="efectivo" 
                                           value="efectivo">
                                    <label class="form-check-label" for="efectivo">
                                        <i class="fas fa-money-bill-wave me-2"></i>Pago en Efectivo
                                    </label>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor, selecciona un método de pago.
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mt-4">
                                Proceder al Pago
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Columna derecha: Resumen de compra -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Resumen de tu Compra</h4>
                    </div>
                    <div class="card-body">
                        <!-- Información de la película -->
                        <div class="pelicula-info mb-4">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <img src="img/<?php echo htmlspecialchars($nombre_pelicula); ?>.png" 
                                         class="img-fluid rounded" 
                                         alt="<?php echo htmlspecialchars($nombre_pelicula); ?>">
                                </div>
                                <div class="col-8">
                                    <h5 class="mb-2"><?php echo htmlspecialchars($nombre_pelicula); ?></h5>
                                    <p class="mb-1"><small>Clasificación: <?php echo htmlspecialchars($clasificacion); ?></small></p>
                                    <p class="mb-1"><small>Duración: <?php echo htmlspecialchars($duracion); ?> min</small></p>
                                </div>
                            </div>
                        </div>

                        <!-- Detalles de la compra -->
                        <div class="mb-3">
                            <strong>Asientos:</strong>
                            <p><?php echo htmlspecialchars($asientos); ?></p>
                        </div>
                        <div class="mb-3">
                            <strong>Número de Asientos:</strong>
                            <p><?php echo htmlspecialchars($numero_asientos); ?></p>
                        </div>
                        <div class="mb-3">
                            <strong>Precio por Asiento:</strong>
                            <p>$<?php echo number_format($precio_unitario, 2); ?></p>
                        </div>

                        <hr>

                        <div class="mb-0">
                            <h5 class="d-flex justify-content-between">
                                <span>Total a Pagar:</span>
                                <span>$<?php echo number_format($total_pagar, 2); ?></span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Agregar Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .card {
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
        
        .form-check-label {
            display: flex;
            align-items: center;
        }
        
        .form-check-label i {
            font-size: 1.2rem;
            margin-right: 8px;
        }
        
        .pelicula-info p {
            color: #6c757d;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }
        
        .pelicula-info h5 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .form-control:invalid,
        .form-check-input:invalid {
            border-color: #dc3545;
        }

        .form-control:invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }

        .form-label::after {
            content: " *";
            color: #dc3545;
        }
    </style>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">© 2024 Cine Ejemplo. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Activar validación de Bootstrap
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.classList.add('was-validated')
            })
    })()

    function validarFormulario() {
        const nombre = document.getElementById('nombre').value.trim();
        const apellido = document.getElementById('apellido').value.trim();
        const email = document.getElementById('email').value.trim();
        const metodoPago = document.querySelector('input[name="metodo_pago"]:checked');
        
        let isValid = true;
        let mensaje = '';

        if (!nombre) {
            mensaje += 'Por favor, ingresa tu nombre.\n';
            isValid = false;
        }

        if (!apellido) {
            mensaje += 'Por favor, ingresa tu apellido.\n';
            isValid = false;
        }

        if (!email) {
            mensaje += 'Por favor, ingresa tu correo electrónico.\n';
            isValid = false;
        } else if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            mensaje += 'Por favor, ingresa un correo electrónico válido.\n';
            isValid = false;
        }

        if (!metodoPago) {
            mensaje += 'Por favor, selecciona un método de pago.\n';
            isValid = false;
        }

        if (!isValid) {
            alert(mensaje);
            return false;
        }

        // Enviar formulario de forma asíncrona
        const formData = new FormData(document.getElementById('forma-pago'));
        
        fetch('procesar_pago.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar modal de éxito
                const modal = new bootstrap.Modal(document.getElementById('modalExito'));
                modal.show();
            } else {
                alert('Error al procesar la compra: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la compra');
        });

        return false; // Prevenir el envío normal del formulario
    }
    </script>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="modalExito" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center py-4">
                    <div class="checkmark-circle">
                        <div class="background"></div>
                        <div class="checkmark draw"></div>
                    </div>
                    <h2 class="mt-4">¡Compra Exitosa!</h2>
                    <a href="index.php" class="btn btn-primary mt-3">Continuar</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Estilos para el círculo y la palomita */
        .checkmark-circle {
            width: 100px;
            height: 100px;
            position: relative;
            display: inline-block;
            vertical-align: top;
            margin: 20px;
        }

        .checkmark-circle .background {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #28a745;
            position: absolute;
        }

        .checkmark-circle .checkmark {
            border-radius: 5px;
        }

        .checkmark-circle .checkmark.draw:after {
            content: "";
            width: 50px;
            height: 25px;
            border-right: 8px solid #fff;
            border-top: 8px solid #fff;
            position: absolute;
            left: 28px;
            top: 40px;
            transform-origin: 50% 50%;
            transform: rotate(135deg);
            animation: checkmark 0.8s ease-in-out forwards;
        }

        @keyframes checkmark {
            0% {
                opacity: 0;
                transform: rotate(135deg);
            }
            100% {
                opacity: 1;
                transform: rotate(135deg);
            }
        }

        #modalExito .modal-content {
            border: none;
            border-radius: 15px;
            padding: 20px;
        }

        #modalExito h2 {
            color: #28a745;
            font-weight: 600;
        }
    </style>
</body>
</html>