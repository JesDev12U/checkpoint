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
                <button class="btn-cancelar" title="Cancelar pedido">
                  <i class="fas fa-times-circle"></i> Cancelar pedido
                </button>
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
              <tr class="pedido-total-row">
                <td colspan="6" style="text-align:right;">Total pedido</td>
                <td>
                  <span class="monetario"><?= htmlspecialchars($pedido["total"]) ?></span>
                  <button class="btn-cancelar" title="Cancelar pedido">
                    <i class="fas fa-times-circle"></i> Cancelar pedido
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
            <tr class="pedido-total-row">
              <td colspan="6" style="text-align:right;">El empleado <?= $pedido['id_empleado'] ?> tomó tu pedido</td>
              <td>
                Estado: <?= $pedido['estado'] ?>
              </td>
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
                <button class="btn-cancelar" title="Cancelar pedido">
                  <i class="fas fa-times-circle"></i> Cancelar pedido
                </button>
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
                <button class="btn-cancelar" title="Cancelar pedido">
                  <i class="fas fa-times-circle"></i> Cancelar pedido
                </button>
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