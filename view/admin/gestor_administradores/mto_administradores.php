<div class="container">
  <a href="<?php echo $this->mantenimiento ? SITE_URL . RUTA_ADMINISTRADOR . RUTA_GESTOR_ADMINISTRADORES : SITE_URL . RUTA_ADMINISTRADOR ?>" class="btn btn-primary">
    <i class="fa-solid fa-arrow-left"></i>
  </a>
  <h1><?php echo $this->mantenimiento ? "Mantenimiento de administradores" : "Configuración de la cuenta" ?></h1>
  <div id="formSection" class="mt-5">
    <div class="row">
      <!-- Formulario -->
      <div class="col">
        <h5 class="text-center mb-4">Información Personal</h5>
        <form id="form-datos">
          <input type="hidden" name="peticion" value="<?php echo $this->peticion ?>">
          <?php if (!is_null($this->id_admin)) echo '<input type="hidden" name="id_admin" value="' . $this->id_admin . '" />' ?>
          <input type="hidden" name="mantenimiento" value="<?php echo $this->mantenimiento ?>">
          <div class="mb-3">
            <label for="nombre" class="form-label"><i class="fa-solid fa-font"></i>&nbsp;Nombre</label>
            <input
              type="text"
              class="form-control"
              id="nombre"
              name="nombre"
              value="<?php echo is_null($this->id_admin) ? "" : $this->nombre ?>"
              placeholder="<?php echo $this->mantenimiento ? "Ingresa aquí el nombre del administrador" : "Ingresa aquí tu nombre" ?>"
              required />
            <span id="error-nombre" class="span-errors hidden">Nombre inválido</span>
          </div>
          <div class="mb-3">
            <label for="appat" class="form-label"><i class="fa-solid fa-font"></i>&nbsp;Apellido paterno</label>
            <input
              type="text"
              class="form-control"
              id="appat"
              name="appat"
              value="<?php echo is_null($this->id_admin) ? "" : $this->appat ?>"
              placeholder="<?php echo $this->mantenimiento ? "Ingresa aquí el apellido paterno del administrador" : "Ingresa aquí tu apellido paterno" ?>"
              required />
            <span id="error-appat" class="span-errors hidden">Apellido paterno inválido</span>
          </div>
          <div class="mb-3">
            <label for="apmat" class="form-label"><i class="fa-solid fa-font"></i>&nbsp;Apellido materno</label>
            <input
              type="text"
              class="form-control"
              id="apmat"
              name="apmat"
              value="<?php echo is_null($this->id_admin) ? "" : $this->appat ?>"
              placeholder="<?php echo $this->mantenimiento ? "Ingresa aquí el apellido materno del administrador" : "Ingresa aquí tu apellido materno" ?>"
              required />
            <span id="error-apmat" class="span-errors hidden">Apellido materno inválido</span>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label"><i class="fa-solid fa-envelope"></i>&nbsp;Correo electrónico</label>
            <input
              type="email"
              class="form-control"
              id="email"
              name="email"
              value="<?php echo is_null($this->id_admin) ? "" : $this->email ?>"
              placeholder="<?php echo $this->mantenimiento ? "Ingresa aquí el correo electrónico del administrador" : "Ingresa aquí tu correo electrónico" ?>"
              required />
            <span id="error-email" class="span-errors hidden">Correo electrónico inválido</span>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label"><i class="fa-solid fa-lock"></i>&nbsp;Contraseña</label>
            <div class="input-group">
              <input
                data-valor="<?php echo is_null($this->id_admin) ?>"
                type="password"
                class="form-control"
                id="password"
                name="password"
                placeholder="<?php echo $this->mantenimiento ? "Ingresa aquí una contraseña para el administrador" : "Ingresa aquí tu nueva contraseña si la deseas cambiar" ?>"
                <?php echo !$this->mantenimiento || $this->peticion === "INSERT" ? "" : "disabled" ?> />
              <button class="btn btn-outline-secondary" id="toggle-password" type="button">
                <i class="fa-solid fa-eye"></i>
              </button>
            </div>
            <span id="error-password" class="span-errors hidden">Contraseña inválida</span>
          </div>
          <div class="mb-3">
            <label for="telefono" class="form-label"><i class="fa-solid fa-phone"></i>&nbsp;Teléfono</label>
            <input
              type="text"
              class="form-control"
              id="telefono"
              name="telefono"
              value="<?php echo is_null($this->id_admin) ? "" : $this->telefono ?>"
              placeholder="<?php echo $this->mantenimiento ? "Ingresa aquí el teléfono del administrador" : "Ingresa aquí tu teléfono" ?>"
              required />
            <span id="error-telefono" class="span-errors hidden">Teléfono inválido</span>
          </div>
        </form>
      </div>
      <div class="col general-container-foto" style="margin-bottom: 50px;">
        <h5 class="text-center mb-4">Foto</h5>
        <div class="wrapper-foto">
          <div class="container-foto">
            <?php
            if (!is_null($this->id_admin) && $this->foto_path !== "") {
              echo "<img id='foto-user' src='$this->foto_path' alt='$this->foto_path' style='max-width: 250px; max-height: 250px;'>";
            } else {
              $placeholderUserPath = SITE_URL . "uploads/placeholderuser.png";
              echo "<img id='foto-user' src='$placeholderUserPath' alt='$placeholderUserPath' style='max-width: 250px; max-height: 250px;'>";
            }
            ?>
          </div>
        </div>
        <input type="file" id="foto-file" accept="image/*">
      </div>
      <div class="container" style="margin-bottom: 50px;">
        <button
          type="submit"
          class="btn btn-success"
          id="btn-send"
          data-peticion="<?php echo $this->peticion ?>"
          data-url="<?php echo SITE_URL; ?>"
          data-id_admin="<?php echo is_null($this->id_admin) ? "" : $this->id_admin ?>"
          data-mantenimiento="<?php echo $this->mantenimiento ?>"
          data-url_admin="<?php echo RUTA_ADMINISTRADOR ?>"
          data-url_gestor_administradores="<?php echo RUTA_GESTOR_ADMINISTRADORES ?>">
          <i class="fa-solid fa-check"></i>
          <?php echo is_null($this->id_admin) ? "Registrar" : "Actualizar" ?>
        </button>
      </div>
    </div>
  </div>
</div>