<?php
require_once __DIR__ . "/../../../model/Model.php";
require_once __DIR__ . "/../../../config/Global.php";
require_once __DIR__ . "/../../../classes/Email.php";

class CtrlGestorPedidos
{
  const VISTA = __DIR__ . "/../../../view/empleado/gestor_pedidos/gestor_pedidos.php";
  const CSS = __DIR__ . "/../../../css/empleado/gestor_pedidos.css";
  const JS = __DIR__ . "/../../../js/empleado/gestor_pedidos.js";
  public $model;
  public $opciones = [
    ["nombre" => ICON_HOME, "href" => SITE_URL . RUTA_EMPLEADO, "id" => "home"]
  ];
  public $title = "Pedidos";
  public $id_empleado;
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
    $this->id_empleado = $_SESSION["datos"]["id_empleado"];
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

  public function consultarEmailClienteByIdPedido($id_pedido)
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "pedidos",
      ["clientes.email"],
      "pedidos.id_pedido = $id_pedido",
      null,
      "INNER JOIN clientes ON pedidos.id_cliente = clientes.id_cliente"
    )[0]["email"];
  }

  public function tomarPedido($id_pedido)
  {
    $model = new Model();
    // Registro en estado_pedidos
    $estado_pedidosFlag = $model->agregaRegistroID(
      "estado_pedidos",
      [
        "id_pedido",
        "id_empleado",
        "estado"
      ],
      [
        $id_pedido,
        $this->id_empleado,
        "Pedido recién atendido."
      ]
    );
    // Cambio de flag 'pendiente' en pedidos
    $pedidosFlag = $model->modificaRegistro(
      "pedidos",
      ["pendiente"],
      "id_pedido=$id_pedido",
      [0]
    );

    $empleado = $model->seleccionaRegistros(
      "estado_pedidos",
      [
        "estado_pedidos.id_empleado",
        "empleados.nombre",
        "empleados.appat",
        "empleados.apmat"
      ],
      "estado_pedidos.id_pedido = $id_pedido",
      null,
      "INNER JOIN empleados ON estado_pedidos.id_empleado = empleados.id_empleado"
    )[0];

    // Notificar al cliente via EMAIL
    $Email = new Email(self::consultarEmailClienteByIdPedido($id_pedido));
    $Email->notificarPedidoAtendido($id_pedido, $empleado);

    return $estado_pedidosFlag == 0 && $pedidosFlag;
  }

  public function actualizarEstadoPedido($id_pedido, $estado)
  {
    $model = new Model();
    if ($estado !== "Completado") {
      // Notificar al cliente via EMAIL
      $Email = new Email(self::consultarEmailClienteByIdPedido($id_pedido));
      $Email->notificarActualizacionPedido($id_pedido, $estado);
      return $model->modificaRegistro(
        "estado_pedidos",
        ["estado"],
        "id_pedido=$id_pedido",
        [$estado]
      );
    } else {
      // Actualizar estado
      $actualizacionFlag = $model->modificaRegistro(
        "estado_pedidos",
        ["estado"],
        "id_pedido=$id_pedido",
        [$estado]
      );
      // Consultar productos del pedido para pasarlo a ventas
      $productos = $model->seleccionaRegistros(
        "detalle_pedidos",
        [
          "id_producto",
          "cantidad",
          "importe"
        ],
        "id_pedido=$id_pedido"
      );
      $pedido = $model->seleccionaRegistros(
        "pedidos",
        [
          "id_cliente",
          "total"
        ],
        "id_pedido=$id_pedido"
      )[0];
      // Pasar el pedido a ventas
      $id_venta = $model->agregaRegistroID(
        "ventas",
        [
          "id_empleado",
          "id_cliente",
          "fecha",
          "hora",
          "total",
        ],
        [
          $this->id_empleado,
          $pedido["id_cliente"],
          date("Y-m-d"),
          date("H:i:s"),
          $pedido["total"]
        ]
      );
      foreach ($productos as $producto) {
        $model->agregaRegistroID(
          "detalle_venta",
          [
            "id_venta",
            "id_producto",
            "cantidad",
            "importe",
          ],
          [
            $id_venta,
            $producto["id_producto"],
            $producto["cantidad"],
            $producto["importe"]
          ]
        );
      }
      // Notificar al cliente via EMAIL
      $Email = new Email(self::consultarEmailClienteByIdPedido($id_pedido));
      $Email->notificarPedidoCompletado($id_pedido);
      return $id_venta > 0 && $actualizacionFlag;
    }
  }

  public static function cancelarPedido($id_pedido)
  {
    $model = new Model();
    // Notificar al cliente via EMAIL
    $email = $model->seleccionaRegistros(
      "pedidos",
      ["clientes.email"],
      "pedidos.id_pedido = $id_pedido",
      null,
      "INNER JOIN clientes ON pedidos.id_cliente = clientes.id_cliente"
    )[0]["email"];
    $Email = new Email($email);
    $Email->notificarPedidoCancelado($id_pedido);
    return $model->modificaRegistro(
      "pedidos",
      ["cancelado"],
      "id_pedido=$id_pedido",
      [1]
    );
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
        "pedidos.total",
        "clientes.codigo_postal",
        "clientes.estado_domicilio",
        "clientes.alc_mun",
        "clientes.colonia",
        "clientes.calle",
        "clientes.no_ext",
        "clientes.no_int"
      ],
      "pedidos.pendiente = 1 AND pedidos.cancelado = 0",
      null,
      "INNER JOIN clientes ON pedidos.id_cliente = clientes.id_cliente"
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
      "pedidos.pendiente = 1 AND pedidos.cancelado = 0",
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
        "estado_pedidos.estado",
        "clientes.codigo_postal",
        "clientes.estado_domicilio",
        "clientes.alc_mun",
        "clientes.colonia",
        "clientes.calle",
        "clientes.no_ext",
        "clientes.no_int"
      ],
      "estado_pedidos.estado <> 'Completado' AND pedidos.pendiente = 0 AND pedidos.cancelado = 0 AND estado_pedidos.id_empleado = " . $this->id_empleado,
      null,
      "INNER JOIN estado_pedidos ON pedidos.id_pedido = estado_pedidos.id_pedido
      INNER JOIN clientes ON pedidos.id_cliente = clientes.id_cliente"
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
      "estado_pedidos.estado <> 'Completado' AND pedidos.pendiente = 0 AND pedidos.cancelado = 0 AND estado_pedidos.id_empleado = " . $this->id_empleado,
      null,
      "INNER JOIN detalle_pedidos ON pedidos.id_pedido = detalle_pedidos.id_pedido
      INNER JOIN productos ON detalle_pedidos.id_producto = productos.id_producto
      INNER JOIN estado_pedidos ON pedidos.id_pedido = estado_pedidos.id_pedido"
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
        "pedidos.total",
        "clientes.codigo_postal",
        "clientes.estado_domicilio",
        "clientes.alc_mun",
        "clientes.colonia",
        "clientes.calle",
        "clientes.no_ext",
        "clientes.no_int"
      ],
      "estado_pedidos.estado = 'Completado' AND pedidos.pendiente = 0 AND pedidos.cancelado = 0 AND estado_pedidos.id_empleado = " . $this->id_empleado,
      null,
      "INNER JOIN estado_pedidos ON pedidos.id_pedido = estado_pedidos.id_pedido
      INNER JOIN clientes ON pedidos.id_cliente = clientes.id_cliente"
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
      "estado_pedidos.estado = 'Completado' AND pedidos.pendiente = 0 AND pedidos.cancelado = 0 AND estado_pedidos.id_empleado = " . $this->id_empleado,
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
        "pedidos.total",
        "clientes.codigo_postal",
        "clientes.estado_domicilio",
        "clientes.alc_mun",
        "clientes.colonia",
        "clientes.calle",
        "clientes.no_ext",
        "clientes.no_int"
      ],
      "pedidos.cancelado = 1",
      null,
      "INNER JOIN clientes ON pedidos.id_cliente = clientes.id_cliente"
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
      "pedidos.cancelado = 1",
      null,
      "INNER JOIN detalle_pedidos ON pedidos.id_pedido = detalle_pedidos.id_pedido
      INNER JOIN productos ON detalle_pedidos.id_producto = productos.id_producto"
    );
  }
}
