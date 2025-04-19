const $inputPassword = document.getElementById("password");

let objInputs = [
  {
    id: "nombre",
    type: "nombre",
    spanError: "error-nombre",
  },
  {
    id: "appat",
    type: "apellido",
    spanError: "error-appat",
  },
  {
    id: "apmat",
    type: "apellido",
    spanError: "error-apmat",
  },
  {
    id: "email",
    type: "email",
    spanError: "error-email",
  },
  {
    id: "password",
    type: $inputPassword.dataset.valor === "1" ? "password" : "password-modify",
    spanError: "error-password",
  },
  {
    id: "telefono",
    type: "phone",
    spanError: "error-telefono",
  },
  {
    id: "codigo_postal",
    type: "zip_code",
    spanError: "error-codigo_postal",
  },
  {
    id: "calle",
    type: "calle",
    spanError: "error-calle",
  },
  {
    id: "no_ext",
    type: "numero_exterior",
    spanError: "error-no_ext",
  },
  {
    id: "no_int",
    type: "numero_interior",
    spanError: "error-no_int",
  },
  {
    id: "estado_domicilio",
    type: "text",
    spanError: "",
  },
  {
    id: "alc_mun",
    type: "text",
    spanError: "",
  },
];

validaciones(objInputs, "btn-send");

const API_ZIP_CODES = "https://sepomex.icalialabs.com/api/v1/zip_codes";
const $codigoPostal = document.getElementById("codigo_postal");
const $colonia = document.getElementById("colonia");
const $estado = document.getElementById("estado_domicilio");
const $alcMun = document.getElementById("alc_mun");

document.addEventListener("DOMContentLoaded", async () => {
  // Si hay un valor, se está modificando a un cliente
  // Se necesita refrescar el select de las colonias
  if ($colonia.dataset.valor) {
    aparecerLoader();
    try {
      let response = await fetch(
        `${API_ZIP_CODES}?zip_code=${$codigoPostal.value}`
      );
      if (!response.ok) {
        throw new Error("Error para consultar la API de domicilios");
      }
      let data = await response.json();
      if (data.zip_codes.length === 0) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "El código postal ingresado no existe",
        });
        desaparecerLoader();
        return;
      }
      data.zip_codes.forEach((zip_code) => {
        $estado.value = zip_code.d_estado;
        $alcMun.value = zip_code.d_mnpio;
        let option = document.createElement("option");
        option.text = option.value = zip_code.d_asenta;
        if (option.value === $colonia.dataset.valor) option.selected = true;
        $colonia.appendChild(option);
      });
      validaciones(objInputs, "btn-send");
      desaparecerLoader();
    } catch (err) {
      console.error(err);
      Swal.fire({
        icon: "error",
        title: "Error",
        text: err,
      });
      desaparecerLoader();
    }
  }
});

$codigoPostal.addEventListener("input", async function (e) {
  if (this.value.length === 5) {
    $colonia.innerHTML = "";
    aparecerLoader();
    try {
      let response = await fetch(`${API_ZIP_CODES}?zip_code=${this.value}`);
      if (!response.ok) {
        throw new Error("Error para consultar la API de domicilios");
      }
      let data = await response.json();
      $colonia.innerHTML = "";
      if (data.zip_codes.length === 0) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "El código postal ingresado no existe",
        });
        desaparecerLoader();
        return;
      }

      data.zip_codes.forEach((zip_code) => {
        $estado.value = zip_code.d_estado;
        $alcMun.value = zip_code.d_mnpio;
        let option = document.createElement("option");
        option.text = option.value = zip_code.d_asenta;
        $colonia.appendChild(option);
      });
      validaciones(objInputs, "btn-send");
      desaparecerLoader();
    } catch (err) {
      console.error(err);
      Swal.fire({
        icon: "error",
        title: "Error",
        text: err,
      });
      desaparecerLoader();
    }
  } else {
    $colonia.innerHTML = $estado.value = $alcMun.value = "";
  }
});

const $fotoUser = document.getElementById("foto-user");
const formDataFoto = new FormData();
const $btnSend = document.getElementById("btn-send");
const $fotoFile = document.getElementById("foto-file");

$fotoFile.addEventListener("change", (e) => {
  const file = e.target.files[0];
  if (file) {
    const urlTemporal = URL.createObjectURL(file);
    $fotoUser.src = urlTemporal;

    // Limpieza de la URL temporal cuando ya no se necesite
    $fotoFile.onload = () => URL.revokeObjectURL(urlTemporal);
    formDataFoto.append("foto_path", file, file.name);
  }
});

$btnSend.addEventListener("click", function (e) {
  e.preventDefault();
  const formDataDatos = new FormData(document.getElementById("form-datos"));
  for (let [key, value] of formDataFoto.entries()) {
    formDataDatos.append(key, value);
  }

  asyncConfirmProcess(
    formDataDatos,
    `${this.dataset.url}controller/admin/gestor_clientes/AsyncMtoClientes.php`,
    "Confirmación",
    this.dataset.usuario === "cliente"
      ? "¿Está seguro de modificar sus datos?"
      : this.dataset.peticion === "UPDATE"
      ? "¿Está reguro de modificar los datos de este cliente?"
      : "¿Está seguro de que desea hacer el registro de este cliente?",
    this.dataset.usuario === "cliente" || this.dataset.peticion === "UPDATE"
      ? "¡Datos modificados correctamente!"
      : "¡Cliente registrado correctamente!",
    (json) => {
      if (json.usuario === "cliente") {
        const $fotoUserHeader = document.getElementById("foto-user-header");
        if ($fotoUserHeader && json.nuevos_datos.foto_path !== "")
          $fotoUserHeader.src = json.nuevos_datos.foto_path;
        const nuevoNombre = `${json.nuevos_datos.nombre} ${json.nuevos_datos.appat} ${json.nuevos_datos.apmat}`;
        document.querySelector(".account p").textContent = nuevoNombre;
        setTimeout(() => (location.href = this.dataset.url), 2000);
      } else {
        setTimeout(
          () =>
            (location.href = `${this.dataset.url}${this.dataset.url_admin}${this.dataset.url_gestor_clientes}`),
          2000
        );
      }
    }
  );
});
