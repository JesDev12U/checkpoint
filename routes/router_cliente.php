<?php
switch ($action) {
  case rtrim(RUTA_CARRITO, "/"):
    require_once __DIR__ . "/../controller/cliente/carrito/CtrlCarrito.php";
    $ctrl = new CtrlCarrito();
    break;
  case rtrim(RUTA_CUENTA, "/"):
    require_once __DIR__ . "/../controller/admin/gestor_clientes/CtrlMtoClientes.php";
    $ctrl = new CtrlMtoClientes("UPDATE", $_SESSION["datos"]["id_cliente"], "cliente");
    break;
}
