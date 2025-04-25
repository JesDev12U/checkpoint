<?php
ini_set('display_errors',  E_ALL);
session_start();

require_once __DIR__ . "/../../../config/Global.php";
require_once __DIR__ . "/../../../classes/Email.php";
require_once __DIR__ . "/../../admin/gestor_clientes/CtrlMtoClientes.php";
require_once __DIR__ . "/../../guardarFoto.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["result" => 0, "msg" => "Método no permitido"]);
  die();
}

// Recepción de los datos
$operacion = isset($_POST["operacion"]) ? $_POST["operacion"] : "";
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$codigo = isset($_POST["codigo"]) ? $_POST["codigo"] : "";
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
$appat = isset($_POST["appat"]) ? $_POST["appat"] : "";
$apmat = isset($_POST["apmat"]) ? $_POST["apmat"] : "";
$telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : "";
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$password = isset($_POST["password"]) ? $_POST["password"] : "";
$codigo_postal = isset($_POST['codigo_postal']) ? $_POST['codigo_postal'] : "";
$estado_domicilio = isset($_POST['estado_domicilio']) ? $_POST['estado_domicilio'] : "";
$alc_mun = isset($_POST['alc_mun']) ? $_POST['alc_mun'] : "";
$colonia = isset($_POST['colonia']) ? $_POST['colonia'] : "";
$calle = isset($_POST['calle']) ? $_POST['calle'] : "";
$no_ext = isset($_POST['no_ext']) ? $_POST['no_ext'] : "";
$no_int = isset($_POST['no_int']) ? $_POST['no_int'] : "";

if (
  !$operacion
  && !$nombre
  && !$appat
  && !$apmat
  && !$email
  && !$codigo
  && !$password
  && !$telefono
  && !$codigo_postal
  && !$estado_domicilio
  && !$alc_mun
  && !$colonia
  && !$calle
  && !$no_ext
  && !$no_int
) {
  header('Content-Type: application/json');
  $jsonData = file_get_contents("php://input");
  $data = json_encode($jsonData, true);
  $operacion = $data['operacion'] ?? null;
  $nombre = $data['nombre'] ?? null;
  $appat = $data['appat'] ?? null;
  $apmat = $data['apmat'] ?? null;
  $email = $data['email'] ?? null;
  $codigo = $data['codigo'] ?? null;
  $password = $data['password'] ?? null;
  $telefono = $data['telefono'] ?? null;
  $codigo_postal = $data['codigo_postal'] ?? null;
  $estado_domicilio = $data['estado_domicilio'] ?? null;
  $alc_mun = $data['alc_mun'] ?? null;
  $colonia = $data['colonia'] ?? null;
  $calle = $data['calle'] ?? null;
  $no_ext = $data['no_ext'] ?? null;
  $no_int = $data['no_int'] ?? null;
}

// Procesamiento de los datos
switch ($operacion) {
  case "enviar_codigo":
    $Email = new Email($email);
    if ($Email->existeEmail()) {
      echo json_encode(["result" => 0, "msg" => "El email ingresado ya existe en nuestra base de datos, por favor ingresa otro"]);
      die();
    }
    $codigoVerificacion = $Email->enviarCodigo();
    if ($codigoVerificacion === null) {
      echo json_encode(["result" => 0, "msg" => "Error al enviar el código"]);
    } else {
      echo json_encode(["result" => 1]);
      $_SESSION["codigo"] = $codigoVerificacion;
    }
    break;
  case "comprobar_codigo":
    if (!isset($_SESSION['codigo'])) {
      echo json_encode(["result" => 0, "msg" => "No haz solicitado el código"]);
    } else if ($codigo != $_SESSION["codigo"]) {
      echo json_encode(["result" => 0, "msg" => "Código inválido"]);
    } else if ($codigo == $_SESSION["codigo"]) {
      // Crear cuenta
      $ctrl = new CtrlMtoClientes("INSERT");
      if (!$ctrl->validaAtributos(
        null,
        $nombre,
        $appat,
        $apmat,
        $email,
        $password,
        $telefono,
        $codigo_postal,
        $estado_domicilio,
        $alc_mun,
        $colonia,
        $calle,
        $no_ext,
        $no_int
      )) {
        echo json_encode(["result" => 0, "msg" => "ERROR: Datos inválidos"]);
      } else {
        $foto_path = guardarFoto(null, null, "cliente");
        if ($ctrl->insertaRegistro(
          $nombre,
          $appat,
          $apmat,
          $email,
          password_hash($password, PASSWORD_DEFAULT),
          $telefono,
          $foto_path,
          $codigo_postal,
          $estado_domicilio,
          $alc_mun,
          $colonia,
          $calle,
          $no_ext,
          $no_int
        )) {
          session_unset();
          session_destroy();
          echo json_encode(["result" => 1, "msg" => "¡Cuenta creada correctamente!"]);
        } else {
          echo json_encode(["result" => 0, "msg" => "ERROR: Problema de inserción en BD"]);
        }
      }
    }
    break;
}
