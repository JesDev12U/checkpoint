<?php

/**
 * Renderiza una tabla de productos de forma dinámica.
 * @param array $productos Array de productos a mostrar.
 */
function renderTablaProductos($productos)
{
  // Usar las constantes globales para la ruta de modificar producto
  $ruta_modificar = SITE_URL . RUTA_EMPLEADO . RUTA_MTO_PRODUCTOS;

  if (empty($productos)) {
    echo '<div class="alert alert-info">No hay productos para mostrar.</div>';
    return;
  }
?>
  <table class="tblDatos table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Foto</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Cantidad (stock)</th>
        <th>Descripción</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($productos as $reg): ?>
        <tr>
          <td><?php echo htmlspecialchars($reg["id_producto"]) ?></td>
          <td>
            <?php if (!empty($reg["foto_path"])): ?>
              <img src="<?php echo htmlspecialchars($reg["foto_path"]) ?>" alt="Foto del producto" style="max-width:60px;max-height:60px;">
            <?php else: ?>
              <span class="text-muted">Sin foto</span>
            <?php endif; ?>
          </td>
          <td><?php echo htmlspecialchars($reg["nombre"]) ?></td>
          <td><?php echo htmlspecialchars($reg["precio"]) ?></td>
          <td><?php echo htmlspecialchars($reg["cantidad"]) ?></td>
          <td><?php echo htmlspecialchars($reg["descripcion"]) ?></td>
          <td>
            <a class="btn btn-warning" href="<?php echo $ruta_modificar . $reg["id_producto"] ?>">
              <i class="fas fa-pen"></i>
              Modificar
            </a>
            <?php if (!empty($reg["estado"])): ?>
              <button class="btn btn-danger" id="btn-deshabilitar" data-url="<?php echo SITE_URL ?>" data-usuario="producto" data-id="<?php echo $reg["id_producto"] ?>">
                <i class="fa-solid fa-ban"></i>
                Deshabilitar
              </button>
            <?php else: ?>
              <button class="btn btn-success" id="btn-habilitar" data-url="<?php echo SITE_URL ?>" data-usuario="producto" data-id="<?php echo $reg["id_producto"] ?>">
                <i class="fa-solid fa-check"></i>
                Habilitar
              </button>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
<?php
}
?>