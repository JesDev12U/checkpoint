<div class="container-name">
  <h1 id="title-name">¡Bienvenido <?php echo $_SESSION["datos"]["nombre"] ?>!</h1>
  <p>¿Qué desea realizar hoy?</p>
</div>
<div class="container" id="menu">
  <div class="row">
    <div class="col">
      <a href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_GESTOR_EMPLEADOS ?>">
        <img src="<?php echo SITE_URL ?>img/menu_icons/gestor_empleados.jpg" alt="Gestor de empleados">
        <p>Gestor de empleados</p>
      </a>
    </div>
    <div class="col">
      <a href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_GESTOR_CLIENTES ?>">
        <img src="<?php echo SITE_URL ?>img/menu_icons/gestor_clientes.jpg" alt="Gestor de clientes">
        <p>Gestor de clientes</p>
      </a>
    </div>
    <div class="col">
      <a href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_GESTOR_ADMINISTRADORES ?>">
        <img src="<?php echo SITE_URL ?>img/menu_icons/gestor_administradores.jpg" alt="Gestor de administradores">
        <p>Gestor de administradores</p>
      </a>
    </div>
    <div class="col">
      <a href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_GESTOR_VENTAS ?>">
        <img src="<?php echo SITE_URL ?>img/menu_icons/gestor_ventas.jpg" alt="Gestor de ventas">
        <p>Gestor de ventas</p>
      </a>
    </div>
    <div class="col">
      <a href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_CUENTA ?>">
        <img src="<?php echo SITE_URL ?>img/menu_icons/cuenta.jpg" alt="Configuración de la cuenta">
        <p>Configuración de la cuenta</p>
      </a>
    </div>
  </div>
</div>