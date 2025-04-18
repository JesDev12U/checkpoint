function validaciones(objInputs, idButton) {
  //objInputs: [{ id, type, spanError }] Array de Objetos
  //Longitudes obtenidas directamente de la base de datos
  const lengthInputs = [
    {
      input: "phone",
      longitud: 10,
    },
    {
      input: "password",
      longitud: 16,
    },
    {
      input: "password-modify",
      longitud: 16,
    },
    {
      input: "nombre",
      longitud: 50,
    },
    {
      input: "email",
      longitud: 80,
    },
    {
      input: "apellido",
      longitud: 50,
    },
  ];
  objInputs.forEach((obj) => {
    let $input = document.getElementById(obj.id);
    let $spanError = document.getElementById(obj.spanError);
    let isValidInput = false;
    $input.addEventListener("input", function () {
      for (const { input, longitud } of lengthInputs)
        if (obj.type === input) this.value = this.value.slice(0, longitud);

      isValidInput = checkValidInput(obj.type, this);
      if (isValidInput) $spanError.classList.add("hidden");
      else $spanError.classList.remove("hidden");
      checkAllValid();
    });
  });

  function checkValidInput(type, input) {
    switch (type) {
      case "email":
        input.value = input.value
          .replace(/[^a-zA-Z0-9@.\-_]/g, "")
          .replace(/\.{2,}/g, ".") // Elimina puntos consecutivos
          .toLowerCase()
          .trim();
        return validator.isEmail(input.value);
      case "password":
        input.value = input.value.replace(/\s+/g, "");
        return input.value.length > 0 && input.value.length <= 16;
      case "password-modify":
        return input.value.length <= 16;
      case "nombre":
        input.value = input.value
          .replace(/\s+/g, " ")
          .replace(/[^a-zA-ZñáéíóúÁÉÍÓÚ´\s]/g, "");
        return input.value.length !== 0;
      case "apellido":
        input.value = input.value
          .replace(/\s+/g, " ")
          .replace(/[^a-zA-ZñáéíóúÁÉÍÓÚ´\s]/g, "");
        return input.value.length !== 0;
      case "phone":
        input.value = input.value.trim().replace(/\D/g, "");
        return (
          input.value.length > 0 &&
          input.value.length <= 10 &&
          validator.isMobilePhone(input.value, ["es-MX"])
        );
      case "text":
        return input.value.length !== 0;
      case "fecha":
        return validator.isDate(input.value, { format: "YYYY-MM-DD" });
      case "hora":
        return validator.isTime(input.value);
      default:
        return true;
    }
  }

  function checkAllValid() {
    let allValid = objInputs.every((obj) => {
      let $input = document.getElementById(obj.id);
      return checkValidInput(obj.type, $input);
    });
    let $button = document.getElementById(idButton);
    $button.disabled = !allValid;
  }

  checkAllValid();
}
