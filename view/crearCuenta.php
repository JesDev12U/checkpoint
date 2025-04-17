<!-- Contenido Principal -->
<div class="login-container">
  <div class="row w-75 mx-auto">
    <!-- Formulario Lado Izquierdo -->
    <div class="col-md-6 login-box">
      <h2 class="text-center mb-4" id="title-crear-cuenta">Crear cuenta</h2>
      <!-- Formulario -->
      <form id="form-login" data-url="<?php echo SITE_URL ?>">
        <div class="mb-3">
          <label for="nombre_cliente" class="form-label"><i class="fa-solid fa-font"></i>&nbsp;Nombre</label>
          <input id="input-nombre_cliente" type="text" class="form-control" name="nombre_cliente" placeholder="Ingresa tu nombre" required>
          <span id="error-nombre" class="span-errors hidden">Nombre inválido</span>
        </div>
        <div class="mb-3">
          <label for="appat_cliente" class="form-label"><i class="fa-solid fa-font"></i>&nbsp;Apellido paterno</label>
          <input id="input-appat_cliente" type="text" class="form-control" name="appat_cliente" placeholder="Ingresa tu apellido paterno" required>
          <span id="error-appat_cliente" class="span-errors hidden">Apellido paterno inválido</span>
        </div>
        <div class="mb-3">
          <label for="apmat_cliente" class="form-label"><i class="fa-solid fa-font"></i>&nbsp;Apellido materno</label>
          <input id="input-apmat_cliente" type="text" class="form-control" name="apmat_cliente" placeholder="Ingresa tu apellido materno" required>
          <span id="error-apmat_cliente" class="span-errors hidden">Apellido materno inválido</span>
        </div>
        <div class="mb-3">
          <label for="telefono_cliente" class="form-label"><i class="fa-solid fa-mobile"></i>&nbsp;Teléfono</label>
          <input id="input-telefono_cliente" type="text" class="form-control" name="telefono_cliente" placeholder="Ingresa tu número de teléfono" required>
          <span id="error-telefono_cliente" class="span-errors hidden">Teléfono inválido</span>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label"><i class="fa-solid fa-envelope"></i>&nbsp;Correo electrónico</label>
          <input id="input-email" type="email" class="form-control" name="email" placeholder="Ingresa tu correo electrónico" required>
          <span id="error-email" class="span-errors hidden">Correo electrónico inválido</span>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label"><i class="fa-solid fa-lock"></i>&nbsp;Contraseña</label>
          <div class="input-group">
            <input id="password" type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
            <button class="btn btn-outline-secondary" id="toggle-password" type="button">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
          <span id="error-password" class="span-errors hidden">La contraseña no puede ser vacía</span><br>
        </div>
        <div class="mb-3">
          <label for="password-confirm" class="form-label"><i class="fa-solid fa-lock"></i>&nbsp;Confirmar contraseña</label>
          <div class="input-group">
            <input id="password" type="password" class="form-control" id="password" name="password-confirm" placeholder="Vuelve a escribir la contraseña" required>
            <button class="btn btn-outline-secondary" id="toggle-password" type="button">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
          <span id="error-password" class="span-errors hidden">Las contraseñas no coinciden</span><br>
        </div>
        <div class="mb-3 text-end">
          <a href="<?php echo SITE_URL . RUTA_LOGIN ?>" class="text-decoration-none"><i class="fa-solid fa-right-to-bracket"></i> ¿Ya tienes cuenta? Inicia sesión</a>
        </div>
        <div class="d-grid gap-3">
          <button id="btn-iniciar-sesion" class="btn btn-practical" disabled>Crear cuenta</button>
        </div>
      </form>
    </div>
    <!-- Subir Foto Lado Derecho -->
    <div class="col general-container-foto" style="margin-bottom: 50px;">
      <h5 class="text-center mb-4">Foto</h5>
      <div class="wrapper-foto">
        <div class="container-foto">
          <?php
          $placeholderUserPath = SITE_URL . "uploads/placeholderuser.png";
          echo "<img id='foto-user' src='$placeholderUserPath' alt='$placeholderUserPath' style='max-width: 250px; max-height: 250px;'>";
          ?>
        </div>
      </div>
      <input type="file" id="foto-file" accept="image/*">
    </div>
  </div>
</div>