<?php
require_once "./vendor/autoload.php";

use App\App;

if (!defined('CONFIG_DIR')) {
	define('CONFIG_DIR', realpath(__DIR__) . '/configs');
}

if (!defined('MIGRATION_DIR')) {
	define('MIGRATION_DIR', realpath(__DIR__) . '/Migrations');
}

$app = new App([
	MIGRATION_DIR . '/create_table_esp1.php'
]);