<?php
require_once __DIR__ . "/../../../model/Model.php";

class CtrlMtoClientes
{
  const VISTA = __DIR__ . "/../../../view/admin/gestor_clientes/mto_clientes.php";
  const CSS = __DIR__ . "/../../../css/admin/mto_clientes.css";
  const JS = __DIR__ . "/../../../js/admin/mto_clientes.js";
  public $peticion;
  public $id_cliente;
  public $nombre;
  public $appat;
  public $apmat;
  public $email;
  public $telefono;
  public $foto_path;
  public $estado;
  public $codigo_postal;
  public $estado_domicilio;
  public $alc_mun;
  public $colonia;
  public $calle;
  public $no_ext;
  public $no_int;
  public $title;
  public $opciones;

  public function __construct($peticion = null, $id_cliente = null, $usuario = "administrador")
  {
    if ($usuario === "administrador") {
      $this->title = "Mantenimiento de clientes";
      $this->opciones = [
        ["nombre" => ICON_HOME, "href" => SITE_URL . RUTA_ADMINISTRADOR, "id" => "home"],
        ["nombre" => ICON_CERRAR_SESION, "href" => SITE_URL . RUTA_CERRAR_SESION, "id" => "cerrar-sesion"]
      ];
    } else {
      $this->title = "Configuración de la cuenta";
      $this->opciones = [
        ["nombre" => ICON_HOME, "href" => SITE_URL, "id" => "home"],
        ["nombre" => ICON_CERRAR_SESION, "href" => SITE_URL . RUTA_CERRAR_SESION, "id" => "cerrar-sesion"]
      ];
    }
    $this->peticion = $peticion;
    $this->id_cliente = $id_cliente;
    if ($id_cliente !== null) {
      $res = $this->seleccionaRegistro($id_cliente);
      if (count($res) !== 0) {
        $this->nombre = $res[0]["nombre"];
        $this->appat = $res[0]["appat"];
        $this->apmat = $res[0]["apmat"];
        $this->email = $res[0]["email"];
        $this->telefono = $res[0]["telefono"];
        $this->foto_path = $res[0]["foto_path"];
        $this->estado = $res[0]["estado"];
        $this->codigo_postal = $res[0]["codigo_postal"];
        $this->estado_domicilio = $res[0]["estado_domicilio"];
        $this->alc_mun = $res[0]["alc_mun"];
        $this->colonia = $res[0]["colonia"];
        $this->calle = $res[0]["calle"];
        $this->no_ext = $res[0]["no_ext"];
        $this->no_int = $res[0]["no_int"];
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
    $telefono = null,
    $codigo_postal = null,
    $estado_domicilio = null,
    $alc_mun = null,
    $colonia = null,
    $calle = null,
    $no_ext = null,
    $no_int = null
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
    if (!is_null($codigo_postal)) {
      $res = $res && preg_match('/[0-9]{5}/', $codigo_postal, $matches);
    }
    if (!is_null($estado_domicilio)) {
      $res = $res && $estado_domicilio !== "" && strlen($estado_domicilio) <= 30;
    }
    if (!is_null($alc_mun)) {
      $res = $res && $alc_mun !== "" && strlen($alc_mun) <= 40;
    }
    if (!is_null($colonia)) {
      $res = $res && $colonia !== "" && strlen($colonia) <= 40;
    }
    if (!is_null($calle)) {
      $res = $res && $calle !== "" && strlen($calle) <= 30;
    }
    if (!is_null($no_ext)) {
      $res = $res && $no_ext !== "" && strlen($no_ext) <= 10;
    }
    if (!is_null($no_int) && $no_int !== "") {
      $res = $res && strlen($no_int) <= 10;
    }
    return $res;
  }

  public function seleccionaRegistro($id_cliente)
  {
    $model = new Model();
    return $model->seleccionaRegistros("clientes", ["*"], "id_cliente=$id_cliente");
  }

  public function seleccionaFoto($id_cliente)
  {
    $model = new Model();
    return $model->seleccionaRegistros("clientes", ['foto_path'], "id_cliente=$id_cliente");
  }

  public function insertaRegistro(
    $nombre,
    $appat,
    $apmat,
    $email,
    $password,
    $telefono,
    $foto_path,
    $codigo_postal,
    $estado_domicilio,
    $alc_mun,
    $colonia,
    $calle,
    $no_ext,
    $no_int
  ) {
    $model = new Model();
    return $model->agregaRegistro(
      "clientes",
      [
        "nombre",
        "appat",
        "apmat",
        "email",
        "password",
        "telefono",
        "foto_path",
        "estado",
        "codigo_postal",
        "estado_domicilio",
        "alc_mun",
        "colonia",
        "calle",
        "no_ext",
        "no_int"
      ],
      [
        $nombre,
        $appat,
        $apmat,
        $email,
        $password,
        $telefono,
        $foto_path,
        true,
        $codigo_postal,
        $estado_domicilio,
        $alc_mun,
        $colonia,
        $calle,
        $no_ext,
        $no_int
      ]
    );
  }
  public function modificaRegistro(
    $id_cliente,
    $nombre,
    $appat,
    $apmat,
    $email,
    $password,
    $telefono,
    $foto_path,
    $codigo_postal,
    $estado_domicilio,
    $alc_mun,
    $colonia,
    $calle,
    $no_ext,
    $no_int
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
        "foto_path",
        "codigo_postal",
        "estado_domicilio",
        "alc_mun",
        "colonia",
        "calle",
        "no_ext",
        "no_int"
      ];
      $variables = [
        $nombre,
        $appat,
        $apmat,
        $email,
        $telefono,
        $foto_path,
        $codigo_postal,
        $estado_domicilio,
        $alc_mun,
        $colonia,
        $calle,
        $no_ext,
        $no_int
      ];
    } else {
      $campos = [
        "nombre",
        "appat",
        "apmat",
        "email",
        "password",
        "telefono",
        "foto_path",
        "codigo_postal",
        "estado_domicilio",
        "alc_mun",
        "colonia",
        "calle",
        "no_ext",
        "no_int"
      ];
      $variables = [
        $nombre,
        $appat,
        $apmat,
        $email,
        $password,
        $telefono,
        $foto_path,
        $codigo_postal,
        $estado_domicilio,
        $alc_mun,
        $colonia,
        $calle,
        $no_ext,
        $no_int
      ];
    }
    return $model->modificaRegistro("clientes", $campos, "id_cliente=$id_cliente", $variables);
  }

  public function deshabilitarRegistro($id_cliente)
  {
    $model = new Model();
    return $model->modificaRegistro("clientes", ["estado"], "id_cliente=$id_cliente", [0]);
  }

  public function habilitarRegistro($id_cliente)
  {
    $model = new Model();
    return $model->modificaRegistro("clientes", ["estado"], "id_cliente=$id_cliente", [1]);
  }
}
