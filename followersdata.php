<?php
//setting header to json
header('Content-Type: application/json');

require_once "./vendor/autoload.php";

use App\Database;
use App\Response;

if (!defined('CONFIG_DIR')) {
	define('CONFIG_DIR', realpath(__DIR__) . '/configs');
}

if (!defined('MIGRATION_DIR')) {
	define('MIGRATION_DIR', realpath(__DIR__) . '/Migrations');
}

$db = Database::boot();
$response = Response::boot();

if (isset($_GET['migrate'])) {
	$db->migrate([
		MIGRATION_DIR . '/create_table_esp1.php'
	]);
}

print_r($db->query('SHOW TABLES')->get());

echo $response->json_response($db->query('SELECT date1, temp, hum from esp1')->get(), 200);