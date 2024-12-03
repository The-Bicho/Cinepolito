<?php
session_start();

// Verificar si se recibieron los datos
if (!isset($_POST['nombre']) || 
    !isset($_POST['apellido']) || 
    !isset($_POST['email']) || 
    !isset($_POST['metodo_pago'])) {
    
    $_SESSION['error'] = "Todos los campos son obligatorios";
    header("Location: pagos.php");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "Cinepolito", 3308);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener y limpiar los datos del formulario
$nombre = $conexion->real_escape_string(trim($_POST['nombre']));
$apellido = $conexion->real_escape_string(trim($_POST['apellido']));
$email = $conexion->real_escape_string(trim($_POST['email']));
$metodo_pago = $conexion->real_escape_string($_POST['metodo_pago']);

// Obtener datos de la sesión
$datos_compra = $_SESSION['datos_compra'];
$id_pelicula = $datos_compra['id_pelicula'];
$asientos = $datos_compra['asientos'];
$numero_asientos = $datos_compra['numero_asientos'];
$total_pagar = $datos_compra['total_pagar'];

// Validar que los campos no estén vacíos
if (empty($nombre) || empty($apellido) || empty($email) || empty($metodo_pago)) {
    $_SESSION['error'] = "Todos los campos son obligatorios";
    header("Location: pagos.php");
    exit();
}

// Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "El correo electrónico no es válido";
    header("Location: pagos.php");
    exit();
}

// Verificar si los asientos siguen disponibles
$query_verificar = "SELECT asientos FROM compras WHERE id_pelicula = ?";
$stmt_verificar = $conexion->prepare($query_verificar);
$stmt_verificar->bind_param("i", $id_pelicula);
$stmt_verificar->execute();
$resultado_verificar = $stmt_verificar->get_result();

$asientos_ocupados = [];
while ($row = $resultado_verificar->fetch_assoc()) {
    $asientos_fila = explode(',', $row['asientos']);
    $asientos_ocupados = array_merge($asientos_ocupados, $asientos_fila);
}

// Verificar si algún asiento seleccionado ya está ocupado
$asientos_seleccionados = explode(',', $asientos);
$conflicto = false;
foreach ($asientos_seleccionados as $asiento) {
    if (in_array($asiento, $asientos_ocupados)) {
        $conflicto = true;
        break;
    }
}

if ($conflicto) {
    echo json_encode([
        'success' => false, 
        'error' => 'Algunos asientos ya han sido ocupados. Por favor, seleccione otros asientos.'
    ]);
    exit();
}

// Preparar la consulta SQL
$query = "INSERT INTO compras (id_pelicula, nombre, apellido, email, asientos, numero_asientos, total_pagar, metodo_pago) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($query);
$stmt->bind_param("issssisd", 
    $id_pelicula,
    $nombre,
    $apellido,
    $email,
    $asientos,
    $numero_asientos,
    $total_pagar,
    $metodo_pago
);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Éxito - Los datos se guardaron correctamente
    $_SESSION['compra_exitosa'] = true;
    
    // Limpiar los datos de la sesión que ya no necesitamos
    unset($_SESSION['datos_compra']);
    
    // Redirigir a la página de éxito o mostrar el modal
    echo json_encode(['success' => true]);
    exit();
} else {
    // Error al guardar los datos
    $_SESSION['error'] = "Error al procesar la compra: " . $conexion->error;
    echo json_encode(['success' => false, 'error' => $conexion->error]);
    exit();
}

$stmt->close();
$conexion->close();
?>