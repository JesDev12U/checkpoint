
<?php
require_once __DIR__ . "/../../../model/Model.php";


# Variables dinámicas generadas en `CtrlGestorProductos`

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
<?php renderTablaProductos($this->consolasPlayStationPS1); ?>
<?php renderTablaProductos($this->videojuegosXboxXbox360); ?>
<?php renderTablaProductos($this->consolasNintendoSwitch); ?>
```

 **Nota:**  
Si agregas más marcas o modelos en el array `$categorias`, se generarán automáticamente más variables siguiendo este mismo patrón.

 **/
class CtrlGestorProductos
{
  const VISTA = __DIR__ . "/../../../view/empleado/gestor_productos/gestor_productos.php";
  const CSS = __DIR__ . "/../../../css/empleado/gestor_productos.css";
  const JS = __DIR__ . "/../../../js/empleado/gestor_productos.js";

  // Opciones de menú y título
  public $opciones = [
    ["nombre" => ICON_HOME, "href" => SITE_URL . RUTA_EMPLEADO, "id" => "home"]
  ];
  public $title = "Productos";

  // Propiedades para productos (se llenan dinámicamente)
  // Ejemplo: $this->consolasPlayStationPS1, $this->videojuegosXboxXbox360, etc.

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

  public function renderContent()
  {
    include self::VISTA;
  }

  public function renderCSS()
  {
    include self::CSS;
  }

  public function renderJS()
  {
    include self::JS;
  }
}
