<?php
switch ($action) {
  case NULL:
    require_once __DIR__ . "/../controller/admin/CtrlPaginaPrincipal.php";
    $ctrl = new CtrlPaginaPrincipal();
    break;
}
