<h2>¡Gracias por su compra!</h2>
<p>¡Su pedido <?= $id_pedido ?> se ha creado exitosamente!</p>
<p>Su pedido tiene un estado <span id="text-status">PENDIENTE</span>, es decir, debe esperar a que uno de nuestros empleados atienda su pedido</p>
<p>¡Tranquilo, te notificaremos cuando tu pedido sea atendido!</p>
<h3>Ticket de compra</h3>
<table class="ticket-table">
  <thead>
    <tr>
      <th>Imagen</th>
      <th>Producto</th>
      <th>Cantidad</th>
      <th>Importe</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total = 0;
    foreach ($ticket as $item):
      $total += $item['importe'] * $item['cantidad'];
    ?>
      <tr>
        <td>
          <img src="cid:<?= htmlspecialchars($item['cid']) ?>" alt="Imagen producto" class="ticket-img">
        </td>
        <td><?= htmlspecialchars($item['nombre']) ?></td>
        <td><?= (int)$item['cantidad'] ?></td>
        <td>$<?= number_format($item['importe'], 2) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<div class="ticket-total">
  Total: $<?= number_format($total, 2) ?>
</div>