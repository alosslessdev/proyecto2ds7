<?php
// Configuración de la base de datos
$servername = "localhost"; // Generalmente 'localhost'
$username = "tu_usuario_db"; // Tu nombre de usuario de la base de datos
$password = "tu_password_db"; // Tu contraseña de la base de datos
$dbname = "tu_nombre_db"; // El nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si la solicitud es POST y si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre_completo = $_POST['nombre_completo'];
    $numero_tarjeta = $_POST['numero_tarjeta'];
    $vencimiento = $_POST['vencimiento'];
    $cvv = $_POST['cvv'];
    $metodo_pago = $_POST['metodo_pago'] ?? 'Desconocido'; // Usar operador null coalescing para valor predeterminado
    $producto_comprado = $_POST['producto_comprado'];
    $precio = $_POST['precio'];

    // Preparar y enlazar (bind) los parámetros para evitar inyecciones SQL
    $stmt = $conn->prepare("INSERT INTO ventas (nombre_completo, numero_tarjeta, vencimiento, cvv, metodo_pago, producto_comprado, precio) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssd", $nombre_completo, $numero_tarjeta, $vencimiento, $cvv, $metodo_pago, $producto_comprado, $precio);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>alert('¡Compra realizada con éxito!'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Error al procesar la compra: " . $stmt->error . "'); window.location.href='index.html';</script>";
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    // Redireccionar o mostrar un error si se intenta acceder directamente al script
    echo "<script>alert('Acceso no autorizado.'); window.location.href='index.html';</script>";
}
?>