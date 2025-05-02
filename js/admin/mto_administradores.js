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
];

validaciones(objInputs, "btn-send");

const $fotoUser = document.getElementById("foto-user");
const formDataFoto = new FormData();
const $btnSend = document.getElementById("btn-send");
const $fotoFile = document.getElementById("foto-file");

$fotoFile.addEventListener("change", (e) => {
  const file = e.target.files[0];
  if (file) {
    const urlTemporal = URL.createObjectURL(file);
    $fotoUser.src = urlTemporal;

    // Limpieza de  la URL temporal cuando ya no se necesite
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
    `${this.dataset.url}controller/admin/gestor_administradores/AsyncMtoAdministradores.php`,
    "Confirmación",
    !this.dataset.mantenimiento
      ? "¿Está seguro de modificar sus datos?"
      : this.dataset.peticion === "UPDATE"
      ? "¿Está seguro de modificar los datos de este administrador?"
      : "¿Está seguro de que desea hacer el registro de este administrador?",
    !this.dataset.mantenimiento || this.dataset.peticion === "UPDATE"
      ? "¡Datos modificados correctamente!"
      : "¡Administrador registrado correctamente!",
    (json) => {
      if (!$btnSend.dataset.mantenimiento) {
        if (json.nuevos_datos) {
          const $fotoUserHeader = document.getElementById("foto-user-header");
          if ($fotoUserHeader && json.nuevos_datos.foto_path !== "")
            $fotoUserHeader.src = json.nuevos_datos.foto_path;
          const nuevoNombre = `${json.nuevos_datos.nombre} ${json.nuevos_datos.appat} ${json.nuevos_datos.apmat}`;
          document.querySelector(".account p").textContent = nuevoNombre;
        }
      }
      if ($btnSend.dataset.mantenimiento === "1") {
        setTimeout(
          () =>
            (location.href = `${this.dataset.url}${this.dataset.url_admin}${this.dataset.url_gestor_administradores}`),
          2000
        );
      } else {
        setTimeout(
          () =>
            (location.href = `${this.dataset.url}${this.dataset.url_admin}`),
          2000
        );
      }
    }
  );
});
