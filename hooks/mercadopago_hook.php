<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/Global.php';
require_once __DIR__ . '/../controller/cliente/pedidos/CtrlPedidos.php';
require_once __DIR__ . "/../controller/cliente/carrito/CtrlCarrito.php";

use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

$access_token = $_ENV["MERCADO_PAGO_SECRET_KEY"];

header('Content-Type: application/json');

// Logging RAW
file_put_contents(__DIR__ . '/../logs/hook_raw.log', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);

$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Logging de la notificación recibida
file_put_contents(__DIR__ . '/../logs/mercadopago_webhook_raw.log', date('c') . " - RAW: " . $input . "\n", FILE_APPEND);

// MercadoPago envía varios tipos de notificaciones, nos interesa "payment"
if (!isset($_GET['type']) || $_GET['type'] !== 'payment') {
  echo json_encode(['status' => 'ignored']);
  exit;
}

// Obtiene el ID del pago
$payment_id = $_GET['data_id'] ?? $_GET['id'] ?? null;

// Si no viene por GET, intenta obtenerlo del body (caso de pruebas manuales)
if (!$payment_id && isset($data['data']['id'])) {
  $payment_id = $data['data']['id'];
}

if (!$payment_id) {
  file_put_contents(__DIR__ . '/../logs/mercadopago_webhook_error.log', date('c') . " - No payment_id\n", FILE_APPEND);
  http_response_code(400);
  echo json_encode(['error' => 'No payment_id']);
  exit;
}

// Consulta manual a la API de MercadoPago
function getMercadoPagoPayment($payment_id, $access_token)
{
  $url = "https://api.mercadopago.com/v1/payments/" . urlencode($payment_id);

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $access_token",
    "Content-Type: application/json"
  ]);
  $response = curl_exec($ch);

  if ($response === false) {
    throw new Exception("cURL error: " . curl_error($ch));
  }

  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($http_code !== 200) {
    throw new Exception("MercadoPago API error: HTTP $http_code - $response");
  }

  $payment = json_decode($response, true);

  // Cast id fields to int if needed
  if (isset($payment['id'])) {
    $payment['id'] = (int)$payment['id'];
  }
  if (isset($payment['order']) && isset($payment['order']['id'])) {
    $payment['order']['id'] = (int)$payment['order']['id'];
  }

  return $payment;
}

try {
  $payment = getMercadoPagoPayment($payment_id, $access_token);

  // Si el pago está aprobado, crea el pedido y limpia el carrito
  if ($payment['status'] === 'approved') {
    $external_reference = $payment['external_reference'];
    // Verifica que no exista ya el pedido para evitar duplicados
    if (!CtrlPedidos::pedidoExiste($payment_id)) {
      CtrlPedidos::crearPedido((int)$external_reference, $payment_id, $payment['status']);
      CtrlCarrito::limpiarCarrito((int)$external_reference);
    }
  }

  // Logging para debug
  file_put_contents(__DIR__ . '/../logs/mercadopago_webhook.log', date('c') . " - Pago $payment_id: {$payment['status']} - {$payment['external_reference']}\n", FILE_APPEND);

  echo json_encode(['status' => 'ok', 'payment_status' => $payment['status']]);
} catch (\Throwable $e) {
  file_put_contents(__DIR__ . '/../logs/mercadopago_webhook_error.log', date('c') . " - Error: " . $e->getMessage() . "\n", FILE_APPEND);
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}
