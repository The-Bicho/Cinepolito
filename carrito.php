<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinepolito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <style>
        /* Estilo para el carrito de compras */
        #carrito {
            position: fixed;
            top: 0;
            right: -25%; /* Empieza fuera de la pantalla */
            width: 25%; /* Ancho del carrito */
            height: 100%;
            background-color: white;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.2);
            transition: right 0.3s ease; /* Transición suave */
            z-index: 9999;
            overflow-y: auto;
            padding: 20px;
        }

        #carrito.open {
            right: 0; /* Se desplaza hacia la derecha, ocupando el 25% de la pantalla */
        }

        /* Estilo del botón de cerrar en el carrito */
        #close-cart {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Estilo de la tabla dentro del carrito */
        #carrito table {
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Sección Carrito de Compras -->
    <div id="carrito">
        <span id="close-cart" class="bi bi-x-circle" style="font-size: 2rem; cursor: pointer;"></span>
        <div class="container mt-4">
            <h3 class="text-center">Carrito de Compras</h3>
            
            <!-- Tabla de Carrito -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Asiento</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody id="carrito-items">
                    <!-- Los elementos del carrito se insertarán aquí dinámicamente -->
                </tbody>
            </table>

            
            <div class="text-end">
                <h4>Total: <span id="total-carrito">$0</span></h4>
                <button class="btn btn-success" onclick="procederPago()">Proceder al Pago</button>
            </div>
        </div>
    </div>

    <script>
        
        // Función para abrir y cerrar el carrito
        let carritoAbierto = false;

        function toggleCarrito() {
            let carrito = document.getElementById('carrito');
            if (carritoAbierto) {
                carrito.classList.remove('open');
            } else {
                carrito.classList.add('open');
            }
            carritoAbierto = !carritoAbierto;
        }

        // Mostrar la sección del carrito al hacer clic en el ícono
        document.getElementById('cart-icon').addEventListener('click', toggleCarrito);

        // Cerrar el carrito al hacer clic en el botón de cierre
        document.getElementById('close-cart').addEventListener('click', toggleCarrito);

        // Función para mostrar la sección correspondiente
        function showSection(section) {
            let sections = document.querySelectorAll('.section');
            sections.forEach(s => s.style.display = 'none');
            document.getElementById(section).style.display = 'block';
        }

        // Función de ejemplo para proceder al pago
        function procederPago() {
            alert("Procediendo al pago...");
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>