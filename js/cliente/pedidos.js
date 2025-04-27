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
            (location.href = `${this.dataset.url}${this.dataset.url_pedidos}`),
          2000
        );
      }
    );
  });
});
