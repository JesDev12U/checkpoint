<a href="<?php echo SITE_URL ?>" class="btn btn-primary" style="margin-bottom: 50px">
  <i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar a la página principal
</a>
<h1 style="margin: 32px 0 16px 0; text-align:center;">Pedidos</h1>
<div class="tabs" id="tabs">
  <button class="tab active" data-tab="pendientes">Pendientes</button>
  <button class="tab" data-tab="atendidos">Atendidos</button>
  <button class="tab" data-tab="completados">Completados</button>
  <button class="tab" data-tab="cancelados">Cancelados</button>
</div>

<div class="tab-content pendientes active">
  <div class="estado-title">Pendientes</div>
  <?php if (count($this->pedidosPendientes) !== 0): ?>
    <div class="table-responsive">
      <table class="modern-table">
        <thead>
          <tr>
            <th>ID Pedido</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Foto</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->pedidosPendientes as $pedido): ?>
            <?php
            // Filtra los productos de este pedido
            $productos = array_filter($this->productosPedidosPendientes, function ($producto) use ($pedido) {
              return $producto['id_pedido'] == $pedido['id_pedido'];
            });
            $rowspan = count($productos);
            $first = true;
            ?>
            <?php foreach ($productos as $producto): ?>
              <tr>
                <?php if ($first): ?>
                  <td rowspan="<?= $rowspan ?>"><?= $pedido["id_pedido"] ?></td>
                  <td rowspan="<?= $rowspan ?>"><?= $pedido["fecha"] ?></td>
                  <td rowspan="<?= $rowspan ?>"><?= $pedido["hora"] ?></td>
                <?php endif; ?>
                <td>
                  <img class="foto-producto" src="<?= htmlspecialchars($producto["foto_path"]) ?>" alt="<?= htmlspecialchars($producto["nombre"]) ?>">
                </td>
                <td><?= htmlspecialchars($producto["nombre"]) ?></td>
                <td><?= htmlspecialchars($producto["cantidad"]) ?></td>
                <td class="monetario"><?= htmlspecialchars($producto["importe"]) ?></td>
              </tr>
              <?php $first = false; ?>
            <?php endforeach; ?>
            <tr class="pedido-total-row">
              <td colspan="6" style="text-align:right;">Total pedido</td>
              <td>
                <span class="monetario"><?= htmlspecialchars($pedido["total"]) ?></span>
                <button
                  class="btn-tomar-pedido"
                  data-url="<?= SITE_URL ?>"
                  data-url_gestor_pedidos="<?= RUTA_EMPLEADO . RUTA_GESTOR_PEDIDOS ?>"
                  data-id_pedido="<?= $pedido["id_pedido"] ?>"
                  title="Tomar pedido">
                  <i class="fa-solid fa-check"></i> Tomar pedido
                </button>
                <button
                  data-url="<?= SITE_URL ?>"
                  data-url_gestor_pedidos="<?= RUTA_EMPLEADO . RUTA_GESTOR_PEDIDOS ?>"
                  data-id_pedido="<?= $pedido["id_pedido"] ?>"
                  class="btn-cancelar"
                  title="Cancelar pedido">
                  <i class="fas fa-times-circle"></i> Cancelar pedido
                </button>
              </td>
            </tr>
            <tr class="pedido-total-row">
              <td colspan="6" style="text-align:right;">Entregar en:</td>
              <td><?=
                  $pedido["codigo_postal"]
                    . " - "
                    . $pedido["calle"]
                    . " "
                    . $pedido["no_ext"]
                    . " "
                    . $pedido["no_int"]
                    . ", "
                    . $pedido["colonia"]
                    . ", "
                    . $pedido["alc_mun"]
                    . ", "
                    . $pedido["estado_domicilio"]
                  ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No hay productos para mostrar.</div>
  <?php endif ?>
