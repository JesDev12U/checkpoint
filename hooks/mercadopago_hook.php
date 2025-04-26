
<?php
ini_set('display_errors', E_ALL);
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/Global.php';
require_once __DIR__ . '/../controller/cliente/pedidos/CtrlPedidos.php';
require_once __DIR__ . "/../controller/cliente/carrito/CtrlCarrito.php";

use Dotenv\Dotenv;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

// Configura la clave secreta
MercadoPagoConfig::setAccessToken($_ENV["MERCADO_PAGO_SECRET_KEY"]);

header('Content-Type: application/json');

// Recibe la notificación de MercadoPago
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

// Consulta el estado real del pago usando la API de MercadoPago
try {
  $client = new PaymentClient();
  $payment = $client->get($payment_id);

  // Si el pago está aprobado, crea el pedido y limpia el carrito
  if ($payment->status === 'approved') {
    $external_reference = $payment->external_reference;
    // Verifica que no exista ya el pedido para evitar duplicados
    if (!CtrlPedidos::pedidoExiste($payment_id)) {
      CtrlPedidos::crearPedido((int)$external_reference, $payment_id, $payment->status);
      CtrlCarrito::limpiarCarrito((int)$external_reference);
    }
  }

  // Logging para debug
  file_put_contents(__DIR__ . '/../logs/mercadopago_webhook.log', date('c') . " - Pago $payment_id: {$payment->status} - $payment->external_reference\n", FILE_APPEND);

  echo json_encode(['status' => 'ok', 'payment_status' => $payment->status]);
} catch (Exception $e) {
  file_put_contents(__DIR__ . '/../logs/mercadopago_webhook_error.log', date('c') . " - Error: " . $e->getMessage() . "\n", FILE_APPEND);
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}
