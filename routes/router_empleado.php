<?php
switch ($action) {
  case NULL:
    require_once __DIR__ . "/../controller/empleado/CtrlPaginaPrincipal.php";
    $ctrl = new CtrlPaginaPrincipal();
    break;
}
