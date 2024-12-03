<?php
    $servidor = "localhost";    
    $usuario = "root";
    $clave = "";
    $baseDeDatos = "Cinepolito";

    // Intentar la conexión
    $conexion = new mysqli($servidor, $usuario, $clave, $baseDeDatos, 3308);
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
        .card-img-small {
                        display: block;
                        margin: 0 auto; /* Centrar horizontalmente */                    
                        width: 50%;
                        height: 500px;
                        object-fit: cover;
                        border-radius: 8px; /* Opcional: para esquinas redondeadas */
                        }
        
                        .week-bar {
    max-width: 700px;
    margin: 0 auto;
}

.week-day {
    display: inline-block;
    text-align: center;
    width: 14%; /* Para que haya 7 días en fila */
    font-weight: bold;
    padding-bottom: 10px;
    position: relative;
    cursor: pointer; /* Cursor en forma de mano */
}

.week-day span {
    display: block;
    font-size: 16px;
}

.week-day .date {
    font-size: 18px;
    margin-top: 5px;
}

.week-day.selected, .week-day.today {
    color: #1e88e5; /* Color azul */
}

.week-day.selected::after {
    content: "";
    display: block;
    height: 3px;
    background-color: #1e88e5;
    width: 50%;
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
}

             
    </style>
</head>
<body>
    
    <?php include 'navbar.php'; ?> <!-- Barra de navegación -->
    <?php
    include 'guardar_pelicula.php';
    include 'guardar_cliente.php';
    include 'VerPeliculas.php';
    include 'VerClientes.php';
    include 'VerCompras.php'; 
    include 'Alimentos.php';
    
    ?>
    
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
    <div id="date-bar" class="text-center mb-4" style="font-size: 18px; font-weight: bold;"></div> <!-- Fecha aquí -->
    <!-- Barra de días de la semana -->
<div class="week-bar text-center mb-4">
    <div id="week-days" class="d-flex justify-content-around"></div>
</div>
<div id="day-content" class="text-center p-3 border rounded bg-light">
    <h4 id="content-title">Contenido del día: Hoy</h4>
    <p id="content-description">Aquí se mostrará la información relacionada con el día seleccionado.</p>
</div>
    <?php if (!empty($peliculas)): ?>
    <!-- Aquí se utiliza el código de Bootstrap que me proporcionaste -->
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php foreach ($peliculas as $pelicula): ?>
        <div class="col">
            <div class="card h-100">
                <!-- Mostrar la imagen de la película -->
                <img src="img/<?php echo htmlspecialchars($pelicula['Pelicula']); ?>.png" class="card-img-top card-img-small" 
                alt="<?php echo htmlspecialchars($pelicula['Pelicula']); ?>">
                <style>.card-img-small {
                        display: block;
                        margin: 0 auto; /* Centrar horizontalmente */                    
                        width: 50%;
                        height: 500px;
                        object-fit: cover;
                        border-radius: 8px; /* Opcional: para esquinas redondeadas */
                        }
                </style>
                <div class="card-body text-center">
                    <!-- Título de la película -->
                    <h5 class="card-title"><?php echo htmlspecialchars($pelicula['Pelicula']); ?></h5>
                    <!-- Botones de horarios -->
                <?php
                // Obtener los horarios para esta película
                $id_pelicula = $pelicula['ID'];
                $horarios_query = "SELECT horario FROM horarios WHERE id_pelicula = $id_pelicula";
                $horarios_result = $conexion->query($horarios_query);
                
                if ($horarios_result && $horarios_result->num_rows > 0):
                    while ($horario = $horarios_result->fetch_assoc()):
                ?>
                    <a href="Asientos.php?id=<?php echo $id_pelicula; ?>&horario=<?php echo urlencode($horario['horario']); ?>" 
                       class="btn btn-outline-primary m-1">
                       <?php echo htmlspecialchars($horario['horario']); ?>
                    </a>
                <?php 
                    endwhile;
                else: 
                ?>
                    <p>No hay horarios disponibles</p>
                <?php endif; ?>
                    <!-- Botón para ver detalles -->
                    <a href="detalles_pelicula.php?id=<?php echo htmlspecialchars($pelicula['ID']); ?>" 
                       class="btn btn-primary">
                       Detalles
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <p class="text-center">No hay películas disponibles en la cartelera actualmente.</p>
    <?php endif; ?>
