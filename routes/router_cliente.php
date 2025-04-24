<?php
switch ($action) {
  case rtrim(RUTA_CARRITO, "/"):
    require_once __DIR__ . "/../controller/cliente/carrito/CtrlCarrito.php";
    $ctrl = new CtrlCarrito();
    break;
}
