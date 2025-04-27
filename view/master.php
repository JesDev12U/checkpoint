<!DOCTYPE html>
<html lang="es">

<head>
  <base href="<?php echo SITE_URL ?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo "Checkpoint | " . $ctrl->title ?></title>
  <link rel="icon" href="img/logo2.png">
  <!-- Bootstrap CSS -->
  <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- DataTables Core CSS -->
  <link href="node_modules/datatables.net-dt/css/dataTables.dataTables.min.css" rel="stylesheet" type="text/css">
  <!-- DataTables Bootstrap CSS -->
  <link rel="stylesheet" href="node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css" type="text/css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css" />
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css" />
  <!-- CSS principal -->
  <link rel="stylesheet" href="css/master.css" />
  <!-- CSS de cada menú de los usuarios (empleados y administradores) -->
  <link rel="stylesheet" href="css/menu.css">
  <!-- CSS de cada controlador -->
  <style>
    <?php $ctrl->renderCSS() ?>
  </style>
  <!-- SDK de Mercado Pago -->
  <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>

<body>
  <div class="loader-container hidden" id="loader">
    <l-tail-chase
      size="40"
      speed="1.75"
      color="black"></l-tail-chase>
    <h3>Cargando, espere un momento...</h3>
  </div>
  <?php if (!isset($_COOKIE['cookie_consent'])): ?>
    <div id="cookie-consent-banner" style="position:fixed;bottom:0;left:0;right:0;background:#222;color:#fff;padding:16px;z-index:9999;text-align:center;">
      Este sitio utiliza cookies para mejorar su experiencia.
      <button id="accept-cookies" style="margin-left:10px;">Aceptar</button>
      <button id="reject-cookies" style="margin-left:10px;">Rechazar</button>
    </div>
    <script>
      document.getElementById('accept-cookies').onclick = function() {
        document.cookie = "cookie_consent=1; path=/; max-age=" + (60 * 60 * 24 * 365);
        document.getElementById('cookie-consent-banner').style.display = 'none';
      };
      document.getElementById('reject-cookies').onclick = function() {
        document.cookie = "cookie_consent=0; path=/; max-age=" + (60 * 60 * 24 * 365);
        document.getElementById('cookie-consent-banner').style.display = 'none';
      };
    </script>
  <?php endif; ?>
  <!-- Navbar superior mejorado -->
  <nav class="navbar navbar-expand-lg shadow-sm fixed-top py-0 sticky-top">
    <div class="container-fluid">
      <!-- Logo y nombre -->
      <a href="index.php" class="navbar-brand d-flex align-items-center gap-2" id="container-logo-navbar">
        <img src="img/logo2.png" alt="Logo" width="50" height="50" class="d-inline-block align-middle">
        <img src="img/logo3.png" alt="Checkpoint" width="150" height="50" class="d-none d-md-inline-block align-middle">
      </a>
      <!-- Botón hamburguesa -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Contenido colapsable -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Opciones de navegación -->
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
          <?php if (is_array($ctrl->opciones) && count($ctrl->opciones) > 0): ?>
            <?php foreach ($ctrl->opciones as $opcion): ?>
              <?php
              $sesionIniciada = isset($_SESSION) && count($_SESSION) !== 0;
              // Mostrar todas las opciones excepto "login" si hay sesión iniciada
              // Mostrar solo "login" si NO hay sesión iniciada
              if (($sesionIniciada && $opcion['id'] !== "login") ||
                (!$sesionIniciada && $opcion['id'] === "login")
              ):
              ?>
                <li class="nav-item">
                  <a id='<?php echo $opcion['id'] ?>' class="nav-link px-3" <?php echo 'href="' . $opcion['href'] . '"' ?>>
                    <?php echo $opcion['nombre'] ?>
                  </a>
                </li>
              <?php endif ?>
            <?php endforeach ?>
          <?php endif ?>
        </ul>
        <!-- Usuario -->
        <div class="d-flex align-items-center ms-lg-4 mt-3 mt-lg-0">
          <?php
          if (isset($_SESSION) && (!isset($_SESSION['codigo']) && !isset($_SESSION['email'])) && count($_SESSION) !== 0) {
            $foto_path = isset($_SESSION["datos"]["foto_path"]) && $_SESSION["datos"]["foto_path"] !== "" ? $_SESSION["datos"]["foto_path"] : "./uploads/placeholderuser.png";
          ?>
            <img id="foto-user-header" src="<?php echo $foto_path; ?>" alt="Foto del usuario"
              class="rounded-circle border border-2" width="40" height="40" style="object-fit:cover;">
            <div class="account ms-2 d-none d-md-block">
              <p class="fw-semibold"><?php echo $_SESSION["datos"]["nombre"] . ' ' . $_SESSION["datos"]["appat"] . ' ' . $_SESSION["datos"]["apmat"]; ?></p>
            </div>
            <!-- Botón de logout (opcional) -->
            <form action="<?php echo RUTA_CERRAR_SESION ?>" method="post" class="ms-3 mb-0 d-inline">
              <button type="submit" class="btn btn-outline-danger btn-sm" title="Cerrar sesión">
                <i class="fa-solid fa-right-from-bracket"></i>
              </button>
            </form>
          <?php } ?>
        </div>
      </div>
    </div>
  </nav>
  <div id="container-principal" class="container-fluid">
    <!-- Contenido de cada controlador -->
    <?php $ctrl->renderContent(); ?>
  </div>

  <!-- Footer mejorado estilo Minecraft -->
  <footer class="py-5 border-top mt-5">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-4">
        <div class="col mb-3 text-center container-redes-sociales">
          <h5>¡Síguenos!</h5>
          <a href="#" title="Facebook"><i class="fa-brands fa-facebook"></i></a>
          <a href="#" title="X (Twitter)"><i class="fa-brands fa-x-twitter"></i></a>
          <a href="#" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
        </div>

        <div class="col mb-3 text-center">
          <h5>Políticas de uso</h5>
          <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0">Aviso de privacidad</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0">Términos y condiciones</a></li>
          </ul>
        </div>

        <div class="col mb-3 text-center">
          <h5>Contáctanos</h5>
          <ul class="nav flex-column">
            <li class="nav-item mb-2"><i class="fa-solid fa-phone"></i>&nbsp;5555-555555</li>
            <li class="nav-item mb-2"><i class="fa-solid fa-phone"></i>&nbsp;5566-666666</li>
            <li class="nav-item mb-2"><i class="fa-solid fa-envelope"></i>&nbsp;soporte@checkpoint.mx</li>
          </ul>
        </div>

        <div class="col-12 col-md-4 mb-3 text-center">
          <h5>¡Visítanos!</h5>
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1881.2732895098143!2d-99.20992246160364!3d19.431987424886835!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d2021e50a4d4db%3A0xcfaa324d96159af7!2sAv.%20Paseo%20de%20las%20Palmas%20123%2C%20Polanco%2C%20Lomas%20de%20Chapultepec%20III%20Secc%2C%20Miguel%20Hidalgo%2C%2011510%20Ciudad%20de%20M%C3%A9xico%2C%20CDMX!5e0!3m2!1ses-419!2smx!4v1733379914973!5m2!1ses-419!2smx" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
        </div>
      </div>
      <div class="container text-center mt-4">
        <hr>
        <img src="img/logo3.png" alt="Logo" width="200" height="70">
        <p class="mt-2 mb-0">
          Calle Paseo de Lomas Turbas 123, Colonia Lomas de Chapultepec, Alcaldía Miguel Hidalgo, Ciudad de México, C.P. 11000, México
        </p>
        <div class="copyright mt-2">
          &copy; <?php echo date('Y'); ?> Checkpoint - Tu tienda de videojuegos con espíritu Minecraft.
        </div>
      </div>
    </div>
  </footer>

  <!-- jQuery -->
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables Core JS -->
  <script src="node_modules/datatables.net/js/dataTables.min.js"></script>
  <!-- DataTables Buttons JS -->
  <script src="node_modules/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <!-- DataTables Buttons HTML5 JS -->
  <script src="node_modules/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <!-- DataTables Buttons Print JS -->
  <script src="node_modules/datatables.net-buttons/js/buttons.print.min.js"></script>
  <!-- DataTables Bootstrap JS -->
  <script src="node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
  <!-- SweetAlert JS -->
  <script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
  <!-- Fontawesome JS -->
  <script src="node_modules/@fortawesome/fontawesome-free/js/all.min.js"></script>
  <!-- LDRS UiBall JS -->
  <script type="module" src="node_modules/ldrs/dist/auto/tailChase.js"></script>
  <!-- Validator JS -->
  <script src="node_modules/validator/validator.min.js"></script>
  <!-- JS del master -->
  <script src="js/master.js"></script>
  <!-- Validaciones -->
  <script src="js/validaciones.js"></script>
  <!-- Confirmación de procesos -->
  <script src="js/confirmacionProcesos.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      verificarIndex(`<?php echo SITE_URL ?>`);
      sesion(
        `<?php echo json_encode(["sesion" => $_SESSION]) ?>`,
        `<?php echo SITE_URL ?>`
      );
      return;
    });
  </script>
  <!-- JS para DataTable -->
  <script>
    var tblDatos = new DataTable(".tblDatos", {
      scrollY: 400,
      scrollX: true,
      scrollCollapse: true,
      paging: false,
      autoFill: true,
      language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
        }
      },
      responsive: true,
    });
  </script>
  <!-- JS del controlador -->
  <script>
    <?php $ctrl->renderJS() ?>
  </script>
</body>

</html>