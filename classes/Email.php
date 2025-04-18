<?php
require_once __DIR__ . "/../model/Model.php";
class Email
{
  public $email;

  public function __construct($email)
  {
    $this->email = $email;
  }

  public function existeEmail()
  {
    $model = new Model();
    return $model->seleccionaRegistros("administradores", ["email"], "email='$this->email'")
      || $model->seleccionaRegistros("empleados", ["email"], "email='$this->email'")
      || $model->seleccionaRegistros("clientes", ["email"], "email='$this->email'");
  }
}
