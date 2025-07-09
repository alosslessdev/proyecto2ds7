<?php
// login_handler.php

// Configuración de la base de datos
$servername = "localhost";
$username = "tu_usuario_db"; // ¡Cambia esto!
$password = "tu_password_db"; // ¡Cambia esto!
$dbname = "tu_nombre_db"; // ¡Cambia esto!

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_input_username = trim($_POST['email'] ?? '');
    $user_input_password = trim($_POST['password'] ?? '');

    if (empty($user_input_username) || empty($user_input_password)) {
        echo "<script>alert('Por favor, ingrese nombre de usuario y contraseña.'); window.location.href='login.html';</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT id, nombre_usuario, password_hash FROM usuarios WHERE nombre_usuario = ?");
    $stmt->bind_param("s", $user_input_username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $db_username, $db_password_hash);
        $stmt->fetch();

        if (password_verify($user_input_password, $db_password_hash)) {
            // Contraseña correcta, establecer cookies
            // La cookie de sesión (o una similar) para indicar que está logueado
            setcookie("logged_in", "true", time() + (86400 * 30), "/"); // 30 días
            setcookie("user_id", $user_id, time() + (86400 * 30), "/"); // 30 días

            echo "<script>alert('¡Inicio de sesión exitoso!'); window.location.href='articulo.php';</script>";
        } else {
            echo "<script>alert('Nombre de usuario o contraseña incorrectos.'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('Nombre de usuario o contraseña incorrectos.'); window.location.href='login.html';</script>";
    }

    $stmt->close();
} else {
    header("Location: login.html");
    exit;
}
$conn->close();
?>