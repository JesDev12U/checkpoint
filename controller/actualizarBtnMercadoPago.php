
<?php
ini_set('display_errors', E_ALL);
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/Global.php';
require_once __DIR__ . "/cliente/carrito/CtrlCarrito.php";
session_start();

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

// Configura la clave secreta
MercadoPagoConfig::setAccessToken($_ENV["MERCADO_PAGO_SECRET_KEY"]);

header('Content-Type: application/json');

$client = new PreferenceClient();

try {
  // Obtener items directo del carrito
  $preference = $client->create([
    "items" => CtrlCarrito::obtenerProductosMercadoPago($_SESSION["datos"]["id_cliente"]),
    "statement_descriptor" => "Checkpoint Game Store",
    "external_reference" => $_SESSION["datos"]["id_cliente"],
    "back_urls" => [
      "success" => SITE_URL . "cliente/carrito?estado_pago=success",
      "failure" => SITE_URL . "cliente/carrito?estado_pago=failure",
      "pending" => SITE_URL . "cliente/carrito?estado_pago=pending"
    ],
    "auto_return" => "approved"
  ]);
  echo json_encode(['preferenceId' => $preference->id]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode([
    'error' => $e->getMessage(),
    'trace' => $e->getTraceAsString()
  ]);
}
