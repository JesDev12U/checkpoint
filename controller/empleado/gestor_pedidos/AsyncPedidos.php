<?php
ini_set('display_errors', E_ALL);
session_start();
require_once __DIR__ . "/CtrlGestorPedidos.php";

// Recibe datos JSON desde el cliente
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!isset($_SESSION) || count($_SESSION) === 0) {
  echo json_encode(["result" => 0, "msg" => "No haz iniciado sesión"]);
  die();
}

if (!isset($data["id_pedido"]) && !isset($data["operacion"])) {
  echo json_encode(["result" => 0, "msg" => "Petición inválida"]);
  die();
}

switch ($data["operacion"]) {
  case "tomar_pedido":
    $ctrl = new CtrlGestorPedidos();
    if (!$ctrl->tomarPedido(($data['id_pedido']))) {
      echo json_encode(["result" => 0, "msg" => "Error para tomar el pedido"]);
    } else {
      echo json_encode(["result" => 1, "msg" => "¡Pedido tomado con éxito"]);
    }
    break;
  case "actualizar_estado":
    $ctrl = new CtrlGestorPedidos();
    if (!isset($data['estado'])) {
      echo json_encode(["result" => 0, "msg" => "No mandaste ningún estado"]);
    } else if (
      $data['estado'] !== "Pedido recién atendido"
      && $data['estado'] !== "Procesando y empaquetando"
      && $data['estado'] !== "En camino"
      && $data['estado'] !== "Completado"
    ) {
      echo json_encode(["result" => 0, "msg" => "Estado inválido"]);
    } else if (!$ctrl->actualizarEstadoPedido($data['id_pedido'], $data['estado'])) {
      echo json_encode(["result" => 0, "msg" => "Error al actualizar el estado del pedido"]);
    } else {
      echo json_encode(["result" => 1, "msg" => "¡Pedido actualizado correctamente!"]);
    }
    break;
  case "cancelar_pedido":
    if (!CtrlGestorPedidos::cancelarPedido($data['id_pedido'])) {
      echo json_encode(["result" => 0, "msg" => "Error al cancelar el pedido"]);
    } else {
      echo json_encode(["result" => 1, "msg" => "¡Pedido cancelado correctamente!"]);
    }
    break;
  default:
    echo json_encode(["result" => 0, "msg" => "Petición inválida"]);
    die();
}
