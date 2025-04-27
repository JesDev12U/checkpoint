// Tab switching logic
document.querySelectorAll(".tab").forEach((tab) => {
  tab.addEventListener("click", function () {
    document
      .querySelectorAll(".tab")
      .forEach((t) => t.classList.remove("active"));
    document
      .querySelectorAll(".tab-content")
      .forEach((tc) => tc.classList.remove("active"));
    this.classList.add("active");
    document
      .querySelector(".tab-content." + this.dataset.tab)
      .classList.add("active");
  });
});

document.querySelectorAll(".btn-tomar-pedido").forEach((btn) => {
  btn.addEventListener("click", async function (e) {
    e.preventDefault();
    asyncConfirmProcess(
      JSON.stringify({
        id_pedido: this.dataset.id_pedido,
        operacion: "tomar_pedido",
      }),
      `${this.dataset.url}/controller/empleado/gestor_pedidos/AsyncPedidos.php`,
      "Advertencia",
      "¿Está seguro de tomar este pedido?",
      "Éxito",
      (_) => {
        setTimeout(
          () =>
            (location.href = `${this.dataset.url}${this.dataset.url_gestor_pedidos}`),
          2000
        );
      }
    );
  });
});

document.querySelectorAll(".btn-actualizar-estado").forEach((btn) => {
  btn.addEventListener("click", function (e) {
    e.preventDefault();
    const $select = document.getElementById(
      `pedidos-atendidos-${this.dataset.id_pedido}`
    );
    asyncConfirmProcess(
      JSON.stringify({
        id_pedido: this.dataset.id_pedido,
        estado: $select.value,
        operacion: "actualizar_estado",
      }),
      `${this.dataset.url}/controller/empleado/gestor_pedidos/AsyncPedidos.php`,
      "Advertencia",
      "¿Está seguro de actualizar el estado de este pedido?",
      "Éxito",
      (_) => {
        setTimeout(
          () =>
            (location.href = `${this.dataset.url}${this.dataset.url_gestor_pedidos}`),
          2000
        );
      }
    );
  });
});

document.querySelectorAll(".btn-cancelar").forEach((btn) => {
  btn.addEventListener("click", function (e) {
    e.preventDefault();
    asyncConfirmProcess(
      JSON.stringify({
        id_pedido: this.dataset.id_pedido,
        operacion: "cancelar_pedido",
      }),
      `${this.dataset.url}/controller/empleado/gestor_pedidos/AsyncPedidos.php`,
      "Advertencia",
      "¿Está seguro de cancelar este pedido?",
      "Éxito",
      (_) => {
        setTimeout(
          () =>
            (location.href = `${this.dataset.url}${this.dataset.url_gestor_pedidos}`),
          2000
        );
      }
    );
  });
});
