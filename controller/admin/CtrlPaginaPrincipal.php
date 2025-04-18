<?php
class CtrlPaginaPrincipal
{
  const VISTA = __DIR__ . "/../../view/admin/principal.php";
  const CSS = __DIR__ . "/../../css/admin/principal.css";
  const JS = __DIR__ . "/../../js/admin/principal.js";

  public $opciones = [
    ["nombre" => ICON_CERRAR_SESION, "href" => SITE_URL . RUTA_CERRAR_SESION, "id" => "cerrar-sesion"]
  ];
  public $title = "Administrador";

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
