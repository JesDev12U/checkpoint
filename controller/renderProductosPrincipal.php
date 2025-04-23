<?php

/**
 * Renderiza los productos para la página principal de forma dinámica.
 * @param array $productos Array de productos a mostrar.
 */

function renderProductosPrincipal($productos)
{
  $count = 0;
  if (empty($productos)) {
    echo '<div class="alert alert-info">No hay productos para mostrar.</div>';
    return;
  }
?>
  <div class="row g-4">
    <?php foreach ($productos as $reg): ?>
      <?php if ($reg["estado"]): ?>
        <?php $count++ ?>
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card minecraft-card h-100">
            <img src="<?php echo htmlspecialchars($reg["foto_path"]) ?>" class="card-img-top product-img" alt="Minecraft PS5">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title" style="color:#3e5c14;"><?php echo htmlspecialchars($reg["nombre"]) ?></h5>
              <p class="card-text mb-2"><?php echo htmlspecialchars($reg["descripcion"]) ?></p>
              <div class="mt-auto">
                <span class="fw-bold" style="color:#5e8c31;"><?php echo "$" . htmlspecialchars($reg["precio"]) . " MXN" ?></span>
                <button class="btn minecraft-btn btn-sm float-end">
                  <img src="https://cdn-icons-png.flaticon.com/512/1170/1170678.png" class="cart-icon" alt="Carrito">Añadir al carrito
                </button>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
  <?php
  if ($count === 0)
    echo '<div class="alert alert-info">No hay productos para mostrar.</div>';
  ?>
<?php
}
?>