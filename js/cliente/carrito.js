/**
 * Función para actualizar el botón de MercadoPago con la preferencia actualizada
 */
async function actualizarBotonMercadoPago() {
  const $walletContainer = document.getElementById("wallet_container");
  const response = await fetch(
    `${$walletContainer.dataset.url}controller/actualizarBtnMercadoPago.php`
  );
  const data = await response.json();
  if (data.preferenceId) {
    $walletContainer.innerHTML = "";
    const mp = new MercadoPago($walletContainer.dataset.mp_public_key, {
      locale: "es-MX",
    });
    mp.bricks().create("wallet", "wallet_container", {
      initialization: {
        preferenceId: data.preferenceId,
        redirectMode: "redirect", // Cambiado de "modal" a "redirect"
      },
      customization: {
        theme: "dark",
      },
    });
  } else {
    console.error(
      "Error al actualizar MercadoPago:",
      data.error || "Desconocido"
    );
  }
}

/**
 * Detecta el estado del pago en la URL y muestra el SweetAlert correspondiente.
 * Limpia el parámetro de la URL después de mostrar el mensaje.
 */
function mostrarAlertaEstadoPago() {
  const urlParams = new URLSearchParams(window.location.search);
  const estadoPago = urlParams.get("estado_pago");

  if (estadoPago === "success") {
    Swal.fire({
      icon: "success",
      title: "¡Pago realizado!",
      text: "Tu pago fue aprobado correctamente.",
    });
  } else if (estadoPago === "failure") {
    Swal.fire({
      icon: "error",
      title: "Pago rechazado",
      text: "Tu pago fue rechazado. Intenta nuevamente.",
    });
  } else if (estadoPago === "pending") {
    Swal.fire({
      icon: "info",
      title: "Pago pendiente",
      text: "Tu pago está pendiente de confirmación.",
    });
  }

  // Limpia el parámetro de la URL para evitar mostrar la alerta al recargar
  if (estadoPago) {
    urlParams.delete("estado_pago");
    const newUrl =
      window.location.pathname +
      (urlParams.toString() ? "?" + urlParams.toString() : "");
    window.history.replaceState({}, document.title, newUrl);
  }
}

async function actualizarCantidad(
  nuevaCantidad,
  id_producto,
  url,
  cbActualizarFrontend
) {
  try {
    aparecerLoader();
    const res = await fetch(
      `${url}/controller/cliente/carrito/AsyncActualizarCantidad.php`,
      {
        method: "POST",
        body: JSON.stringify({
          nuevaCantidad,
          id_producto,
        }),
      }
    );
    if (!res.ok) {
      throw new Error("Error para actualizar la cantidad del producto");
    }
    const json = await res.json();
    if (json.result !== 1) {
      desaparecerLoader();
      Swal.fire({
        icon: "error",
        title: "Error",
        text: json.msg,
      });
    } else {
      // Actualizar frontend
      cbActualizarFrontend(json);
      const $totalCompra = document.getElementById("total-compra");
      $totalCompra.textContent = formatearMXN(json.total);
      // Actualizar MercadoPago
      actualizarBotonMercadoPago();
      desaparecerLoader();
    }
  } catch (err) {
    desaparecerLoader();
    console.error(err);
    Swal.fire({
      icon: "error",
      title: "Error",
      text: err,
    });
  }
}

document.querySelectorAll(".btn-menos").forEach((btn) => {
  btn.addEventListener("click", () => {
    const $inputCantidad = document.getElementById(
      `input-cantidad${btn.dataset.id_producto}`
    );
    const $subtotal = document.getElementById(
      `subtotal${btn.dataset.id_producto}`
    );
    let nuevaCantidad = Number($inputCantidad.value) - 1;
    if (nuevaCantidad <= 0) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Cantidad inválida",
      });
      return;
    }
    actualizarCantidad(
      nuevaCantidad,
      btn.dataset.id_producto,
      btn.dataset.url,
      (json) => {
        $inputCantidad.value = json.producto.cantidad;
        $subtotal.textContent = formatearMXN(json.producto.total);
      }
    );
  });
});

document.querySelectorAll(".btn-mas").forEach((btn) => {
  btn.addEventListener("click", () => {
    const $inputCantidad = document.getElementById(
      `input-cantidad${btn.dataset.id_producto}`
    );
    const $subtotal = document.getElementById(
      `subtotal${btn.dataset.id_producto}`
    );
    let nuevaCantidad = Number($inputCantidad.value) + 1;
    if (nuevaCantidad <= 0) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Cantidad inválida",
      });
      return;
    }
    actualizarCantidad(
      nuevaCantidad,
      btn.dataset.id_producto,
      btn.dataset.url,
      (json) => {
        $inputCantidad.value = json.producto.cantidad;
        $subtotal.textContent = formatearMXN(json.producto.total);
      }
    );
  });
});

document.querySelectorAll(".btn-eliminar").forEach((btn) => {
  btn.addEventListener("click", async () => {
    asyncConfirmProcess(
      JSON.stringify({ id_producto: btn.dataset.id_producto }),
      `${btn.dataset.url}/controller/cliente/carrito/AsyncEliminarProducto.php`,
      "Eliminar producto",
      "¿Desea eliminar este producto de su carrito?",
      "¡Producto eliminado del carrito correctamente!",
      (json) => {
        if (!json.total) {
          document.querySelector(
            ".row"
          ).innerHTML = `<div class="alert alert-info">No hay productos para mostrar.</div>`;
        } else {
          tblDatos.row(btn.dataset.ordinal).remove().draw();
          const $totalCompra = document.getElementById("total-compra");
          $totalCompra.textContent = formatearMXN(json.total);
        }
        // Actualizar MercadoPago
        actualizarBotonMercadoPago();
      }
    );
  });
});

document.addEventListener("DOMContentLoaded", () => {
  mostrarAlertaEstadoPago(); // Mostrar alerta según el estado de pago en la URL
  actualizarBotonMercadoPago();
});
