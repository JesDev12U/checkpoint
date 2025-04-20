<?php
require_once __DIR__ . '/../../../controller/renderTablaProductos.php';
?>
<!-- Area de contenido -->
<div class="container-fluid p-4">
  <a href="<?php echo SITE_URL ?>" class="btn btn-primary">
    <i class="fa-solid fa-arrow-left"></i>
  </a>
  <h1>Gestor de productos</h1>
  <br><br>
  <a href="<?php echo SITE_URL . RUTA_EMPLEADO . RUTA_MTO_PRODUCTOS ?>" class="btn btn-success">
    <i class="fas fa-plus"></i>
    Agregar
  </a>
  <p>Selecciona las categorías que deseas visualizar</p>
  <!-- Tabs principales -->
  <ul class="nav nav-pills justify-content-center mb-3" id="main-tabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="consolas-tab" data-bs-toggle="pill" data-bs-target="#consolas" type="button" role="tab">🎮 Consolas</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="videojuegos-tab" data-bs-toggle="pill" data-bs-target="#videojuegos" type="button" role="tab">🕹️ Videojuegos</button>
    </li>
  </ul>

  <div class="tab-content" id="main-tabs-content">
    <!-- Consolas -->
    <div class="tab-pane fade show active" id="consolas" role="tabpanel" aria-labelledby="consolas-tab">
      <ul class="nav nav-pills mb-3 justify-content-center">
        <li class="nav-item">
          <button class="nav-link active text-white" style="background-color: #003791;" data-bs-toggle="pill" data-bs-target="#ps-consolas">
            <i class="fab fa-playstation me-1"></i> PlayStation
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link text-white" style="background-color: #107C10;" data-bs-toggle="pill" data-bs-target="#xbox-consolas">
            <i class="fab fa-xbox me-1"></i> Xbox
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link text-white" style="background-color: #E60012;" data-bs-toggle="pill" data-bs-target="#nintendo-consolas">
            <i class="fas fa-gamepad me-1"></i> Nintendo
          </button>
        </li>
      </ul>

      <div class="tab-content">
        <!-- PlayStation Consolas -->
        <div class="tab-pane fade show active" id="ps-consolas">
          <ul class="nav nav-tabs mb-3 justify-content-center">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#ps1">PS1</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#ps2">PS2</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#ps3">PS3</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#ps4">PS4</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#ps5">PS5</button></li>
          </ul>
          <div class="tab-content text-center">
            <div class="tab-pane fade show active" id="ps1">
              <?php renderTablaProductos($this->consolasPlayStationPS1); ?>
            </div>
            <div class="tab-pane fade" id="ps2">
              <?php renderTablaProductos($this->consolasPlayStationPS2); ?>
            </div>
            <div class="tab-pane fade" id="ps3">
              <?php renderTablaProductos($this->consolasPlayStationPS3) ?>
            </div>
            <div class="tab-pane fade" id="ps4">
              <?php renderTablaProductos($this->consolasPlayStationPS4) ?>
            </div>
            <div class="tab-pane fade" id="ps5">
              <?php renderTablaProductos($this->consolasPlayStationPS5) ?>
            </div>
          </div>
        </div>

        <!-- Xbox Consolas -->
        <div class="tab-pane fade" id="xbox-consolas">
          <ul class="nav nav-tabs mb-3 justify-content-center">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#xbox-original">Xbox</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#xbox360">Xbox 360</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#xbox-one">Xbox One</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#xbox-series">Xbox Series X/S</button></li>
          </ul>
          <div class="tab-content text-center">
            <div class="tab-pane fade show active" id="xbox-original">
              <?php renderTablaProductos($this->consolasXboxXbox) ?>
            </div>
            <div class="tab-pane fade" id="xbox360">
              <?php renderTablaProductos($this->consolasXboxXbox360) ?>
            </div>
            <div class="tab-pane fade" id="xbox-one">
              <?php renderTablaProductos($this->consolasXboxXboxOne) ?>
            </div>
            <div class="tab-pane fade" id="xbox-series">
              <?php renderTablaProductos($this->consolasXboxXboxSeriesXS) ?>
            </div>
          </div>
        </div>

        <!-- Nintendo Consolas -->
        <div class="tab-pane fade" id="nintendo-consolas">
          <ul class="nav nav-tabs mb-3 justify-content-center">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#n64">Nintendo 64</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#gc">GameCube</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#wii">Wii</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#switch">Switch</button></li>
          </ul>
          <div class="tab-content text-center">
            <div class="tab-pane fade show active" id="n64">
              <?php renderTablaProductos($this->consolasNintendoNintendo64) ?>
            </div>
            <div class="tab-pane fade" id="gc">
              <?php renderTablaProductos($this->consolasNintendoGameCube) ?>
            </div>
            <div class="tab-pane fade" id="wii">
              <?php renderTablaProductos($this->consolasNintendoWii) ?>
            </div>
            <div class="tab-pane fade" id="switch">
              <?php renderTablaProductos($this->consolasNintendoSwitch) ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Videojuegos -->
    <div class="tab-pane fade" id="videojuegos" role="tabpanel" aria-labelledby="videojuegos-tab">
      <ul class="nav nav-pills mb-3 justify-content-center">
        <li class="nav-item">
          <button class="nav-link active text-white" style="background-color: #003791;" data-bs-toggle="pill" data-bs-target="#ps-juegos">
            <i class="fab fa-playstation me-1"></i> PlayStation
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link text-white" style="background-color: #107C10;" data-bs-toggle="pill" data-bs-target="#xbox-juegos">
            <i class="fab fa-xbox me-1"></i> Xbox
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link text-white" style="background-color: #E60012;" data-bs-toggle="pill" data-bs-target="#nintendo-juegos">
            <i class="fas fa-gamepad me-1"></i> Nintendo
          </button>
        </li>
      </ul>

      <div class="tab-content">
        <!-- PlayStation Juegos -->
        <div class="tab-pane fade show active" id="ps-juegos">
          <ul class="nav nav-tabs mb-3 justify-content-center">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#jps1">PS1</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jps2">PS2</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jps3">PS3</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jps4">PS4</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jps5">PS5</button></li>
          </ul>
          <div class="tab-content text-center">
            <div class="tab-pane fade show active" id="jps1">
              <?php renderTablaProductos($this->videojuegosPlayStationPS1); ?>
            </div>
            <div class="tab-pane fade" id="jps2">
              <?php renderTablaProductos($this->videojuegosPlayStationPS2); ?>
            </div>
            <div class="tab-pane fade" id="jps3">
              <?php renderTablaProductos($this->videojuegosPlayStationPS3); ?>
            </div>
            <div class="tab-pane fade" id="jps4">
              <?php renderTablaProductos($this->videojuegosPlayStationPS4); ?>
            </div>
            <div class="tab-pane fade" id="jps5">
              <?php renderTablaProductos($this->videojuegosPlayStationPS5); ?>
            </div>
          </div>
        </div>

        <!-- Xbox Juegos -->
        <div class="tab-pane fade" id="xbox-juegos">
          <ul class="nav nav-tabs mb-3 justify-content-center">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#jx1">Xbox</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jx360">Xbox 360</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jxone">Xbox One</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jxseries">Xbox Series</button></li>
          </ul>
          <div class="tab-content text-center">
            <div class="tab-pane fade show active" id="jx1">
              <?php renderTablaProductos($this->videojuegosXboxXbox) ?>
            </div>
            <div class="tab-pane fade" id="jx360">
              <?php renderTablaProductos($this->videojuegosXboxXbox360) ?>
            </div>
            <div class="tab-pane fade" id="jxone">
              <?php renderTablaProductos($this->videojuegosXboxXboxOne) ?>
            </div>
            <div class="tab-pane fade" id="jxseries">
              <?php renderTablaProductos($this->videojuegosXboxXboxSeriesXS) ?>
            </div>
          </div>
        </div>

        <!-- Nintendo Juegos -->
        <div class="tab-pane fade" id="nintendo-juegos">
          <ul class="nav nav-tabs mb-3 justify-content-center">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#jn64">Nintendo 64</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jgc">GameCube</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jwii">Wii</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jswitch">Switch</button></li>
          </ul>
          <div class="tab-content text-center">
            <div class="tab-pane fade show active" id="jn64">
              <?php renderTablaProductos($this->videojuegosNintendoNintendo64) ?>
            </div>
            <div class="tab-pane fade" id="jgc">
              <?php renderTablaProductos($this->videojuegosNintendoGameCube) ?>
            </div>
            <div class="tab-pane fade" id="jwii">
              <?php renderTablaProductos($this->videojuegosNintendoWii) ?>
            </div>
            <div class="tab-pane fade" id="jswitch">
              <?php renderTablaProductos($this->videojuegosNintendoSwitch) ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script src="<?php echo SITE_URL . "js/admin/des_hab_usuarios.js" ?>"></script>