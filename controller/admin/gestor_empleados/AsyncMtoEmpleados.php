<?php
ini_set('display_errors', E_ALL); //Esta linea solo es para pruebas, no dejar en produccion
session_start();

require_once __DIR__ . "/../../../config/Global.php";
require_once __DIR__ . "/CtrlMtoEmpleados.php";
require_once __DIR__ . "/../../../classes/Email.php";
require_once __DIR__ . "/../../guardarFoto.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["result" => 0, "msg" => "Método no permitido"]);
  die();
}

//Recepción de los datos
$peticion = isset($_POST['peticion']) ? $_POST['peticion'] : "";
$id_empleado = isset($_POST['id_empleado']) ? $_POST['id_empleado'] : "";
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
$appat = isset($_POST['appat']) ? $_POST['appat'] : "";
$apmat = isset($_POST['apmat']) ? $_POST['apmat'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : "";

if (
  !$peticion
  && !$id_empleado
  && !$nombre
  && !$appat
  && !$apmat
  && !$email
  && !$password
  && !$telefono
) {
  header('Content-Type: application/json');
  $jsonData = file_get_contents("php://input");
  $data = json_encode($jsonData, true);
  $peticion = $data['peticion'] ?? null;
  $id_empleado = $data['id_empleado'] ?? null;
  $nombre = $data['nombre'] ?? null;
  $appat = $data['appat'] ?? null;
  $apmat = $data['apmat'] ?? null;
  $email = $data['email'] ?? null;
  $password = $data['password'] ?? null;
  $telefono = $data['telefono'] ?? null;
}

//Procesamiento de los datos
switch ($peticion) {
  case "INSERT":
    $ctrl = new CtrlMtoEmpleados("INSERT");
    if (!$ctrl->validaAtributos(
      null,
      $nombre,
      $appat,
      $apmat,
      $email,
      $password,
      $telefono
    )) {
      echo json_encode(["result" => 0, "msg" => "ERROR: Datos inválidos"]);
    } else {
      $Email = new Email($email);
      if ($Email->existeEmail()) {
        echo json_encode(["result" => 0, "msg" => "El correo electrónico enviado ya existe, elige otro"]);
      } else {
        $foto_path = guardarFoto(null, null, "empleado");
        if ($ctrl->insertaRegistro(
          $nombre,
          $appat,
          $apmat,
          $email,
          password_hash($password, PASSWORD_DEFAULT),
          $telefono,
          $foto_path
        )) {
          echo json_encode(["result" => 1, "msg" => "Registro insertado correctamente"]);
        } else {
          echo json_encode(["result" => 0, "msg" => "ERROR: Problema de inserción en BD"]);
        }
      }
    }
    break;
  case "UPDATE":
    $ctrl = new CtrlMtoEmpleados("UPDATE", $id_empleado);
    if ($password === "") $password = null;
    if (!$ctrl->validaAtributos(
      $id_empleado,
      $nombre,
      $appat,
      $apmat,
      $email,
      $password,
      $telefono
    )) {
      echo json_encode(["result" => 0, "msg" => "ERROR: Datos inválidos"]);
    } else {
      $Email = new Email($email);
      $oldEmail = $ctrl->seleccionaRegistro($id_empleado)[0]["email"];
      if ($Email->existeEmail() && $email !== $oldEmail) {
        echo json_encode(["result" => 0, "msg" => "El correo electrónico enviado ya existe, elige otro"]);
      } else {
        $foto_path = guardarFoto("UPDATE", $id_empleado, "empleado");
        if ($ctrl->modificaRegistro(
          $id_empleado,
          $nombre,
          $appat,
          $apmat,
          $email,
          $password === null ? null : password_hash($password, PASSWORD_DEFAULT),
          $telefono,
          $foto_path
        )) {
          if ($_SESSION["usuario"] === "empleado") {
            $_SESSION["datos"]["nombre"] = $nombre;
            $_SESSION["datos"]["appat"] = $appat;
            $_SESSION["datos"]["apmat"] = $apmat;
            $_SESSION["datos"]["email"] = $email;
            $_SESSION["datos"]["telefono"] = $telefono;
            if ($foto_path !== "") $_SESSION["datos"]["foto_path"] = $foto_path;
            if (
              isset($_COOKIE['cookie_consent'])
              && $_COOKIE['cookie_consent'] === '1'
              && isset($_COOKIE["session_data"])
            ) {
              $cookieData = [
                "loggeado" => true,
                "usuario" => $_SESSION["usuario"],
                "datos" => $_SESSION["datos"]
              ];
              setcookie(
                "session_data",
                base64_encode(json_encode($cookieData)),
                time() + (86400 * 30), // 30 días
                "/",
                "",
                false,
                true // httponly
              );
            }
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
                "foto_path" => $foto_path
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
