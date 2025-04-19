<?php
ini_set('display_errors', E_ALL); //Esta linea solo es para pruebas, no dejar en produccion
session_start();

require_once __DIR__ . "/../../../config/Global.php";
require_once __DIR__ . "/CtrlMtoClientes.php";
require_once __DIR__ . "/../../../classes/Email.php";
require_once __DIR__ . "/../../guardarFoto.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["result" => 0, "msg" => "Método no permitido"]);
  die();
}

//Recepción de los datos
$peticion = isset($_POST['peticion']) ? $_POST['peticion'] : "";
$id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : "";
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
$appat = isset($_POST['appat']) ? $_POST['appat'] : "";
$apmat = isset($_POST['apmat']) ? $_POST['apmat'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : "";
$codigo_postal = isset($_POST['codigo_postal']) ? $_POST['codigo_postal'] : "";
$estado_domicilio = isset($_POST['estado_domicilio']) ? $_POST['estado_domicilio'] : "";
$alc_mun = isset($_POST['alc_mun']) ? $_POST['alc_mun'] : "";
$colonia = isset($_POST['colonia']) ? $_POST['colonia'] : "";
$calle = isset($_POST['calle']) ? $_POST['calle'] : "";
$no_ext = isset($_POST['no_ext']) ? $_POST['no_ext'] : "";
$no_int = isset($_POST['no_int']) ? $_POST['no_int'] : "";

if (
  !$peticion
  && !$id_cliente
  && !$nombre
  && !$appat
  && !$apmat
  && !$email
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
  $peticion = $data['peticion'] ?? null;
  $id_cliente = $data['id_cliente'] ?? null;
  $nombre = $data['nombre'] ?? null;
  $appat = $data['appat'] ?? null;
  $apmat = $data['apmat'] ?? null;
  $email = $data['email'] ?? null;
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

//Procesamiento de los datos
switch ($peticion) {
  case "INSERT":
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
      $Email = new Email($email);
      if ($Email->existeEmail()) {
        echo json_encode(["result" => 0, "msg" => "El correo electrónico enviado ya existe, elige otro"]);
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
          echo json_encode(["result" => 1, "msg" => "Registro insertado correctamente"]);
        } else {
          echo json_encode(["result" => 0, "msg" => "ERROR: Problema de inserción en BD"]);
        }
      }
    }
    break;
  case "UPDATE":
    $ctrl = new CtrlMtoClientes("UPDATE", $id_cliente);
    if ($password === "") $password = null;
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
      $Email = new Email($email);
      $oldEmail = $ctrl->seleccionaRegistro($id_cliente)[0]["email"];
      if ($Email->existeEmail() && $email !== $oldEmail) {
        echo json_encode(["result" => 0, "msg" => "El correo electrónico enviado ya existe, elige otro"]);
      } else {
        $foto_path = guardarFoto("UPDATE", $id_cliente, "cliente");
        if ($ctrl->modificaRegistro(
          $id_cliente,
          $nombre,
          $appat,
          $apmat,
          $email,
          $password === null ? null : password_hash($password, PASSWORD_DEFAULT),
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
          if ($_SESSION["usuario"] === "cliente") {
            $_SESSION["datos"]["nombre"] = $nombre;
            $_SESSION["datos"]["appat"] = $appat;
            $_SESSION["datos"]["apmat"] = $apmat;
            $_SESSION["datos"]["email"] = $email;
            $_SESSION["datos"]["telefono"] = $telefono;
            $_SESSION["datos"]["codigo_postal"] = $codigo_postal;
            $_SESSION["datos"]["estado_domicilio"] = $estado_domicilio;
            $_SESSION["datos"]["alc_mun"] = $alc_mun;
            $_SESSION["datos"]["colonia"] = $colonia;
            $_SESSION["datos"]["calle"] = $calle;
            $_SESSION["datos"]["no_ext"] = $no_ext;
            $_SESSION["datos"]["no_int"] = $no_int;
            if ($foto_path !== "") $_SESSION["datos"]["foto_path"] = $foto_path;
          }
          echo json_encode(
            [
              "result" => 1,
              "msg" => "Registro modificado correctamente",
              "nuevos_datos" => [
                "nombre" => $nombre,
                "appat" => $appat,
                "apmat" => $apmat,
                "email" => $email,
                "telefono" => $telefono,
                "foto_path" => $foto_path,
                "codigo_postal" => $codigo_postal,
                "estado_domicilio" => $estado_domicilio,
                "alc_mun" => $alc_mun,
                "colonia" => $colonia,
                "calle" => $calle,
                "no_ext" => $no_ext,
                "no_int" => $no_int
              ],
              "usuario" => $_SESSION["usuario"]
            ]
          );
        } else {
          echo json_encode(["result" => 0, "msg" => "ERROR: Problema de modificación en BD"]);
        }
      }
    }
    break;
  default:
    echo json_encode(["result" => 0, "msg" => "ERROR: Petición inválida"]);
    die();
}
