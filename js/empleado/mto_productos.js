let objInputs = [
  {
    id: "nombre",
    type: "nombre-alfanumerico",
    spanError: "error-nombre",
  },
  {
    id: "precio",
    type: "unidades_flotantes",
    spanError: "error-precio",
  },
  {
    id: "descripcion",
    type: "text",
    spanError: "error-descripcion",
  },
  {
    id: "cantidad",
    type: "unidades",
    spanError: "error-cantidad",
  },
];

validaciones(objInputs, "btn-send");

const $categoria2 = document.getElementById("categoria2");
const $categoria3 = document.getElementById("categoria3");

const loadCategoria3 = () => {
  $categoria3.innerHTML = "";
  let value = "";
  const categories = {
    PlayStation: [
      {
        text: "PlayStation 1",
        value: "PS1",
      },
      {
        text: "PlayStation 2",
        value: "PS2",
      },
      {
        text: "PlayStation 3",
        value: "PS3",
      },
      {
        text: "PlayStation 4",
        value: "PS4",
      },
      {
        text: "PlayStation 5",
        value: "PS5",
      },
    ],
    Xbox: [
      {
        text: "Xbox Clásico",
        value: "Xbox",
      },
      {
        text: "Xbox 360",
        value: "Xbox360",
      },
      {
        text: "Xbox One",
        value: "XboxOne",
      },
      {
        text: "Xbox Series X/S",
        value: "XboxSeriesXS",
      },
    ],
    Nintendo: [
      {
        text: "Nintendo 64",
        value: "Nintendo64",
      },
      {
        text: "GameCube",
        value: "GameCube",
      },
      {
        text: "Wii",
        value: "Wii",
      },
      {
        text: "Switch",
        value: "Switch",
      },
    ],
  };
  $categoria2.querySelectorAll("option").forEach((option) => {
    if (option.selected) value = option.value;
  });
  if (value === "") return;
  const $fragment = document.createDocumentFragment();
  categories[value].forEach((data) => {
    const $option = document.createElement("option");
    $option.textContent = data.text;
    $option.value = data.value;
    if ($categoria3.dataset.valor === $option.value) $option.selected = true;
    $fragment.appendChild($option);
  });
  $categoria3.appendChild($fragment);
};

loadCategoria3();
$categoria2.addEventListener("change", () => loadCategoria3());

const $fotoProducto = document.getElementById("foto-producto");
const $formDataFoto = new FormData();
const $btnSend = document.getElementById("btn-send");
const $fotoFile = document.getElementById("foto-file");

$fotoFile.addEventListener("change", (e) => {
  const file = e.target.files[0];
  if (file) {
    const urlTemporal = URL.createObjectURL(file);
    $fotoProducto.src = urlTemporal;

    // Limpieza de la URL temporal cuando ya no se necesite
    $fotoFile.onload = () => URL.revokeObjectURL(urlTemporal);
    $formDataFoto.append("foto_path", file, file.name);
  }
});

$btnSend.addEventListener("click", function (e) {
  e.preventDefault();
  const formDataDatos = new FormData(document.getElementById("form-datos"));
  for (let [key, value] of $formDataFoto.entries()) {
    formDataDatos.append(key, value);
  }

  if (
    formDataDatos.getAll("foto_path").length !== 0 ||
    this.dataset.peticion === "UPDATE"
  ) {
    asyncConfirmProcess(
      formDataDatos,
      `${this.dataset.url}controller/empleado/gestor_productos/AsyncMtoProductos.php`,
      "Confirmación",
      this.dataset.peticion === "UPDATE"
        ? "¿Está seguro de modificar los datos de este producto?"
        : "¿Está seguro de que desea hacer el registro de este producto?",
      this.dataset.peticion === "UPDATE"
        ? "¡Datos modificados correctamente!"
        : "¡Producto registrado correctamente!",
      (json) => {
        setTimeout(
          () =>
            (location.href = `${this.dataset.url}${this.dataset.url_empleado}${this.dataset.url_gestor_productos}`),
          2000
        );
      }
    );
  } else {
    Swal.fire({
      icon: "error",
      title: "¡Error!",
      text: "Tienes que subir una foto para seguir con el registro",
    });
  }
});
