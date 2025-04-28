<div class="container-name">
  <h1 id="title-name">¡Bienvenido <?php echo $_SESSION["datos"]["nombre"] ?>!</h1>
  <p>¿Qué desea realizar hoy?</p>
</div>
<div class="container" id="menu">
  <div class="row">
    <div class="col">
      <a href="<?php echo SITE_URL . RUTA_EMPLEADO . RUTA_GESTOR_PRODUCTOS ?>">
        <img src="<?php echo SITE_URL ?>img/menu_icons/gestor_productos.jpg" alt="Gestor de productos">
        <p>Gestor de productos</p>
      </a>
    </div>
    <div class="col">
      <a href="<?php echo SITE_URL . RUTA_EMPLEADO . RUTA_GESTOR_PEDIDOS ?>">
        <img src="<?php echo SITE_URL ?>img/menu_icons/gestor_pedidos.jpg" alt="Gestor de productos">
        <p>Gestor de pedidos</p>
      </a>
    </div>
    <div class="col">
      <a href="<?php echo SITE_URL . RUTA_EMPLEADO . RUTA_CUENTA ?>">
        <img src="<?php echo SITE_URL ?>img/menu_icons/cuenta.jpg" alt="Configuración de la cuenta">
        <p>Configuración de la cuenta</p>
      </a>
    </div>
  </div>
</div>