<?php
require_once __DIR__ . "/../../../model/Model.php";

class CtrlMtoEmpleados
{
  const VISTA = __DIR__ . "/../../../view/admin/gestor_empleados/mto_empleados.php";
  const CSS = __DIR__ . "/../../../css/admin/mto_empleados.css";
  const JS = __DIR__ . "/../../../js/admin/mto_empleados.js";
  public $peticion;
  public $id_empleado;
  public $nombre;
  public $appat;
  public $apmat;
  public $email;
  public $telefono;
  public $foto_path;
  public $estado;
  public $title;
  public $opciones;

  public function __construct($peticion = null, $id_empleado = null, $usuario = "administrador")
  {
    if ($usuario === "administrador") {
      $this->title = "Mantenimiento de empleados";
      $this->opciones = [
        ["nombre" => ICON_HOME, "href" => SITE_URL . RUTA_ADMINISTRADOR, "id" => "home"],
        ["nombre" => ICON_CERRAR_SESION, "href" => SITE_URL . RUTA_CERRAR_SESION, "id" => "cerrar-sesion"]
      ];
    } else {
      $this->title = "Configuración de la cuenta";
      $this->opciones = [
        ["nombre" => ICON_HOME, "href" => SITE_URL . RUTA_EMPLEADO, "id" => "home"],
        ["nombre" => ICON_CERRAR_SESION, "href" => SITE_URL . RUTA_CERRAR_SESION, "id" => "cerrar-sesion"]
      ];
    }
    $this->peticion = $peticion;
    $this->id_empleado = $id_empleado;
    if ($id_empleado !== null) {
      $res = $this->seleccionaRegistro($id_empleado);
      if (count($res) !== 0) {
        $this->nombre = $res[0]["nombre"];
        $this->appat = $res[0]["appat"];
        $this->apmat = $res[0]["apmat"];
        $this->email = $res[0]["email"];
        $this->telefono = $res[0]["telefono"];
        $this->foto_path = $res[0]["foto_path"];
        $this->estado = $res[0]["estado"];
      }
    }
  }

  public function renderContent()
  {
    include self::VISTA;
  }

  public function renderCSS()
  {
    include self::CSS;
  }

  public function renderJS()
  {
    include self::JS;
  }

  public function validaAtributos(
    $id_empleado = null,
    $nombre = null,
    $appat = null,
    $apmat = null,
    $email = null,
    $password = null,
    $telefono = null
  ) {
    $res = true;
    if (!is_null($id_empleado)) {
      $id_empleado = (int)$id_empleado;
      $res = $res && is_integer(($id_empleado)) && $id_empleado > 0;
    }
    if (!is_null($nombre)) {
      $res = $res && $nombre !== "" && strlen($nombre) <= 50;
    }
    if (!is_null($appat)) {
      $res = $res && $appat !== "" && strlen($appat) <= 50;
    }
    if (!is_null($apmat)) {
      $res = $res && $apmat !== "" && strlen($apmat) <= 50;
    }
    if (!is_null($email)) {
      $res = $res && preg_match('/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/', $email, $matches) && strlen($email) <= 80;
    }
    if (!is_null($password)) {
      $res = $res && $password !== "" && strlen($password) <= 16;
    }
    if (!is_null($telefono)) {
      $res = $res && preg_match('/[0-9]{10}/', $telefono, $matches);
    }
    return $res;
  }

  public function seleccionaRegistro($id_empleado)
  {
    $model = new Model();
    return $model->seleccionaRegistros("empleados", ["*"], "id_empleado=$id_empleado");
  }

  public function seleccionaFoto($id_empleado)
  {
    $model = new Model();
    return $model->seleccionaRegistros("empleados", ['foto_path'], "id_empleado=$id_empleado");
  }

  public function insertaRegistro(
    $nombre,
    $appat,
    $apmat,
    $email,
    $password,
    $telefono,
    $foto_path
  ) {
    $model = new Model();
    return $model->agregaRegistro(
      "empleados",
      [
        "nombre",
        "appat",
        "apmat",
        "email",
        "password",
        "telefono",
        "foto_path",
        "estado"
      ],
      [
        $nombre,
        $appat,
        $apmat,
        $email,
        $password,
        $telefono,
        $foto_path,
        true
      ]
    );
  }
  public function modificaRegistro(
    $id_empleado,
    $nombre,
    $appat,
    $apmat,
    $email,
    $password,
    $telefono,
    $foto_path
  ) {
    $model = new Model();
    //Comprobación de que la foto no se debe subir vacía
    $foto_path = $foto_path === "" ? $this->foto_path : $foto_path;
    $campos = [];
    $variables = [];
    if ($password === null) {
      $campos = [
        "nombre",
        "appat",
        "apmat",
        "email",
        "telefono",
        "foto_path"
      ];
      $variables = [
        $nombre,
        $appat,
        $apmat,
        $email,
        $telefono,
        $foto_path
      ];
    } else {
      $campos = [
        "nombre",
        "appat",
        "apmat",
        "email",
        "password",
        "telefono",
        "foto_path"
      ];
      $variables = [
        $nombre,
        $appat,
        $apmat,
        $email,
        $password,
        $telefono,
        $foto_path
      ];
    }
    return $model->modificaRegistro("empleados", $campos, "id_empleado=$id_empleado", $variables);
  }

  public function deshabilitarRegistro($id_empleado)
  {
    $model = new Model();
    return $model->modificaRegistro("empleados", ["estado"], "id_empleado=$id_empleado", [0]);
  }

  public function habilitarRegistro($id_empleado)
  {
    $model = new Model();
    return $model->modificaRegistro("empleados", ["estado"], "id_empleado=$id_empleado", [1]);
  }
}
