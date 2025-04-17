<?php
set_include_path(
  get_include_path() .
    PATH_SEPARATOR . realpath(__DIR__ . '/..') . '/model' .
    PATH_SEPARATOR . realpath(__DIR__ . '/..') . '/controller' .
    PATH_SEPARATOR . realpath(__DIR__ . '/..') . '/classes'
);

define("SITE_URL", "http://localhost/checkpoint");
define("RUTA_EMPLEADO", "empleado/");
define("RUTA_ADMINISTRADOR", "administrador/");
define("RUTA_CERRAR_SESION", "_controller/cerrarSesion.php");
define("DB_HOST", "127.0.0.1");
define("DB_BASE", "checkpointStore");
define("DB_USR", "root");
define("DB_PASS", "Str0ngPassword!");
define("TIMEZONE", "America/Mexico_City");
define("METODO_ENCRIPTACION", "AES-256-CBC");
define("KEY_ENCRIPTACION", "u7<fijrf0AKI./");
