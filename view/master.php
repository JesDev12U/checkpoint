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
</head>

<body>
  <div class="loader-container hidden" id="loader">
    <l-tail-chase
      size="40"
      speed="1.75"
      color="black"></l-tail-chase>
    <h3>Cargando, espere un momento...</h3>
  </div>
  <!-- Navbar superior -->
  <nav class="navbar navbar-expand-lg border-bottom fixed-top">
    <a href="index.php" class="navbar-brand" id="container-logo-navbar">
      <img src="img/logo2.png" alt="Logo" width="70" height="70">
      <img src="img/logo3.png" alt="Logo" width="200" height="70">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <div class="account">
        <?php
        if (isset($_SESSION) && !isset($_SESSION['email'])  && count($_SESSION) !== 0) {
          $foto_path = isset($_SESSION["datos"]["foto_path"]) && $_SESSION["datos"]["foto_path"] !== "" ? $_SESSION["datos"]["foto_path"] : "./uploads/placeholderuser.png";
          echo '<img id="foto-user-header" src="' . $foto_path . '" alt="Foto del usuario">';
          echo '<p>' . $_SESSION["datos"]["nombre"] . ' ' . $_SESSION["datos"]["appat"] . ' ' . $_SESSION["datos"]["apmat"] . '</p>';
        }
        ?>
      </div>
      <ul class="navbar-nav ms-auto">
        <?php foreach ($ctrl->opciones as $opcion): ?>
          <li class="nav-item"><a id='<?php echo $opcion['id'] ?>' class="nav-link" <?php echo 'href="' . $opcion['href'] . '"' ?>><?php echo $opcion['nombre'] ?></a></li>
        <?php endforeach ?>
      </ul>
    </div>
  </nav>
  <div id="container-principal" class="container-fluid">
    <!-- Contenido de cada controlador -->
    <?php $ctrl->renderContent(); ?>
  </div>
  <!-- Footer -->
  <footer class="py-5 border-top">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5">
        <div class="col mb-3 text-center container-redes-sociales">
          <h5>Siguenos</h5>
          <a href="#" class="me-2"><i class="fa-brands fa-facebook"></i></a>
          <a href="#" class="me-2"><i class="fa-brands fa-x-twitter"></i></a>
          <a href="#" class="me-2"><i class="fa-brands fa-instagram"></i></a>
        </div>

        <div class="col mb-3 text-center">
          <h5>Políticas de uso</h5>
          <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Aviso de privacidad</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Términos y condiciones</a></li>
          </ul>
        </div>

        <div class="col mb-3 text-center">
          <h5>Contactanos</h5>
          <ul class="nav flex-column">
            <li class="nav-item mb-2"><i class="fa-solid fa-phone"></i>&nbsp;5555555555</li>
            <li class="nav-item mb-2"><i class="fa-solid fa-phone"></i>&nbsp;5566666666</li>
          </ul>
        </div>

        <div class="col-12 col-md-4 mb-6">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1881.2732895098143!2d-99.20992246160364!3d19.431987424886835!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d2021e50a4d4db%3A0xcfaa324d96159af7!2sAv.%20Paseo%20de%20las%20Palmas%20123%2C%20Polanco%2C%20Lomas%20de%20Chapultepec%20III%20Secc%2C%20Miguel%20Hidalgo%2C%2011510%20Ciudad%20de%20M%C3%A9xico%2C%20CDMX!5e0!3m2!1ses-419!2smx!4v1733379914973!5m2!1ses-419!2smx" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
        </div>
      </div>
      <div class="container text-center">
        <hr>
        <img src="img/logo3.png" alt="Logo" width="200" height="70">
        <p>Calle Paseo de Lomas Turbas 123, Colonia Lomas de Chapultepec, Alcaldía Miguel Hidalgo, Ciudad de México, C.P. 11000, México</p>
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
    var tblDatos = new DataTable("#tblDatos", {
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