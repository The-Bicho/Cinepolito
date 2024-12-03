<?php
$conexion = new mysqli("localhost", "root", "", "Cinepolito", 3308);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombreCliente'];
    $apellidos = $_POST['apellidosCliente'];
    $email = $_POST['emailCliente'];
    $telefono = $_POST['telefonoCliente'];

    $stmt = $conexion->prepare("INSERT INTO cliente (nombre, apellido, correo, telefono) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $apellidos, $email, $telefono);

    if ($stmt->execute()) {
        echo "Cliente registrado con éxito.";
    } else {
        echo "Error al registrar el cliente.";
    }
    $stmt->close();
}
$conexion->close();
?>

<section id="agregarClientes" class="container my-5 section-content">
    <h2>Agregar Clientes</h2>
    <form action="guardar_cliente.php" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="nombreCliente" class="form-label">Nombre</label>
            <input type="text" name="nombreCliente" id="nombreCliente" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="apellidosCliente" class="form-label">Apellidos</label>
            <input type="text" name="apellidosCliente" id="apellidosCliente" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="emailCliente" class="form-label">Correo Electrónico</label>
            <input type="email" name="emailCliente" id="emailCliente" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="telefonoCliente" class="form-label">Teléfono</label>
            <input type="tel" name="telefonoCliente" id="telefonoCliente" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Cliente</button>
        <button type="reset" class="btn btn-primary">Borrar</button>
    </form>
</section>