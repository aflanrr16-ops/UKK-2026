<?php
/*
|--------------------------------------------------------------------------
| Batara Framework
|--------------------------------------------------------------------------
| Satu-satunya file yang boleh diakses langsung dari browser.
| Arahkan document root web server ke folder public/ ini.
*/

define('BATARA_START', microtime(true));
define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/core/bootstrap.php';

(new Batara\Application(BASE_PATH))->run();
