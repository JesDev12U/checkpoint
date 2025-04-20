<?php
switch ($action) {
  case NULL:
    require_once __DIR__ . "/../controller/empleado/CtrlPaginaPrincipal.php";
    $ctrl = new CtrlPaginaPrincipal();
    break;
  case rtrim(RUTA_CUENTA, "/"):
    require_once __DIR__ . "/../controller/admin/gestor_empleados/CtrlMtoEmpleados.php";
    $ctrl = new CtrlMtoEmpleados("UPDATE", $_SESSION["datos"]["id_empleado"]);
    break;
  case rtrim(RUTA_GESTOR_PRODUCTOS, "/"):
    require_once __DIR__ . "/../controller/empleado/gestor_productos/CtrlGestorProductos.php";
    $ctrl = new CtrlGestorProductos();
    break;
  case rtrim(RUTA_MTO_PRODUCTOS, '/'):
    require_once __DIR__ . "/../controller/empleado/gestor_productos/CtrlMtoProductos.php";
    if (is_null($id)) {
      $ctrl = new CtrlMtoProductos("INSERT");
    } else if ($id > 0) {
      $ctrl = new CtrlMtoProductos("UPDATE", $id);
      $registro = $ctrl->seleccionaRegistro($id);
      if (count($registro) == 0) {
        // Página no encontrada
        require_once __DIR__ . "/../controller/errors/CtrlError404.php";
        http_response_code(404);
        $ctrl = new CtrlError404();
      }
    } else {
      // Página no encontrada
      require_once __DIR__ . "/../controller/errors/CtrlError404.php";
      http_response_code(404);
      $ctrl = new CtrlError404();
    }
    break;
  default:
    // Página no encontrada
    require_once __DIR__ . "/../controller/errors/CtrlError404.php";
    http_response_code(404);
    $ctrl = new CtrlError404();
}
