<?php
switch ($action) {
  case NULL:
    require_once __DIR__ . "/../controller/admin/CtrlPaginaPrincipal.php";
    $ctrl = new CtrlPaginaPrincipal();
    break;
  case rtrim(RUTA_GESTOR_EMPLEADOS, '/'):
    require_once __DIR__ . "/../controller/admin/gestor_empleados/CtrlGestorEmpleados.php";
    $ctrl = new CtrlGestorEmpleados();
    break;
  case rtrim(RUTA_MTO_EMPLEADOS, '/'):
    require_once __DIR__ . "/../controller/admin/gestor_empleados/CtrlMtoEmpleados.php";
    if (is_null($id)) {
      $ctrl = new CtrlMtoEmpleados("INSERT", null, true);
    } else if ($id > 0) {
      $ctrl = new CtrlMtoEmpleados("UPDATE", $id, true);
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
  case rtrim(RUTA_GESTOR_ADMINISTRADORES, '/'):
    require_once __DIR__ . "/../controller/admin/gestor_administradores/CtrlGestorAdministradores.php";
    $ctrl = new CtrlGestorAdministradores();
    break;
  case rtrim(RUTA_MTO_ADMINISTRADORES, '/'):
    require_once __DIR__ . "/../controller/admin/gestor_administradores/CtrlMtoAdministradores.php";
    if (is_null($id)) {
      $ctrl = new CtrlMtoAdministradores("INSERT", null, true);
    } else if ($id > 0 && $id != $_SESSION["datos"]["id_admin"]) {
      $ctrl = new CtrlMtoAdministradores("UPDATE", $id, true);
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
  case rtrim(RUTA_CUENTA, "/"):
    require_once __DIR__ . "/../controller/admin/gestor_administradores/CtrlMtoAdministradores.php";
    $ctrl = new CtrlMtoAdministradores("UPDATE", $_SESSION["datos"]["id_admin"], false);
    break;
  default:
    // Página no encontrada
    require_once __DIR__ . "/../controller/errors/CtrlError404.php";
    http_response_code(404);
    $ctrl = new CtrlError404();
}
