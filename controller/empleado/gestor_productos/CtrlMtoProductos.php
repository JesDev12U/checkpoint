
<?php
require_once __DIR__ . "/../../../model/Model.php";
require_once __DIR__ . "/../../../config/Global.php";

class CtrlMtoProductos
{
  const VISTA = __DIR__ . "/../../../view/empleado/gestor_productos/mto_productos.php";
  const CSS = __DIR__ . "/../../../css/empleado/mto_productos.css";
  const JS = __DIR__ . "/../../../js/empleado/mto_productos.js";
  public $peticion;
  public $id_producto;
  public $nombre;
  public $categoria1;
  public $categoria2;
  public $categoria3;
  public $precio;
  public $estado;
  public $descripcion;
  public $cantidad;
  public $foto_path;

  public $title = "Mantenimiento de productos";

  public function __construct($peticion = null, $id_producto = null)
  {
    $this->peticion = $peticion;
    $this->id_producto = $id_producto;
    if ($id_producto !== null) {
      $res = $this->seleccionaRegistro($id_producto);
      if (count($res) !== 0) {
        $this->nombre = $res[0]["nombre"];
        $this->categoria1 = $res[0]["categoria1"];
        $this->categoria2 = $res[0]["categoria2"];
        $this->categoria3 = $res[0]["categoria3"];
        $this->precio = $res[0]["precio"];
        $this->estado = $res[0]["estado"];
        $this->descripcion = $res[0]["descripcion"];
        $this->cantidad = $res[0]["cantidad"];
        $this->foto_path = $res[0]["foto_path"];
      }
    }
  }

  public $opciones = [
    ["nombre" => ICON_HOME, "href" => SITE_URL . RUTA_EMPLEADO, "id" => "home"]
  ];

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

  public function seleccionaRegistro($id_producto)
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "productos",
      ["*"],
      "id_producto=$id_producto"
    ) ?? [];
  }

  public function seleccionaFoto($id_producto)
  {
    $model = new Model();
    return $model->seleccionaRegistros("productos", ['foto_path'], "id_producto=$id_producto");
  }

  public function validaAtributos(
    $id_producto = null,
    $nombre = null,
    $categoria1 = null,
    $categoria2 = null,
    $categoria3 = null,
    $precio = null,
    $descripcion = null,
    $cantidad = null
  ) {
    $res = true;

    // Validación de id_producto
    if (!is_null($id_producto)) {
      $id_producto = (int)$id_producto;
      $res = $res && is_integer($id_producto) && $id_producto > 0;
    }

    // Validación de nombre
    if (!is_null($nombre)) {
      $res = $res && $nombre !== "" && strlen($nombre) <= 50;
    }

    // Validación de categorías
    $categorias1 = ["Consolas", "Videojuegos"];
    $categorias2 = ["PlayStation", "Xbox", "Nintendo"];
    $categorias3 = [
      "PlayStation" => ["PS1", "PS2", "PS3", "PS4", "PS5"],
      "Xbox" => ["Xbox", "Xbox360", "XboxOne", "XboxSeriesXS"],
      "Nintendo" => ["Nintendo64", "GameCube", "Wii", "Switch"]
    ];

    // Categoria 1
    if (!is_null($categoria1)) {
      $res = $res && in_array($categoria1, $categorias1, true);
    }

    // Categoria 2
    if (!is_null($categoria2)) {
      $res = $res && in_array($categoria2, $categorias2, true);
    }

    // Categoria 3 (solo si categoria2 es válida)
    if (!is_null($categoria3) && !is_null($categoria2) && isset($categorias3[$categoria2])) {
      $res = $res && in_array($categoria3, $categorias3[$categoria2], true);
    } else if (!is_null($categoria3)) {
      // Si categoria3 viene pero categoria2 no es válida, la validación falla
      $res = false;
    }

    // Validación de precio
    if (!is_null($precio)) {
      $res = $res && is_numeric($precio) && $precio >= 0;
    }

    // Validación de descripción
    if (!is_null($descripcion)) {
      $res = $res && strlen($descripcion) <= 255;
    }

    // Validación de cantidad
    if (!is_null($cantidad)) {
      $res = $res && is_numeric($cantidad) && $cantidad >= 0;
    }

    return $res;
  }

  public function insertaRegistro(
    $nombre,
    $categoria1,
    $categoria2,
    $categoria3,
    $precio,
    $descripcion,
    $cantidad,
    $foto_path
  ) {
    $model = new Model();
    return $model->agregaRegistro(
      "productos",
      [
        "nombre",
        "categoria1",
        "categoria2",
        "categoria3",
        "precio",
        "estado",
        "descripcion",
        "cantidad",
        "foto_path"
      ],
      [
        $nombre,
        $categoria1,
        $categoria2,
        $categoria3,
        $precio,
        true,
        $descripcion,
        $cantidad,
        $foto_path
      ]
    );
  }

  public function modificaRegistro(
    $id_producto,
    $nombre,
    $categoria1,
    $categoria2,
    $categoria3,
    $precio,
    $descripcion,
    $cantidad,
    $foto_path
  ) {
    $model = new Model();
    // Comprobación de que la foto no se debe subir vacía
    $foto_path = $foto_path === "" ? $this->foto_path : $foto_path;
    return $model->modificaRegistro(
      "productos",
      [
        "nombre",
        "categoria1",
        "categoria2",
        "categoria3",
        "precio",
        "descripcion",
        "cantidad",
        "foto_path"
      ],
      "id_producto=$id_producto",
      [
        $nombre,
        $categoria1,
        $categoria2,
        $categoria3,
        $precio,
        $descripcion,
        $cantidad,
        $foto_path
      ]
    );
  }

  public function deshabilitarRegistro($id_producto)
  {
    $model = new Model();
    return $model->modificaRegistro(
      "productos",
      ["estado"],
      "id_producto=$id_producto",
      [0]
    );
  }

  public function habilitarRegistro($id_producto)
  {
    $model = new Model();
    return $model->modificaRegistro(
      "productos",
      ["estado"],
      "id_producto=$id_producto",
      [1]
    );
  }
}
