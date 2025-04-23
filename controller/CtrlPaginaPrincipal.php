<?php
require_once __DIR__ . "/../model/Model.php";
require_once __DIR__ . "/../config/Global.php";

# Variables dinámicas generadas en `CtrlPaginaPrincipal`

/** Estas variables están disponibles en la vista y contienen los arrays de productos para cada categoría y subcategoría.

| Tipo         | Marca        | Modelo         | Variable generada                   |
|--------------|--------------|---------------|-------------------------------------|
| consolas     | PlayStation  | PS1           | $this->consolasPlayStationPS1       |
| consolas     | PlayStation  | PS2           | $this->consolasPlayStationPS2       |
| consolas     | PlayStation  | PS3           | $this->consolasPlayStationPS3       |
| consolas     | PlayStation  | PS4           | $this->consolasPlayStationPS4       |
| consolas     | PlayStation  | PS5           | $this->consolasPlayStationPS5       |
| consolas     | Xbox         | Xbox          | $this->consolasXboxXbox             |
| consolas     | Xbox         | Xbox360       | $this->consolasXboxXbox360          |
| consolas     | Xbox         | XboxOne       | $this->consolasXboxXboxOne          |
| consolas     | Xbox         | XboxSeriesXS  | $this->consolasXboxXboxSeriesXS     |
| consolas     | Nintendo     | Nintendo64    | $this->consolasNintendoNintendo64   |
| consolas     | Nintendo     | GameCube      | $this->consolasNintendoGameCube     |
| consolas     | Nintendo     | Wii           | $this->consolasNintendoWii          |
| consolas     | Nintendo     | Switch        | $this->consolasNintendoSwitch       |
| videojuegos  | PlayStation  | PS1           | $this->videojuegosPlayStationPS1    |
| videojuegos  | PlayStation  | PS2           | $this->videojuegosPlayStationPS2    |
| videojuegos  | PlayStation  | PS3           | $this->videojuegosPlayStationPS3    |
| videojuegos  | PlayStation  | PS4           | $this->videojuegosPlayStationPS4    |
| videojuegos  | PlayStation  | PS5           | $this->videojuegosPlayStationPS5    |
| videojuegos  | Xbox         | Xbox          | $this->videojuegosXboxXbox          |
| videojuegos  | Xbox         | Xbox360       | $this->videojuegosXboxXbox360       |
| videojuegos  | Xbox         | XboxOne       | $this->videojuegosXboxXboxOne       |
| videojuegos  | Xbox         | XboxSeriesXS  | $this->videojuegosXboxXboxSeriesXS  |
| videojuegos  | Nintendo     | Nintendo64    | $this->videojuegosNintendoNintendo64|
| videojuegos  | Nintendo     | GameCube      | $this->videojuegosNintendoGameCube  |
| videojuegos  | Nintendo     | Wii           | $this->videojuegosNintendoWii       |
| videojuegos  | Nintendo     | Switch        | $this->videojuegosNintendoSwitch    |

---

 **Ejemplo de uso en la vista:**
```php
<?php renderProductosPrincipal($this->consolasPlayStationPS1); ?>
<?php renderProductosPrincipal($this->videojuegosXboxXbox360); ?>
<?php renderProductosPrincipal($this->consolasNintendoSwitch); ?>
```

 **Nota:**  
Si agregas más marcas o modelos en el array `$categorias`, se generarán automáticamente más variables siguiendo este mismo patrón.

 **/

class CtrlPaginaPrincipal
{
  private $vista = __DIR__ . "/../view/principal.php";
  private $css = __DIR__ . "/../css/principal.css";
  private $js = __DIR__ . "/../js/principal.js";
  public $model;
  public $opciones = [
    ["nombre" => ICON_PEDIDOS, "href" => "#", "id" => "pedidos"],
    ["nombre" => ICON_HISTORIAL_COMPRAS, "href" => "#", "id" => "historial-compras"],
    ["nombre" => ICON_CARRITO, "href" => "#", "id" => "carrito"],
    ["nombre" => ICON_INICIAR_SESION, "href" => SITE_URL . "login", "id" => "login"]
  ];
  public $title = "Principal";

  public function __construct()
  {
    $model = new Model();

    // Definir categorías y subcategorías
    $categorias = [
      'consolas' => [
        'PlayStation' => ['PS1', 'PS2', 'PS3', 'PS4', 'PS5'],
        'Xbox' => ['Xbox', 'Xbox360', 'XboxOne', 'XboxSeriesXS'],
        'Nintendo' => ['Nintendo64', 'GameCube', 'Wii', 'Switch']
      ],
      'videojuegos' => [
        'PlayStation' => ['PS1', 'PS2', 'PS3', 'PS4', 'PS5'],
        'Xbox' => ['Xbox', 'Xbox360', 'XboxOne', 'XboxSeriesXS'],
        'Nintendo' => ['Nintendo64', 'GameCube', 'Wii', 'Switch']
      ]
    ];

    // Poblar dinámicamente las propiedades
    foreach ($categorias as $tipo => $marcas) {
      foreach ($marcas as $marca => $modelos) {
        foreach ($modelos as $modelo) {
          $prop = "{$tipo}" . ucfirst($marca) . $modelo;
          $condicion = "categoria1='" . ucfirst($tipo) . "' AND categoria2='$marca' AND categoria3='$modelo'";
          $this->$prop = $model->seleccionaRegistros(
            "productos",
            ["*"],
            $condicion
          );
        }
      }
    }
  }

  public static function busquedaProducto($query)
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "productos",
      ["*"],
      "nombre LIKE '%$query%'"
    );
  }

  public function renderContent()
  {
    include $this->vista;
  }

  public function renderCSS()
  {
    include $this->css;
  }

  public function renderJS()
  {
    include $this->js;
  }
}
