<?php

$fecha = $conexion->real_escape_string($_GET['fecha']);
$query = "SELECT asiento FROM asientos_seleccionados WHERE fecha = '$fecha' AND estado = 'ocupado'";
$result = $conexion->query($query);

$ocupados = [];
while ($row = $result->fetch_assoc()) {
    $ocupados[] = $row['asiento'];
}

echo json_encode(['ocupados' => $ocupados]);
?>
