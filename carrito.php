<?php
// carrito.php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "articulos";
$is_logged_in = false;
$user_id = null;
if (isset($_COOKIE['logged_in']) && isset($_COOKIE['user_id'])) {
    $is_logged_in = true;
    $user_id = (int)$_COOKIE['user_id'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Carrito de Compras</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <link href="css/styles (1).css" rel="stylesheet" />
  <style>
    html, body { height: 100%; }
    body { padding-top: 80px; display: flex; flex-direction: column; }
    main { flex: 1; }
    .btn-orange { background-color: #f4623a; color: black; }
    .btn-orange:hover { background-color: #d94f27; color: black; }
    .card-custom { border-left: 5px solid #f4623a; }
    .navbar-light .navbar-nav .nav-link { color: black !important; }
  </style>
</head>
<body id="page-top">
  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
    <div class="container px-4 px-lg-5">
      <a class="navbar-brand" href="index.html">
        <img src="assets/favicon.ico" style="height: 30px; margin-right: 10px;" />
        Gaming Noticia
      </a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto my-2 my-lg-0">
          <li class="nav-item"><a class="nav-link" href="index.html#noticiasrelevantes">Noticias</a></li>
          <li class="nav-item"><a class="nav-link" href="index.html#articulos">Artículos</a></li>
          <li class="nav-item"><a class="nav-link" href="index.html#juego">Juegos</a></li>
          <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="carrito.php">Carrito <img src="assets/img/carrito.png" style="width: 20px; height: 20px; margin-left: 5px;" /></a></li>
        </ul>
      </div>
    </div>
  </nav>
  <main>
    <section class="container mt-5">
      <h2 class="mb-4 text-center">🛒 Tu Carrito de Compras</h2>
      <div id="lista-carrito" class="mb-4"></div>
      <!-- Formulario de pago con tarjeta de crédito (simulación) -->
      <form id="form-tarjeta" class="mb-4" autocomplete="off" onsubmit="return validarTarjeta();">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="nombre-tarjeta" class="form-label">Nombre del titular</label>
            <input type="text" class="form-control" id="nombre-tarjeta" required maxlength="50">
          </div>
          <div class="col-md-6">
            <label for="numero-tarjeta" class="form-label">Número de tarjeta</label>
            <input type="text" class="form-control" id="numero-tarjeta" required maxlength="20">
          </div>
          <div class="col-md-4">
            <label for="expiracion" class="form-label">Expiración (MM/AA)</label>
            <input type="text" class="form-control" id="expiracion" required maxlength="5" placeholder="MM/AA" pattern="\d{2}/\d{2}">
          </div>
          <div class="col-md-4">
            <label for="cvv" class="form-label">CVV</label>
            <input type="text" class="form-control" id="cvv" required maxlength="3" pattern="\d{3}" inputmode="numeric">
          </div>
        </div>
        <div id="error-tarjeta" class="text-danger mt-2" style="display:none;"></div>
        <button type="submit" class="btn btn-success mt-3">Validar Tarjeta</button>
      </form>
      <div class="d-flex justify-content-between align-items-center">
        <h4 id="total">Total: $0.00</h4>
        <form id="form-pago" method="POST" action="procesar_compra.php">
          <input type="hidden" name="carrito" id="input-carrito" />
          <button type="button" class="btn btn-orange" id="btn-pagar-todo" onclick="pagarTodo()" disabled>Pagar Todo</button>
        </form>
      </div>
      <?php if ($is_logged_in): ?>
      <div class="mt-5">
        <h3>Artículos que has comprado:</h3>
        <ul class="list-group">
        <?php
        $conn2 = new mysqli($servername, $username, $password, $dbname);
        if (!$conn2->connect_error) {
            $stmt = $conn2->prepare("CALL ObtenerArticulosCompradosPorUsuario(?)");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $has_any = false;
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $has_any = true;
                    echo '<li class="list-group-item"><a href="articuloPaywall.php?id=' . $row['id'] . '">' . htmlspecialchars($row['nombre']) . '</a></li>';
                }
            }
            if (!$has_any) {
                echo '<li class="list-group-item">No has comprado ningún artículo aún.</li>';
            }
            $stmt->close();
            $conn2->close();
        } else {
            echo '<li class="list-group-item">No se pudo obtener la lista de artículos comprados.</li>';
        }
        ?>
        </ul>
      </div>
      <?php endif; ?>
    </section>
  </main>
  <footer class="bg-light py-5">
    <div class="container px-4 px-lg-5">
      <div class="small text-center text-muted">© 2025 Gaming Noticia. Todos los derechos reservados.</div>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
  <script src="js/scripts.js"></script>
  <script>
    function mostrarCarrito() {
      const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
      const lista = document.getElementById('lista-carrito');
      lista.innerHTML = '';
      if (carrito.length === 0) {
        lista.innerHTML = '<div class="alert alert-info">No hay productos en el carrito.</div>';
        document.getElementById('total').innerText = 'Total: $0.00';
        return;
      }
      let total = 0;
      carrito.forEach((item, index) => {
        total += item.precio;
        lista.innerHTML += `
          <div class="card card-custom mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">
              <div><strong>${item.nombre}</strong> - $${item.precio.toFixed(2)}</div>
              <button class="btn btn-sm btn-danger" onclick="eliminarProducto(${index})"><i class="bi bi-trash"></i> Eliminar</button>
            </div>
          </div>
        `;
      });
      document.getElementById('total').innerText = 'Total: $' + total.toFixed(2);
    }
    function eliminarProducto(index) {
      let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
      carrito.splice(index, 1);
      localStorage.setItem('carrito', JSON.stringify(carrito));
      mostrarCarrito();
    }
    function pagarTodo() {
      const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
      if (carrito.length === 0) {
        alert('No hay productos en el carrito.');
        return;
      }
      if (confirm("¿Confirmas el pago de todos los productos?")) {
        document.getElementById('input-carrito').value = JSON.stringify(carrito);
        document.getElementById('form-pago').submit();
      }
    }
    // Validación de tarjeta de crédito (simulación)
    function validarTarjeta() {
      const nombre = document.getElementById('nombre-tarjeta').value.trim();
      const numero = document.getElementById('numero-tarjeta').value.trim();
      const expiracion = document.getElementById('expiracion').value.trim();
      const cvv = document.getElementById('cvv').value.trim();
      const errorDiv = document.getElementById('error-tarjeta');
      errorDiv.style.display = 'none';
      // Validaciones básicas
      if (nombre.length < 3) {
        errorDiv.textContent = 'El nombre del titular es demasiado corto.';
        errorDiv.style.display = 'block';
        return false;
      }
      if (!/^\d{13,19}$/.test(numero.replace(/\s+/g, ''))) {
        errorDiv.textContent = 'El número de tarjeta debe tener entre 13 y 19 dígitos (puedes usar espacios).';
        errorDiv.style.display = 'block';
        return false;
      }
      if (!/^\d{2}\/\d{2}$/.test(expiracion)) {
        errorDiv.textContent = 'La expiración debe tener el formato MM/AA.';
        errorDiv.style.display = 'block';
        return false;
      }
      // Validar mes y año
      const [mes, anio] = expiracion.split('/').map(Number);
      if (mes < 1 || mes > 12) {
        errorDiv.textContent = 'El mes de expiración no es válido.';
        errorDiv.style.display = 'block';
        return false;
      }
      // Validar que la fecha no sea pasada
      const hoy = new Date();
      const fechaExp = new Date(2000 + anio, mes - 1);
      if (fechaExp < new Date(hoy.getFullYear(), hoy.getMonth())) {
        errorDiv.textContent = 'La tarjeta está expirada.';
        errorDiv.style.display = 'block';
        return false;
      }
      if (!/^\d{3}$/.test(cvv)) {
        errorDiv.textContent = 'El CVV debe tener 3 dígitos.';
        errorDiv.style.display = 'block';
        return false;
      }
      // Si todo es válido, habilitar el botón de pago
      document.getElementById('btn-pagar-todo').disabled = false;
      errorDiv.textContent = '¡Tarjeta válida! Puedes proceder al pago.';
      errorDiv.classList.remove('text-danger');
      errorDiv.classList.add('text-success');
      errorDiv.style.display = 'block';
      return false; // No envía el form, solo valida
    }
    mostrarCarrito();
  </script>
</body>
</html>