</div>
<div class="tab-content atendidos">
  <div class="estado-title">Atendidos</div>
  <?php if (count($this->pedidosAtendidos) !== 0): ?>
    <div class="table-responsive">
      <table class="modern-table">
        <thead>
          <tr>
            <th>ID Pedido</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Foto</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->pedidosAtendidos as $pedido): ?>
            <?php
            // Filtra los productos de este pedido  
            $productos = array_filter($this->productosPedidosAtendidos, function ($producto) use ($pedido) {
              return $producto['id_pedido'] == $pedido['id_pedido'];
            });
            $rowspan = count($productos);
            $first = true;
            ?>
            <?php foreach ($productos as $producto): ?>
              <tr>
                <?php if ($first): ?>
                  <td rowspan="<?= $rowspan ?>"><?= $pedido["id_pedido"] ?></td>
                  <td rowspan="<?= $rowspan ?>"><?= $pedido["fecha"] ?></td>
                  <td rowspan="<?= $rowspan ?>"><?= $pedido["hora"] ?></td>
                <?php endif; ?>
                <td>
                  <img class="foto-producto" src="<?= htmlspecialchars($producto["foto_path"]) ?>" alt="<?= htmlspecialchars($producto["nombre"]) ?>">
                </td>
                <td><?= htmlspecialchars($producto["nombre"]) ?></td>
                <td><?= htmlspecialchars($producto["cantidad"]) ?></td>
                <td class="monetario"><?= htmlspecialchars($producto["importe"]) ?></td>
              </tr>
              <?php $first = false; ?>
            <?php endforeach; ?>
            <tr class="pedido-total-row">
              <td colspan="6" style="text-align:right;">Total pedido</td>
              <td>
                <span class="monetario"><?= htmlspecialchars($pedido["total"]) ?></span>
                <button
                  class="btn-cancelar"
                  title="Cancelar pedido"
                  data-url="<?= SITE_URL ?>"
                  data-url_gestor_pedidos="<?= RUTA_EMPLEADO . RUTA_GESTOR_PEDIDOS ?>"
                  data-id_pedido="<?= $pedido["id_pedido"] ?>">
                  <i class="fas fa-times-circle"></i> Cancelar pedido
                </button>
              </td>
            </tr>
            <tr class="pedido-total-row">
              <td colspan="6" style="text-align:right;">Estado</td>
              <td>
                <select name="estado" id="pedidos-atendidos-<?= $pedido["id_pedido"] ?>">
                  <option value="Pedido recién atendido" <?= $pedido['estado'] == "Pedido recién atendido" ? "selected" : "" ?>>Pedido recién atendido</option>
                  <option value="Procesando y empaquetando" <?= $pedido['estado'] == "Procesando y empaquetando" ? "selected" : "" ?>>Procesando y empaquetando</option>
                  <option value="En camino" <?= $pedido['estado'] == "En camino" ? "selected" : "" ?>>En camino</option>
                  <option value="Completado">Completado</option>
                </select>
                <button
                  data-url="<?= SITE_URL ?>"
                  data-id_pedido="<?= $pedido["id_pedido"] ?>"
                  class="btn-actualizar-estado"
                  title="Actualizar estado"
                  data-url_gestor_pedidos="<?= RUTA_EMPLEADO . RUTA_GESTOR_PEDIDOS ?>">
                  <i class="fa-solid fa-pencil"></i> Actualizar estado
                </button>
              </td>
            </tr>
            <tr class="pedido-total-row">
              <td colspan="6" style="text-align:right;">Entregar en:</td>
              <td><?=
                  $pedido["codigo_postal"]
                    . " - "
                    . $pedido["calle"]
                    . " "
                    . $pedido["no_ext"]
                    . " "
                    . $pedido["no_int"]
                    . ", "
                    . $pedido["colonia"]
                    . ", "
                    . $pedido["alc_mun"]
                    . ", "
                    . $pedido["estado_domicilio"]
                  ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No hay productos para mostrar.</div>
  <?php endif ?>
