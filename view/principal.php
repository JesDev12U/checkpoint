<?php
require_once __DIR__ . "/../controller/renderProductosPrincipal.php";
?>
<header class="minecraft-header py-4 mb-4 shadow">
  <div class="container text-center">
    <!-- <h1 class="minecraft-title mb-1" style="font-size:2.5rem;">Checkpoint</h1> -->
    <img src="img/logo3.png" alt="Logo" width="400" height="100">
    <p class="lead mb-0" style="color:#3e5c14;">¡Tu tienda gamer favorita!</p>
  </div>
</header>


<nav class="navbar navbar-expand-lg minecraft-navbar mb-4 sticky-top">
  <div class="container">
    <a class="navbar-brand d-lg-none" href="#" style="color:#3e5c14;">Categorías</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCategories" aria-controls="navbarCategories" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="filter: invert(40%) sepia(80%) saturate(400%) hue-rotate(60deg);"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarCategories">
      <ul class="navbar-nav">
        <!-- Consolas Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="consolasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:#3e5c14;font-weight:bold;">
            Consolas
          </a>
          <ul class="dropdown-menu" aria-labelledby="consolasDropdown">
            <li>
              <h6 class="dropdown-header">PlayStation</h6>
            </li>
            <li><a class="dropdown-item" href="#consolas-ps5">PlayStation 5</a></li>
            <li><a class="dropdown-item" href="#consolas-ps4">PlayStation 4</a></li>
            <li><a class="dropdown-item" href="#consolas-ps3">PlayStation 3</a></li>
            <li><a class="dropdown-item" href="#consolas-ps2">PlayStation 2</a></li>
            <li><a class="dropdown-item" href="#consolas-ps1">PlayStation 1</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <h6 class="dropdown-header">Xbox</h6>
            </li>
            <li><a class="dropdown-item" href="#consolas-xboxSeriesXS">Xbox Series X/S</a></li>
            <li><a class="dropdown-item" href="#consolas-xboxOne">Xbox One</a></li>
            <li><a class="dropdown-item" href="#consolas-xbox360">Xbox 360</a></li>
            <li><a class="dropdown-item" href="#consolas-xbox">Xbox Classic</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <h6 class="dropdown-header">Nintendo</h6>
            </li>
            <li><a class="dropdown-item" href="#consolas-nintendoSwitch">Nintendo Switch</a></li>
            <li><a class="dropdown-item" href="#consolas-nintendoWii">Wii/Wii U</a></li>
            <li><a class="dropdown-item" href="#consolas-nintendoGameCube">GameCube</a></li>
            <li><a class="dropdown-item" href="#consolas-nintendo64">Nintendo 64</a></li>
          </ul>
        </li>
        <!-- Videojuegos Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="videojuegosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:#3e5c14;font-weight:bold;">
            Videojuegos
          </a>
          <ul class="dropdown-menu" aria-labelledby="videojuegosDropdown">
            <li>
              <h6 class="dropdown-header">PlayStation</h6>
            </li>
            <li><a class="dropdown-item" href="#videojuegos-ps5">PS5</a></li>
            <li><a class="dropdown-item" href="#videojuegos-ps4">PS4</a></li>
            <li><a class="dropdown-item" href="#videojuegos-ps3">PS3</a></li>
            <li><a class="dropdown-item" href="#videojuegos-ps2">PS2</a></li>
            <li><a class="dropdown-item" href="#videojuegos-ps1">PS1</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <h6 class="dropdown-header">Xbox</h6>
            </li>
            <li><a class="dropdown-item" href="#videojuegos-xboxSeriesXS">Xbox Series X/S</a></li>
            <li><a class="dropdown-item" href="#videojuegos-xboxOne">Xbox One</a></li>
            <li><a class="dropdown-item" href="#videojuegos-xbox360">Xbox 360</a></li>
            <li><a class="dropdown-item" href="#videojuegos-xbox">Xbox Classic</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <h6 class="dropdown-header">Nintendo</h6>
            </li>
            <li><a class="dropdown-item" href="#videojuegos-nintendoSwitch">Switch</a></li>
            <li><a class="dropdown-item" href="#videojuegos-nintendoWii">Wii/Wii U</a></li>
            <li><a class="dropdown-item" href="#videojuegos-nintendoGameCube">GameCube</a></li>
            <li><a class="dropdown-item" href="#videojuegos-nintendo64">Nintendo 64</a></li>
          </ul>
        </li>
      </ul>

      <!-- Barra de búsqueda -->
      <div class="container mb-4">
        <div class="row justify-content-center">
          <div class="col-12 col-md-8">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Buscar productos..." id="mainSearchBar" readonly style="cursor:pointer;">
              <button class="btn btn-outline-success" type="button" id="openSearchModalBtn">
                <i class="bi bi-search"></i> Buscar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Modal de búsqueda -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="searchModalLabel">Buscar productos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Escribe para buscar..." id="modalSearchInput" autofocus>
          <button class="btn btn-success" type="button" id="modalSearchBtn" data-url="<?php echo SITE_URL ?>">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </div>
        <div id="searchResults" class="row g-4">
          <!-- Aquí se mostrarán los productos encontrados -->
        </div>
      </div>
    </div>
  </div>
