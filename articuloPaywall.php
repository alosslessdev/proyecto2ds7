<?php
// articulo.php

// Configuración de la base de datos
$servername = "localhost";
$username = "tu_usuario_db"; // ¡Cambia esto!
$password = "tu_password_db"; // ¡Cambia esto!
$dbname = "tu_nombre_db"; // ¡Cambia esto!

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// ID del artículo que se está viendo en esta página
// Puedes hacer que este ID sea dinámico (ej. de la URL ?id=X)
// Por ahora, lo fijamos al ID del artículo que insertamos de prueba
$current_article_id = 1; // Asumiendo que 'Entrevista exclusiva con Yuji Naka' tiene ID 1

$is_logged_in = false;
$has_purchased = false;
$user_id = null;
$article_content = ""; // Variable para almacenar el contenido a mostrar

// 1. Verificar si el usuario está logueado (usando cookies)
if (isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] === 'true' && isset($_COOKIE['user_id'])) {
    $is_logged_in = true;
    $user_id = (int)$_COOKIE['user_id']; // Convertir a entero para seguridad
}

// 2. Si el usuario está logueado, verificar si ha comprado el artículo
if ($is_logged_in) {
    $stmt_check_purchase = $conn->prepare("SELECT COUNT(*) FROM articulos_comprados WHERE usuario_id = ? AND articulo_id = ?");
    $stmt_check_purchase->bind_param("ii", $user_id, $current_article_id);
    $stmt_check_purchase->execute();
    $stmt_check_purchase->bind_result($purchase_count);
    $stmt_check_purchase->fetch();
    $stmt_check_purchase->close();

    if ($purchase_count > 0) {
        $has_purchased = true;
    }
}

// 3. Obtener el contenido del artículo de la base de datos
$stmt_get_content = $conn->prepare("SELECT contenido_gratis, contenido_premium FROM articulos WHERE id = ?");
$stmt_get_content->bind_param("i", $current_article_id);
$stmt_get_content->execute();
$stmt_get_content->bind_result($contenido_gratis, $contenido_premium);
$stmt_get_content->fetch();
$stmt_get_content->close();

// Decidir qué contenido mostrar
if ($has_purchased) {
    $article_content = $contenido_premium;
} else {
    $article_content = $contenido_gratis;
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Creative - Start Bootstrap Theme</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap Icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <!-- SimpleLightbox plugin CSS-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
       <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.html#page-top">
                <img src="assets/favicon.ico" style="height: 30px; margin-right: 10px;" />
                Gaming Noticia
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" 
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.html#noticiasrelevantes">Noticias</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.html#portfolio">Reviews</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.html#juego">Juegos</a></li>
                <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

        <!-- Masthead-->
        <header class="masthead", style="background: linear-gradient(to bottom, rgba(92, 77, 66, 0.8) 0%, rgba(92, 77, 66, 0.8) 100%), url(assets/img/portfolio/thumbnails/MV5BNWNhZDUwZjgtYTg0YS00MzQ2LWFkYzItMzI0ZDEyZWE5MTk2XkEyXkFqcGc@._V1_.jpg); 
        background-repeat: no-repeat; background-size: cover;">               
            

            <div class="row gx-4 gx-lg-5 h-100 align-items-center text-center">
                <div class="col-lg-6">
                    <h1 class="text-white font-weight-bold">Entrevista exclusiva con Yuji Naka</h1>
                    <hr class="divider" />
                    <p class="text-white-75 mb-5">Naka es un experimentado desarrollador de videojuegos japonés detras de la franquicia de Sonic The HedgeHog.</p>

                       
                </div>

                    <div class="col-lg-6" style="padding-left: 5%;">
                            <img src="assets/img/portfolio/thumbnails/MV5BNWNhZDUwZjgtYTg0YS00MzQ2LWFkYzItMzI0ZDEyZWE5MTk2XkEyXkFqcGc@._V1_.jpg" width="100%" class="img-fluid">
                    </div>

                   

            </div>

                

        </header>
        <!-- About-->
        
        <!-- Services-->
        <section class="page-section" id="services">
            <div class="container px-4 px-lg-5">
                <h2 class="text-center mt-0">

Este articulo se puede acceder con una suscripción,
O puedes comprar el artículo y accederlo cuando quieras, pagando 2 dólares una sola vez.<br>
<brñ>
 Entra ahora para acceder al articulo.<br>
<br>
<a class="btn btn-primary btn-xl" href="login.html">Entrar</a>

</h2>

                <hr class="divider" />
                
            </div>
        </section>

        <!-- Footer-->
        <footer class="bg-light py-5">
            <div class="container px-4 px-lg-5"><div class="small text-center text-muted">Copyright &copy; 2023 - Gaming Noticia</div></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- SimpleLightbox plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