</div>
<div class="tab-content completados">
  <div class="estado-title">Completados</div>
  <?php if (count($this->pedidosCompletados) !== 0): ?>
    <div class="table-responsive">
      <table class="modern-table">
        <thead>
          <tr>
            <th>ID Pedido</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Foto</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->pedidosCompletados as $pedido): ?>
            <?php
            // Filtra los productos de este pedido
            $productos = array_filter($this->productosPedidosCompletados, function ($producto) use ($pedido) {
              return $producto['id_pedido'] == $pedido['id_pedido'];
            });
            $rowspan = count($productos);
            $first = true;
            ?>
            <?php foreach ($productos as $producto): ?>
              <tr>
                <?php if ($first): ?>
                  <td rowspan="<?= $rowspan ?>"><?= $pedido["id_pedido"] ?></td>
                  <td rowspan="<?= $rowspan ?>"><?= $pedido["fecha"] ?></td>
                  <td rowspan="<?= $rowspan ?>"><?= $pedido["hora"] ?></td>
                <?php endif; ?>
                <td>
                  <img class="foto-producto" src="<?= htmlspecialchars($producto["foto_path"]) ?>" alt="<?= htmlspecialchars($producto["nombre"]) ?>">
                </td>
                <td><?= htmlspecialchars($producto["nombre"]) ?></td>
                <td><?= htmlspecialchars($producto["cantidad"]) ?></td>
                <td class="monetario"><?= htmlspecialchars($producto["importe"]) ?></td>
              </tr>
              <?php $first = false; ?>
            <?php endforeach; ?>
            <tr class="pedido-total-row">
              <td colspan="6" style="text-align:right;">Total pedido</td>
              <td>
                <span class="monetario"><?= htmlspecialchars($pedido["total"]) ?></span>
              </td>
            </tr>
            <tr class="pedido-total-row">
              <td colspan="6" style="text-align:right;">Entregado en:</td>
              <td><?=
                  $pedido["codigo_postal"]
                    . " - "
                    . $pedido["calle"]
                    . " "
                    . $pedido["no_ext"]
                    . " "
                    . $pedido["no_int"]
                    . ", "
                    . $pedido["colonia"]
                    . ", "
                    . $pedido["alc_mun"]
                    . ", "
                    . $pedido["estado_domicilio"]
                  ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No hay productos para mostrar.</div>
  <?php endif ?>
</div>
<div class="tab-content cancelados">
  <div class="estado-title">Cancelados</div>
  <?php if (count($this->pedidosCancelados) !== 0): ?>
    <div class="table-responsive">
      <table class="modern-table">
        <thead>
          <tr>
            <th>ID Pedido</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Foto</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->pedidosCancelados as $pedido): ?>
            <?php
            // Filtra los productos de este pedido
            $productos = array_filter($this->productosPedidosCancelados, function ($producto) use ($pedido) {
              return $producto['id_pedido'] == $pedido['id_pedido'];
            });
            $rowspan = count($productos);
            $first = true;
            ?>
            <?php foreach ($productos as $producto): ?>
              <tr>
                <?php if ($first): ?>
                  <td rowspan="<?= $rowspan ?>"><?= $pedido["id_pedido"] ?></td>
                  <td rowspan="<?= $rowspan ?>"><?= $pedido["fecha"] ?></td>
                  <td rowspan="<?= $rowspan ?>"><?= $pedido["hora"] ?></td>
                <?php endif; ?>
                <td>
                  <img class="foto-producto" src="<?= htmlspecialchars($producto["foto_path"]) ?>" alt="<?= htmlspecialchars($producto["nombre"]) ?>">
                </td>
                <td><?= htmlspecialchars($producto["nombre"]) ?></td>
                <td><?= htmlspecialchars($producto["cantidad"]) ?></td>
                <td class="monetario"><?= htmlspecialchars($producto["importe"]) ?></td>
              </tr>
              <?php $first = false; ?>
            <?php endforeach; ?>
            <tr class="pedido-total-row">
              <td colspan="6" style="text-align:right;">Total pedido</td>
              <td>
                <span class="monetario"><?= htmlspecialchars($pedido["total"]) ?></span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No hay productos para mostrar.</div>
  <?php endif ?>
</div>