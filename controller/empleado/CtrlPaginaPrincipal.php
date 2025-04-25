<?php
class CtrlPaginaPrincipal
{
  const VISTA = __DIR__ . "/../../view/empleado/principal.php";
  const CSS = __DIR__ . "/../../css/empleado/principal.css";
  const JS = __DIR__ . "/../../js/empleado/principal.js";

  public $opciones = [
    ["nombre" => ICON_CUENTA, "href" => SITE_URL . RUTA_EMPLEADO . RUTA_CUENTA, "id" => "configuracion"],
  ];
  public $title = "Empleado";

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
}