</div>

<main class="container">
  <div class="bg-white rounded-4 p-4 text-center shadow mb-5" style="border:3px solid #5e8c31;">
    <h2 class="minecraft-title mb-3" style="font-size:1.5rem;">¡Bienvenido a Checkpoint!</h2>
    <p class="fs-5" style="color:#3e5c14;">
      Explora nuestra amplia selección de consolas y videojuegos.<br>
      Haz clic en las categorías de arriba para descubrir todo lo que tenemos para ti.<br>
      <span class="fw-bold">¡Vive la experiencia gamer al máximo!</span>
    </p>
  </div>

  <!-- Productos -->
  <!-- Consolas -->
  <h3 class="mb-4 minecraft-title" style="font-size:2rem;">Consolas</h3>
  <hr>
  <!-- PlayStation -->
  <h3 class="mb-4 minecraft-title" style="font-size:2rem;">PlayStation</h3>
  <hr>
  <h3 id="consolas-ps5" class="mb-4 minecraft-title" style="font-size:1.2rem;">PlayStation 5</h3>
  <?php renderProductosPrincipal($this->consolasPlayStationPS5) ?>
  <h3 id="consolas-ps4" class="mb-4 minecraft-title" style="font-size:1.2rem;">PlayStation 4</h3>
  <?php renderProductosPrincipal($this->consolasPlayStationPS4) ?>
  <h3 id="consolas-ps3" class="mb-4 minecraft-title" style="font-size:1.2rem;">PlayStation 3</h3>
  <?php renderProductosPrincipal($this->consolasPlayStationPS3) ?>
  <h3 id="consolas-ps2" class="mb-4 minecraft-title" style="font-size:1.2rem;">PlayStation 2</h3>
  <?php renderProductosPrincipal($this->consolasPlayStationPS2) ?>
  <h3 id="consolas-ps1" class="mb-4 minecraft-title" style="font-size:1.2rem;">PlayStation 1</h3>
  <?php renderProductosPrincipal($this->consolasPlayStationPS1) ?>
  <!-- Xbox -->
  <h3 class="mb-4 minecraft-title" style="font-size:2rem;">Xbox</h3>
  <hr>
  <h3 id="consolas-xbox" class="mb-4 minecraft-title" style="font-size:1.2rem;">Xbox Classic</h3>
  <?php renderProductosPrincipal($this->consolasXboxXbox) ?>
  <h3 id="consolas-xbox360" class="mb-4 minecraft-title" style="font-size:1.2rem;">Xbox 360</h3>
  <?php renderProductosPrincipal($this->consolasXboxXbox360) ?>
  <h3 id="consolas-xboxOne" class="mb-4 minecraft-title" style="font-size:1.2rem;">Xbox One</h3>
  <?php renderProductosPrincipal($this->consolasXboxXboxOne) ?>
  <h3 id="consolas-xboxSeriesXS" class="mb-4 minecraft-title" style="font-size:1.2rem;">Xbox Series X/S</h3>
  <?php renderProductosPrincipal($this->consolasXboxXboxSeriesXS) ?>
  <!-- Nintendo -->
  <h3 class="mb-4 minecraft-title" style="font-size:2rem;">Nintendo</h3>
  <hr>
  <h3 id="consolas-nintendo64" class="mb-4 minecraft-title" style="font-size:1.2rem;">Nintendo 64</h3>
  <?php renderProductosPrincipal($this->consolasNintendoNintendo64) ?>
  <h3 id="consolas-nintendoGameCube" class="mb-4 minecraft-title" style="font-size:1.2rem;">GameCube</h3>
  <?php renderProductosPrincipal($this->consolasNintendoGameCube) ?>
  <h3 id="consolas-nintendoWii" class="mb-4 minecraft-title" style="font-size:1.2rem;">Wii/Wii U</h3>
  <?php renderProductosPrincipal($this->consolasNintendoWii) ?>
  <h3 id="consolas-nintendoSwitch" class="mb-4 minecraft-title" style="font-size:1.2rem;">Nintendo Switch</h3>
  <?php renderProductosPrincipal($this->consolasNintendoSwitch) ?>

  <!-- Videojuegos -->
  <h3 class="mb-4 minecraft-title" style="font-size:2rem;">Videojuegos</h3>
  <hr>
  <!-- PlayStation -->
  <h3 class="mb-4 minecraft-title" style="font-size:2rem;">PlayStation</h3>
  <hr>
  <h3 id="videojuegos-ps5" class="mb-4 minecraft-title" style="font-size:1.2rem;">PlayStation 5</h3>
  <?php renderProductosPrincipal($this->videojuegosPlayStationPS5) ?>
  <h3 id="videojuegos-ps4" class="mb-4 minecraft-title" style="font-size:1.2rem;">PlayStation 4</h3>
  <?php renderProductosPrincipal($this->videojuegosPlayStationPS4) ?>
  <h3 id="videojuegos-ps3" class="mb-4 minecraft-title" style="font-size:1.2rem;">PlayStation 3</h3>
  <?php renderProductosPrincipal($this->videojuegosPlayStationPS3) ?>
  <h3 id="videojuegos-ps2" class="mb-4 minecraft-title" style="font-size:1.2rem;">PlayStation 2</h3>
  <?php renderProductosPrincipal($this->videojuegosPlayStationPS2) ?>
  <h3 id="videojuegos-ps1" class="mb-4 minecraft-title" style="font-size:1.2rem;">PlayStation 1</h3>
  <?php renderProductosPrincipal($this->videojuegosPlayStationPS1) ?>
  <!-- Xbox -->
  <h3 class="mb-4 minecraft-title" style="font-size:2rem;">Xbox</h3>
  <hr>
  <h3 id="videojuegos-xbox" class="mb-4 minecraft-title" style="font-size:1.2rem;">Xbox Classic</h3>
  <?php renderProductosPrincipal($this->videojuegosXboxXbox) ?>
  <h3 id="videojuegos-xbox360" class="mb-4 minecraft-title" style="font-size:1.2rem;">Xbox 360</h3>
  <?php renderProductosPrincipal($this->videojuegosXboxXbox360) ?>
  <h3 id="videojuegos-xboxOne" class="mb-4 minecraft-title" style="font-size:1.2rem;">Xbox One</h3>
  <?php renderProductosPrincipal($this->videojuegosXboxXboxOne) ?>
  <h3 id="videojuegos-xboxSeriesXS" class="mb-4 minecraft-title" style="font-size:1.2rem;">Xbox Series X/S</h3>
  <?php renderProductosPrincipal($this->videojuegosXboxXboxSeriesXS) ?>
  <!-- Nintendo -->
  <h3 class="mb-4 minecraft-title" style="font-size:2rem;">Nintendo</h3>
  <hr>
  <h3 id="videojuegos-nintendo64" class="mb-4 minecraft-title" style="font-size:1.2rem;">Nintendo 64</h3>
  <?php renderProductosPrincipal($this->videojuegosNintendoNintendo64) ?>
  <h3 id="videojuegos-nintendoGameCube" class="mb-4 minecraft-title" style="font-size:1.2rem;">GameCube</h3>
  <?php renderProductosPrincipal($this->videojuegosNintendoGameCube) ?>
  <h3 id="videojuegos-nintendoWii" class="mb-4 minecraft-title" style="font-size:1.2rem;">Wii/Wii U</h3>
  <?php renderProductosPrincipal($this->videojuegosNintendoWii) ?>
  <h3 id="videojuegos-nintendoSwitch" class="mb-4 minecraft-title" style="font-size:1.2rem;">Nintendo Switch</h3>
  <?php renderProductosPrincipal($this->videojuegosNintendoSwitch) ?>
</main>