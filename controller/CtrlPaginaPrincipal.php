<?php
require_once __DIR__ . "/../model/Model.php";
class CtrlPaginaPrincipal
{
  private $vista = __DIR__ . "/../view/principal.php";
  private $css = __DIR__ . "/../css/principal.css";
  private $js = __DIR__ . "/../js/principal.js";
  public $model;
  public $opciones = [
    ["nombre" => ICON_PEDIDOS, "href" => "#", "id" => "pedidos"],
    ["nombre" => ICON_HISTORIAL_COMPRAS, "href" => "#", "id" => "historial-compras"],
    ["nombre" => ICON_CARRITO, "href" => "#", "id" => "carrito"],
    ["nombre" => ICON_INICIAR_SESION, "href" => SITE_URL . "login", "id" => "login"]
  ];
  public $title = "Principal";

  public function renderContent()
  {
    include $this->vista;
  }

  public function renderCSS()
  {
    include $this->css;
  }

  public function renderJS()
  {
    include $this->js;
  }
}
