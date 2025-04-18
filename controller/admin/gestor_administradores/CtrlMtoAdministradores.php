<?php
require_once __DIR__ . "/../../../model/Model.php";

class CtrlMtoAdministradores
{
  const VISTA = __DIR__ . "/../../../view/admin/gestor_administradores/mto_administradores.php";
  const CSS = __DIR__ . "/../../../css/admin/mto_administradores.css";
  const JS = __DIR__ . "/../../../js/admin/mto_administradores.js";
  public $peticion;
  public $id_admin;
  public $nombre;
  public $appat;
  public $apmat;
  public $email;
  public $foto_path;
  public $telefono;
  public $estado;
  public $title;
  public $opciones;
  public $mantenimiento;

  public function __construct($peticion = null, $id_admin = null, $mantenimiento)
  {
    $this->mantenimiento = $mantenimiento;
    if ($mantenimiento) {
      $this->title = "Mantenimiento de administradores";
      $this->opciones = [
        ["nombre" => ICON_HOME, "href" => SITE_URL . RUTA_ADMINISTRADOR, "id" => "home"]
      ];
    } else {
      $this->title = "Configuración de la cuenta";
      $this->opciones = [
        ["nombre" => ICON_HOME, "href" => SITE_URL . RUTA_ADMINISTRADOR, "id" => "home"]
      ];
    }
    $this->peticion = $peticion;
    $this->id_admin = $id_admin;
    if ($id_admin !== null) {
      $res = $this->seleccionaRegistro($id_admin);
      if (count($res) !== 0) {
        $this->nombre = $res[0]["nombre"];
        $this->appat = $res[0]["appat"];
        $this->apmat = $res[0]["apmat"];
        $this->email = $res[0]["email"];
        $this->foto_path = $res[0]["foto_path"];
        $this->telefono = $res[0]["telefono"];
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
    $id_admin = null,
    $nombre = null,
    $appat = null,
    $apmat = null,
    $email = null,
    $password = null,
    $telefono = null
  ) {
    $res = true;
    if (!is_null($id_admin)) {
      $id_admin = (int)$id_admin;
      $res = $res && is_integer($id_admin) && $id_admin > 0;
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

  public function seleccionaRegistro($id_admin)
  {
    $model = new Model();
    return $model->seleccionaRegistros("administradores", ["*"], "id_admin=$id_admin");
  }

  public function seleccionaFoto($id_admin)
  {
    $model = new Model();
    return $model->seleccionaRegistros("administradores", ['foto_path'], "id_admin=$id_admin");
  }

  public function insertaRegistro(
    $nombre,
    $appat,
    $apmat,
    $email,
    $password,
    $foto_path,
    $telefono
  ) {
    $model = new Model();
    return $model->agregaRegistro(
      "administradores",
      [
        "nombre",
        "appat",
        "apmat",
        "email",
        "password",
        "estado",
        "foto_path",
        "telefono"
      ],
      [
        $nombre,
        $appat,
        $apmat,
        $email,
        $password,
        true,
        $foto_path,
        $telefono
      ]
    );
  }

  public function modificaRegistro(
    $id_admin,
    $nombre,
    $appat,
    $apmat,
    $email,
    $password,
    $foto_path,
    $telefono
  ) {
    $model = new Model();
    // Comprobación de que la foto no se debe subir vacía
    $foto_path = $foto_path === "" ? $this->foto_path : $foto_path;
    $campos = [];
    $variables = [];
    if ($password === null) {
      $campos = [
        "nombre",
        "appat",
        "apmat",
        "email",
        "foto_path",
        "telefono"
      ];
      $variables = [
        $nombre,
        $appat,
        $apmat,
        $email,
        $foto_path,
        $telefono
      ];
    } else {
      $campos = [
        "nombre",
        "appat",
        "apmat",
        "email",
        "password",
        "foto_path",
        "telefono"
      ];
      $variables = [
        $nombre,
        $appat,
        $apmat,
        $email,
        $password,
        $foto_path,
        $telefono
      ];
    }
    return $model->modificaRegistro("administradores", $campos, "id_admin=$id_admin", $variables);
  }

  public function deshabilitarRegistro($id_admin)
  {
    $model = new Model();
    return $model->modificaRegistro("administradores", ["estado"], "id_admin=$id_admin", [0]);
  }

  public function habilitarRegistro($id_admin)
  {
    $model = new Model();
    return $model->modificaRegistro("administradores", ['estado'], "id_admin=$id_admin", [1]);
  }
}
