<?php
// procesar_compra.php - Recibe el carrito (array de productos) y registra cada compra en la base de datos
session_start();

// Verifica si el usuario está logueado
if (!isset($_COOKIE['logged_in']) || !isset($_COOKIE['user_id'])) {
    echo '<script>alert("Debes iniciar sesión para comprar."); window.location="login.html";</script>';
    exit;
}
$user_id = (int)$_COOKIE['user_id'];

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['carrito'])) {
    echo '<script>alert("No se recibió el carrito."); window.location="carrito.php";</script>';
    exit;
}

$carrito = json_decode($_POST['carrito'], true);
if (!$carrito || !is_array($carrito)) {
    echo '<script>alert("Carrito inválido."); window.location="carrito.php";</script>';
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "articulos";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$errores = [];
foreach ($carrito as $item) {
    $nombre = $item['nombre'];
    $stmt = $conn->prepare("SELECT id FROM articulos WHERE nombre = ?");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $stmt->bind_result($articulo_id);
    if ($stmt->fetch()) {
        $stmt->close();
        // Verifica si ya existe la compra para evitar duplicados
        $stmt_check = $conn->prepare("SELECT COUNT(*) FROM articulos_comprados WHERE articulo_id = ? AND usuario_id = ?");
        $stmt_check->bind_param("ii", $articulo_id, $user_id);
        $stmt_check->execute();
        $stmt_check->bind_result($ya_comprado);
        $stmt_check->fetch();
        $stmt_check->close();
        if ($ya_comprado == 0) {
            $stmt2 = $conn->prepare("INSERT INTO articulos_comprados (articulo_id, usuario_id) VALUES (?, ?)");
            $stmt2->bind_param("ii", $articulo_id, $user_id);
            if (!$stmt2->execute()) {
                $errores[] = "Error al registrar compra de $nombre.";
            }
            $stmt2->close();
        }
    } else {
        $errores[] = "Artículo '$nombre' no encontrado.";
        $stmt->close();
    }
}
$conn->close();

if (empty($errores)) {
    echo '<script>alert("¡Compra realizada con éxito!"); localStorage.removeItem(\'carrito\'); window.location="carrito.php";</script>';
} else {
    echo 'Ocurrieron errores:<br>' . implode('<br>', $errores);
}
?>