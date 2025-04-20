<div class="container">
  <a href="<?php echo SITE_URL . RUTA_EMPLEADO . RUTA_GESTOR_PRODUCTOS ?>" class="btn btn-primary">
    <i class="fa-solid fa-arrow-left"></i>
  </a>
  <h1>Mantenimiento de productos</h1>
  <div id="formSection" class="mt-5">
    <div class="row">
      <!-- Formulario -->
      <div class="col">
        <h5 class="text-center mb-4">Información del producto</h5>
        <form id="form-datos">
          <input type="hidden" name="peticion" value="<?php echo $this->peticion ?>">
          <?php if (!is_null($this->id_producto)) echo '<input type="hidden" name="id_producto" value="' . $this->id_producto . '" />' ?>
          <div class="mb-3">
            <label for="nombre" class="form-label"><i class="fa-solid fa-font"></i>&nbsp;Nombre</label>
            <input
              type="text"
              class="form-control"
              id="nombre"
              name="nombre"
              value="<?php echo is_null($this->id_producto) ? "" : $this->nombre ?>"
              placeholder="Ingresa aquí el nombre del producto"
              required />
            <span id="error-nombre" class="span-errors hidden">Nombre inválido</span>
          </div>
          <div class="mb-3">
            <label for="categoria1" class="form-label"><i class="fa-solid fa-gamepad"></i>&nbsp;Categoría 1</label>
            <select
              class="form-control"
              name="categoria1"
              id="categoria1">
              <option value="Consolas" <?php echo $this->categoria1 === "Consolas" ? "selected" : "" ?>>Consolas</option>
              <option value="Videojuegos" <?php echo $this->categoria1 === "Videojuegos" ? "selected" : "" ?>>Videojuegos</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="categoria2" class="form-label"><i class="fa-solid fa-gamepad"></i>&nbsp;Categoría 2</label>
            <select
              class="form-control"
              name="categoria2"
              id="categoria2">
              <option value="PlayStation" <?php echo $this->categoria2 === "PlayStation" ? "selected" : "" ?>>PlayStation</option>
              <option value="Xbox" <?php echo $this->categoria2 === "Xbox" ? "selected" : "" ?>>Xbox</option>
              <option value="Nintendo" <?php echo $this->categoria2 === "Nintendo" ? "selected" : "" ?>>Nintendo</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="categoria3" class="form-label"><i class="fa-solid fa-gamepad"></i>&nbsp;Categoría 3</label>
            <select
              class="form-control"
              name="categoria3"
              id="categoria3"
              data-valor="<?php echo $this->categoria3 ?>">
            </select>
          </div>
          <div class="mb-3">
            <label for="precio" class="form-label"><i class="fa-solid fa-dollar-sign"></i>&nbsp;Precio</label>
            <input
              type="number"
              class="form-control"
              id="precio"
              name="precio"
              value="<?php echo is_null($this->id_producto) ? "" : $this->precio ?>"
              placeholder="Ingresa aquí el precio del producto"
              required />
            <span id="error-precio" class="span-errors hidden">Precio inválido</span>
          </div>
          <div class="mb-3">
            <label for="descripcion" class="form-label"><i class="fa-solid fa-star"></i>&nbsp;Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Ingresa aquí la descripción del producto"><?php echo is_null($this->id_producto) ? "" : $this->descripcion ?></textarea>
            <span id="error-descripcion" class="span-errors hidden">La descripción no puede estar vacía</span>
          </div>
          <div class="mb-3">
            <label for="cantidad" class="form-label"><i class="fa-solid fa-hashtag"></i>&nbsp;Cantidad</label>
            <input
              type="number"
              class="form-control"
              id="cantidad"
              name="cantidad"
              value="<?php echo is_null($this->id_producto) ? "" : $this->cantidad ?>"
              placeholder="Ingresa la cantidad que hay disponible del producto"
              required />
            <span id="error-cantidad" class="span-errors hidden">Cantidad inválida</span>
          </div>
        </form>
      </div>
      <div class="col general-container-foto" style="margin-bottom: 50px;">
        <h5 class="text-center mb-4">Foto</h5>
        <div class="wrapper-foto">
          <div class="container-foto">
            <?php
            if (!is_null($this->id_producto)) {
              echo "<img id='foto-producto' src='$this->foto_path' alt='$this->foto_path' style='max-width: 250px; max-height: 250px;'>";
            } else {
              $placeholderUserPath = SITE_URL . "uploads/placeholderimage.jpg";
              echo "<img id='foto-producto' src='$placeholderUserPath' alt='$placeholderUserPath' style='max-width: 250px; max-height: 250px;'>";
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
          data-url_empleado="<?php echo RUTA_EMPLEADO ?>"
          data-url_gestor_productos="<?php echo RUTA_GESTOR_PRODUCTOS ?>">
          <i class="fa-solid fa-check"></i>
          <?php echo is_null($this->id_producto) ? "Registrar" : "Actualizar" ?>
        </button>
      </div>
    </div>
  </div>
</div>