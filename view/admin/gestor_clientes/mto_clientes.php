<div class="container">
  <a href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_GESTOR_CLIENTES ?>" class="btn btn-primary">
    <i class="fa-solid fa-arrow-left"></i>
  </a>
  <h1><?php echo $_SESSION["usuario"] === "cliente" ? "Configuración de la cuenta" : "Mantenimiento de clientes" ?></h1>
  <div id="formSection" class="mt-5">
    <div class="row">
      <!-- Formulario -->
      <div class="col">
        <h5 class="text-center mb-4">Información Personal</h5>
        <form id="form-datos">
          <input type="hidden" name="peticion" value="<?php echo $this->peticion ?>">
          <?php if (!is_null($this->id_cliente)) echo '<input type="hidden" name="id_cliente" value="' . $this->id_cliente . '" />' ?>
          <div class="mb-3">
            <label for="nombre" class="form-label"><i class="fa-solid fa-font"></i>&nbsp;Nombre</label>
            <input
              type="text"
              class="form-control"
              id="nombre"
              name="nombre"
              value="<?php echo is_null($this->id_cliente) ? "" : $this->nombre ?>"
              placeholder="<?php echo $_SESSION["usuario"] === "administrador" ? "Ingresa aquí el nombre del cliente" : "Ingresa aquí tu nombre" ?>"
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
              value="<?php echo is_null($this->id_cliente) ? "" : $this->appat ?>"
              placeholder="<?php echo $_SESSION["usuario"] === "administrador" ? "Ingresa aquí el apellido paterno del cliente" : "Ingresa aquí tu apellido paterno" ?>"
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
              value="<?php echo is_null($this->id_cliente) ? "" : $this->apmat ?>"
              placeholder="<?php echo $_SESSION["usuario"] === "administrador" ? "Ingresa aquí el apellido materno del cliente" : "Ingresa aquí tu apellido materno" ?>"
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
              value="<?php echo is_null($this->id_cliente) ? "" : $this->email ?>"
              placeholder="<?php echo $_SESSION["usuario"] === "administrador" ? "Ingresa aquí el correo electrónico del cliente" : "Ingresa aquí tu correo electrónico" ?>"
              required />
            <span id="error-email" class="span-errors hidden">Correo electrónico inválido</span>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label"><i class="fa-solid fa-lock"></i>&nbsp;Contraseña</label>
            <div class="input-group">
              <input
                data-valor="<?php echo is_null($this->id_cliente) ?>"
                type="password"
                class="form-control"
                id="password"
                name="password"
                placeholder="<?php echo $_SESSION["usuario"] === "administrador" ? "Ingresa aquí una contraseña para el cliente" : "Ingresa aquí una nueva contraseña si la deseas cambiar" ?>"
                <?php echo is_null($this->id_cliente) || $_SESSION["usuario"] === "cliente" ? "" : "disabled" ?> />
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
              value="<?php echo is_null($this->id_cliente) ? "" : $this->telefono ?>"
              placeholder="<?php echo $_SESSION["usuario"] === "administrador" ? "Ingresa aquí el teléfono del cliente" : "Ingresa aquí tu teléfono" ?>"
              required />
            <span id="error-telefono" class="span-errors hidden">Teléfono inválido</span>
          </div>
          <hr class="my-4" />
          <h5 class="text-center mb-4">Domicilio</h5>

          <div class="mb-3">
            <label for="codigo_postal" class="form-label"><i class="fa-solid fa-location-dot"></i>&nbsp;Código postal</label>
            <input
              type="text"
              class="form-control"
              id="codigo_postal"
              name="codigo_postal"
              value="<?php echo is_null($this->id_cliente) ? "" : $this->codigo_postal ?>"
              placeholder="Ingresa tu código postal"
              required />
            <span id="error-codigo_postal" class="span-errors hidden">Código postal inválido</span>
          </div>

          <div class="mb-3">
            <label for="estado_domicilio" class="form-label"><i class="fa-solid fa-map"></i>&nbsp;Estado</label>
            <input
              type="text"
              class="form-control"
              id="estado_domicilio"
              name="estado_domicilio"
              value="<?php echo is_null($this->id_cliente) ? "" : $this->estado_domicilio ?>"
              required
              readonly />
          </div>

          <div class="mb-3">
            <label for="alc_mun" class="form-label"><i class="fa-solid fa-city"></i>&nbsp;Alcaldía/Municipio</label>
            <input
              type="text"
              class="form-control"
              id="alc_mun"
              name="alc_mun"
              value="<?php echo is_null($this->id_cliente) ? "" : $this->alc_mun ?>"
              required
              readonly />
          </div>

          <div class="mb-3">
            <label for="colonia" class="form-label"><i class="fa-solid fa-location-pin"></i>&nbsp;Colonia</label>
            <select
              class="form-control"
              name="colonia"
              id="colonia"
              data-valor="<?php echo $this->colonia ?>"></select>
          </div>

          <div class="mb-3">
            <label for="calle" class="form-label"><i class="fa-solid fa-road"></i>&nbsp;Calle</label>
            <input
              type="text"
              class="form-control"
              id="calle"
              name="calle"
              value="<?php echo is_null($this->id_cliente) ? "" : $this->calle ?>"
              placeholder="Ingresa la calle"
              required />
            <span id="error-calle" class="span-errors hidden">Calle inválida</span>
          </div>

          <div class="mb-3">
            <label for="no_ext" class="form-label"><i class="fa-solid fa-hashtag"></i>&nbsp;Número exterior</label>
            <input
              type="text"
              class="form-control"
              id="no_ext"
              name="no_ext"
              value="<?php echo is_null($this->id_cliente) ? "" : $this->no_ext ?>"
              placeholder="Número exterior"
              required />
            <span id="error-no_ext" class="span-errors hidden">Número exterior inválido</span>
          </div>
          <div class="mb-3">
            <label for="no_int" class="form-label"><i class="fa-solid fa-door-open"></i>&nbsp;Número interior</label>
            <input
              type="text"
              class="form-control"
              id="no_int"
              name="no_int"
              value="<?php echo is_null($this->id_cliente) ? "" : $this->no_int ?>"
              placeholder="Número interior (opcional)" />
            <span id="error-no_int" class="span-errors hidden">Número interior inválido</span>
          </div>
        </form>
      </div>
      <div class="col general-container-foto" style="margin-bottom: 50px;">
        <h5 class="text-center mb-4">Foto</h5>
        <div class="wrapper-foto">
          <div class="container-foto">
            <?php
            if (!is_null($this->id_cliente) && $this->foto_path !== "") {
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
          data-usuario="<?php echo $_SESSION["usuario"] ?>"
          data-url_admin="<?php echo RUTA_ADMINISTRADOR ?>"
          data-url_gestor_clientes="<?php echo RUTA_GESTOR_CLIENTES ?>">
          <i class="fa-solid fa-check"></i>
          <?php echo is_null($this->id_cliente) ? "Registrar" : "Actualizar" ?>
        </button>
      </div>
    </div>
  </div>
</div>