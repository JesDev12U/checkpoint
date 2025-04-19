<?php
ini_set('display_errors', E_ALL);
require_once __DIR__ . "/../../config/Global.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["result" => 0, "msg" => "Método no permitido"]);
  die();
}

// Recepción de los datos
$id = isset($_POST['id']) ? (int)$_POST['id'] : null;
$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;
$operacion = isset($_POST["operacion"]) ? $_POST['operacion'] : null;

if (!$id || !$usuario || !$operacion) {
  echo json_encode(["result" => 0, "msg" => "Petición incorrecta"]);
  die();
}

// Verificar si el ID existe
if ($usuario === "administrador") {
  require_once __DIR__ . "/gestor_administradores/CtrlMtoAdministradores.php";
  $ctrl = new CtrlMtoAdministradores("UPDATE", null, true);
} else if ($usuario === "empleado") {
  require_once __DIR__ . "/gestor_empleados/CtrlMtoEmpleados.php";
  $ctrl = new CtrlMtoEmpleados("UPDATE");
} else if ($usuario === "cliente") {
  require_once __DIR__ . "/gestor_clientes/CtrlMtoClientes.php";
  $ctrl = new CtrlMtoClientes("UPDATE");
} else {
  echo json_encode(["result" => 0, "msg" => "Usuario inválido"]);
  die();
}

if (count($ctrl->seleccionaRegistro($id)) === 0) {
  echo json_encode(["result" => 0, "msg" => "El ID del usuario no existe"]);
  die();
}

// Ya con todo correcto, se hace la solicitud
// TODO: Implementar a los demás usuarios
if ($usuario === "administrador") $ctrl = new CtrlMtoAdministradores("UPDATE", $id, true);
switch ($operacion) {
  case "deshabilitar":
    if ($ctrl->deshabilitarRegistro($id)) {
      echo json_encode(["result" => 1, "msg" => "Usuario deshabilitado correctamente"]);
    } else {
      echo json_encode(["result" => 0, "msg" => "ERROR: Problema para actualizar el registro en la Base de Datos"]);
    }
    break;
  case "habilitar":
    if ($ctrl->habilitarRegistro($id)) {
      echo json_encode(["result" => 1, "msg" => "Usuario habilitado correctamente"]);
    } else {
      echo json_encode(["result" => 0, "msg" => "ERROR: Problema para actualizar el registro en la Base de Datos"]);
    }
    break;
  default:
    echo json_encode(["result" => 0, "msg" => "Operación inválida"]);
    die();
}
