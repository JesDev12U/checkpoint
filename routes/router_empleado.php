<?php
switch ($action) {
  case NULL:
    require_once __DIR__ . "/../controller/empleado/CtrlPaginaPrincipal.php";
    $ctrl = new CtrlPaginaPrincipal();
    break;
  default:
    // Página no encontrada
    require_once __DIR__ . "/../controller/errors/CtrlError404.php";
    http_response_code(404);
    $ctrl = new CtrlError404();
}
