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
