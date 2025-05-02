document.addEventListener("DOMContentLoaded", function () {
  var navbarCollapse = document.querySelector(".navbar-collapse");
  if (!navbarCollapse) return;

  navbarCollapse.addEventListener("show.bs.collapse", function () {
    document.body.classList.add("mainnav-open");
  });
  navbarCollapse.addEventListener("hide.bs.collapse", function () {
    document.body.classList.remove("mainnav-open");
  });
});

const $dropdownItem = document.querySelectorAll(".dropdown-item");

$dropdownItem.forEach((link) => {
  link.addEventListener("click", function (e) {
    {
      e.preventDefault();
      const targetId = this.getAttribute("href").substring(1);
      const targetElement = document.getElementById(targetId);
      const offset = 200;
      const elementPosition = targetElement.getBoundingClientRect().top;
      const offsetPosition = elementPosition - offset;

      window.scrollBy({
        top: offsetPosition,
        behavior: "smooth",
      });
    }
  });
});

// Abrir el modal al hacer click en la barra o el botón de búsqueda
document.getElementById("mainSearchBar").addEventListener("click", function () {
  var modal = new bootstrap.Modal(document.getElementById("searchModal"));
  modal.show();
  setTimeout(() => document.getElementById("modalSearchInput").focus(), 500);
});
document
  .getElementById("openSearchModalBtn")
  .addEventListener("click", function () {
    var modal = new bootstrap.Modal(document.getElementById("searchModal"));
    modal.show();
    setTimeout(() => document.getElementById("modalSearchInput").focus(), 500);
  });

// Lógica para mostrar resultados de búsqueda
document
  .getElementById("modalSearchBtn")
  .addEventListener("click", async function () {
    const query = document.getElementById("modalSearchInput").value.trim();
    const resultsDiv = document.getElementById("searchResults");
    resultsDiv.innerHTML = "";
    if (query.length === 0) {
      resultsDiv.innerHTML =
        '<div class="alert alert-info">Escribe algo para buscar productos.</div>';
      return;
    }
    // Petición AJAX
    try {
      const res = await fetch(
        `${this.dataset.url}controller/AsyncBusquedaProductos.php`,
        {
          method: "POST",
          body: JSON.stringify({ query }),
        }
      );
      if (!res.ok) {
        resultsDiv.innerHTML = `
        <div class="col-12">
          <div class="alert alert-secondary">Error con la petición al servidor</div>
        </div>
      `;
      }
      const text = await res.text();
      resultsDiv.innerHTML = `
      <div class="col-12">
        <div class="alert alert-secondary">Resultados de búsqueda para: <strong>${query}</strong></div>
        </div>
        ${text}
      `;
      loadEventAddCart();
      loadFormatearMXN();
    } catch (err) {
      resultsDiv.innerHTML = `
      <div class="col-12">
        <div class="alert alert-secondary">Error: ${err}</div>
      </div>
    `;
    }
  });

// Permitir buscar con Enter
document
  .getElementById("modalSearchInput")
  .addEventListener("keydown", function (e) {
    if (e.key === "Enter") {
      document.getElementById("modalSearchBtn").click();
    }
  });

function loadEventAddCart() {
  document.querySelectorAll(".btn-addcart").forEach((btn) => {
    btn.addEventListener("click", async () => {
      try {
        aparecerLoader();
        const res = await fetch(
          `${btn.dataset.url}/controller/cliente/carrito/AsyncAddCarrito.php`,
          {
            method: "POST",
            body: JSON.stringify({
              id_producto: btn.dataset.id_producto,
            }),
          }
        );
        if (!res.ok) {
          throw new Error("Error para añadir el producto al carrito");
        }
        const json = await res.json();
        desaparecerLoader();
        if (json.redirect) {
          location.href = `${btn.dataset.url}${btn.dataset.url_login}`;
          return;
        }
        if (json.result !== 1) {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: json.msg,
          });
        } else {
          Swal.fire({
            icon: "success",
            title: "Producto añadido al carrito",
            text: json.msg,
          });
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
    });
  });
}

loadEventAddCart();