</section>
</script>


    <!-- JavaScript para mostrar secciones -->
    <script>
    function showSection(sectionId) {
    // Ocultar todas las secciones
    const sections = document.querySelectorAll('.section-content');
    sections.forEach(section => section.style.display = 'none');

    // Mostrar la sección seleccionada
    document.getElementById(sectionId).style.display = 'block';
    
    // Guardar la sección actual en localStorage
    localStorage.setItem('currentSection', sectionId);

    // Desplazar hacia la parte superior
    window.scrollTo(0, 0);
}
    /// Mostrar la última sección visitada al cargar la página
window.onload = function() {
    const lastSection = localStorage.getItem('currentSection');
    if (lastSection) {
        showSection(lastSection);
    } else {
        showSection('cartelera'); // Sección predeterminada
    }
};
function displayWeekBar() {
    const weekDaysContainer = document.getElementById('week-days');
    const today = new Date();

    for (let i = 0; i < 7; i++) {
        const currentDate = new Date();
        currentDate.setDate(today.getDate() + i);

        const dayElement = document.createElement('div');
        dayElement.classList.add('week-day');
        
        // Resaltar el día actual
        if (i === 0) {
            dayElement.classList.add('today', 'selected');
        }

        // Formatear la fecha y el día
        const dayName = i === 0 ? "Hoy" : 
                        i === 1 ? "Mañana" : 
                        currentDate.toLocaleDateString('es-ES', { weekday: 'long' });
        const dayNumber = currentDate.getDate();
        const month = currentDate.toLocaleDateString('es-ES', { month: 'short' }).toUpperCase();

        dayElement.innerHTML = `<span>${dayName}</span><span class="date">${dayNumber} ${month}</span>`;
        
        // Añadir evento de clic
        dayElement.addEventListener('click', () => selectDay(dayElement, dayName));
        
        weekDaysContainer.appendChild(dayElement);
    }
}

function selectDay(selectedDay, dayName) {
    // Remover la clase 'selected' de todos los días
    document.querySelectorAll('.week-day').forEach(day => day.classList.remove('selected'));
    selectedDay.classList.add('selected');

    // Limpiar y cargar asientos para el día seleccionado
    fetchAsientos(dayName);
}

function fetchAsientos(dayName) {
    // Formatea la fecha a 'YYYY-MM-DD' (ajusta según tus necesidades)
    const fechaSeleccionada = new Date();
    fechaSeleccionada.setDate(new Date().getDate() + getDayOffset(dayName));
    
    const formattedDate = fechaSeleccionada.toISOString().split('T')[0];

    fetch(`get_asientos.php?fecha=${formattedDate}`)
        .then(response => response.json())
        .then(data => {
            const seats = document.querySelectorAll('.seat');
            seats.forEach(seat => {
                seat.classList.remove('occupied', 'selected');
                if (data.ocupados.includes(seat.dataset.asiento)) {
                    seat.classList.add('occupied');
                }
            });
        });
}

function getDayOffset(dayName) {
    const days = {
        "Hoy": 0,
        "Mañana": 1,
        "Lunes": (1 + 7 - new Date().getDay()) % 7,
        "Martes": (2 + 7 - new Date().getDay()) % 7,
        // Agrega otros días según sea necesario
    };
    return days[dayName] || 0;
}

function updateContent(dayName) {
    const contentTitle = document.getElementById('content-title');
    const contentDescription = document.getElementById('content-description');

    // Ejemplo de contenido relacionado con el día
    const contentData = {
        "Hoy": "¡Disfruta de las mejores películas en cartelera hoy!",
        "Mañana": "Prepárate para las nuevas funciones de mañana.",
        "Lunes": "Promoción especial para estudiantes los lunes.",
        "Martes": "Descuentos en palomitas cada martes.",
        "Miércoles": "¡Miércoles de 2x1 en entradas!",
        "Jueves": "Estrenos exclusivos cada jueves.",
        "Viernes": "Inicio de fin de semana con grandes estrenos.",
        "Sábado": "Funciones familiares los sábados.",
        "Domingo": "Domingo de maratón de películas."
    };

    // Actualizar los textos
    contentTitle.textContent = `Contenido del día: ${dayName}`;
    contentDescription.textContent = contentData[dayName] || "¡Disfruta de un día en Cinepolito!";
}

// Llama a la función para mostrar la barra de días
displayWeekBar();

</script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer>
        <p>© 2024 Cine Ejemplo. Todos los derechos reservados.</p>
    </footer>
</html>