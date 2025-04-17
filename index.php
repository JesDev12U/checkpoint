<?php
ini_set('display_errors', E_ALL);
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/config/Global.php";
date_default_timezone_set(TIMEZONE);
include __DIR__ . "/view/master.php";
