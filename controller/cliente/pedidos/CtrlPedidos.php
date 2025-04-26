<?php
require_once __DIR__ . "/../../../model/Model.php";
require_once __DIR__ . "/../../../config/Global.php";
require_once __DIR__ . "/../../cliente/carrito/CtrlCarrito.php";

class CtrlPedidos
{
  const VISTA = __DIR__ . "/../../../view/cliente/pedidos.php";
  const CSS = __DIR__ . "/../../../css/cliente/pedidos.css";
  const JS = __DIR__ . "/../../../js/cliente/pedidos.js";
  public $model;
  public $id_cliente;
  public $opciones = [
    ["nombre" => ICON_HOME, "href" => SITE_URL, "id" => "home"]
  ];
  public $title = "Pedidos";
  public $pedidosPendientes;
  public $productosPedidosPendientes;
  public $pedidosAtendidos;
  public $productosPedidosAtendidos;
  public $pedidosCompletados;
  public $productosPedidosCompletados;
  public $pedidosCancelados;
  public $productosPedidosCancelados;

  function __construct()
  {
    $this->id_cliente = $_SESSION["datos"]["id_cliente"];
    $this->pedidosPendientes = self::loadPedidosPendientes();
    $this->productosPedidosPendientes = self::loadProductosPedidosPendientes();
    $this->pedidosAtendidos = self::loadPedidosAtendidos();
    $this->productosPedidosAtendidos = self::loadProductosPedidosAtendidos();
    $this->pedidosCompletados = self::loadPedidosCompletados();
    $this->productosPedidosCompletados = self::loadProductosPedidosCompletados();
    $this->pedidosCancelados = self::loadPedidosCancelados();
    $this->productosPedidosCancelados = self::loadProductosPedidosCancelados();
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

  public function loadPedidosPendientes()
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "pedidos",
      [
        "pedidos.id_pedido",
        "pedidos.fecha",
        "pedidos.hora",
        "pedidos.total"
      ],
      "pedidos.pendiente = 1 AND pedidos.cancelado = 0 AND pedidos.id_cliente = " . $this->id_cliente,
    );
  }

  public function loadProductosPedidosPendientes()
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "pedidos",
      [
        "detalle_pedidos.id_pedido",
        "productos.foto_path",
        "productos.nombre",
        "detalle_pedidos.cantidad",
        "detalle_pedidos.importe"
      ],
      "pedidos.pendiente = 1 AND pedidos.cancelado = 0 AND pedidos.id_cliente = " . $this->id_cliente,
      null,
      "INNER JOIN detalle_pedidos ON pedidos.id_pedido = detalle_pedidos.id_pedido
      INNER JOIN productos ON detalle_pedidos.id_producto = productos.id_producto"
    );
  }

  public function loadPedidosAtendidos()
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "pedidos",
      [
        "pedidos.id_pedido",
        "pedidos.fecha",
        "pedidos.hora",
        "pedidos.total",
        "estado_pedidos.id_empleado",
        "estado_pedidos.estado"
      ],
      "pedidos.pendiente = 0 AND pedidos.cancelado = 0 AND pedidos.id_cliente = " . $this->id_cliente,
      null,
      "INNER JOIN estado_pedidos ON pedidos.id_pedido = estado_pedidos.id_pedido"
    );
  }

  public function loadProductosPedidosAtendidos()
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "pedidos",
      [
        "detalle_pedidos.id_pedido",
        "productos.foto_path",
        "productos.nombre",
        "detalle_pedidos.cantidad",
        "detalle_pedidos.importe"
      ],
      "pedidos.pendiente = 0 AND pedidos.cancelado = 0 AND pedidos.id_cliente = " . $this->id_cliente,
      null,
      "INNER JOIN detalle_pedidos ON pedidos.id_pedido = detalle_pedidos.id_pedido
      INNER JOIN productos ON detalle_pedidos.id_producto = productos.id_producto"
    );
  }

  public function loadPedidosCompletados()
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "pedidos",
      [
        "pedidos.id_pedido",
        "pedidos.fecha",
        "pedidos.hora",
        "pedidos.total"
      ],
      "estado_pedidos.estado = 'Completado' AND pedidos.pendiente = 0 AND pedidos.cancelado = 0 AND pedidos.id_cliente = " . $this->id_cliente,
      null,
      "INNER JOIN estado_pedidos ON pedidos.id_pedido = estado_pedidos.id_pedido"
    );
  }

  public function loadProductosPedidosCompletados()
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "pedidos",
      [
        "detalle_pedidos.id_pedido",
        "productos.foto_path",
        "productos.nombre",
        "detalle_pedidos.cantidad",
        "detalle_pedidos.importe"
      ],
      "estado_pedidos.estado = 'Completado' AND pedidos.pendiente = 0 AND pedidos.cancelado = 0 AND pedidos.id_cliente = " . $this->id_cliente,
      null,
      "INNER JOIN detalle_pedidos ON pedidos.id_pedido = detalle_pedidos.id_pedido
      INNER JOIN productos ON detalle_pedidos.id_producto = productos.id_producto
      INNER JOIN estado_pedidos ON pedidos.id_pedido = estado_pedidos.id_pedido"
    );
  }

  public function loadPedidosCancelados()
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "pedidos",
      [
        "pedidos.id_pedido",
        "pedidos.fecha",
        "pedidos.hora",
        "pedidos.total"
      ],
      "pedidos.cancelado = 1 AND pedidos.id_cliente = " . $this->id_cliente,
    );
  }

  public function loadProductosPedidosCancelados()
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "pedidos",
      [
        "detalle_pedidos.id_pedido",
        "productos.foto_path",
        "productos.nombre",
        "detalle_pedidos.cantidad",
        "detalle_pedidos.importe"
      ],
      "pedidos.cancelado = 1 AND pedidos.id_cliente = " . $this->id_cliente,
      null,
      "INNER JOIN detalle_pedidos ON pedidos.id_pedido = detalle_pedidos.id_pedido
      INNER JOIN productos ON detalle_pedidos.id_producto = productos.id_producto"
    );
  }
  public static function pedidoExiste($payment_id)
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "pedidos",
      ["COUNT(*) AS cantidad"],
      "mp_payment_id=$payment_id"
    )["cantidad"] > 0;
  }

  public static function crearPedido($id_cliente, $payment_id, $estado_pago)
  {
    $model = new Model();
    // Consulta al carrito del cliente
    $productos = CtrlCarrito::obtenerRegistros($id_cliente);
    $totalCarrito = CtrlCarrito::calcularTotalStatic($id_cliente);
    // INSERT en la tabla pedidos
    $lastInsertID = $model->agregaRegistroID(
      "pedidos",
      [
        "id_cliente",
        "fecha",
        "hora",
        "total",
        "mp_payment_id",
        "estado_pago",
        "pendiente",
        "cancelado"
      ],
      [
        $id_cliente,
        date("Y-m-d"),
        date("H:i:s"),
        $totalCarrito,
        $payment_id,
        $estado_pago,
        1,
        0
      ]
    );
    // INSERT a detalle_pedido
    foreach ($productos as $producto) {
      $model->agregaRegistro(
        "detalle_pedidos",
        [
          "id_pedido",
          "id_producto",
          "cantidad",
          "importe",
        ],
        [
          $lastInsertID,
          $producto['id_producto'],
          $producto["cantidad"],
          $producto["total"]
        ]
      );
    }
  }
}
