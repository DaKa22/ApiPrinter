<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, X-CSRF-TOKEN");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

header('content-type: application/json; charset=utf-8');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/src/LucidFrame/Console/ConsoleTable.php'; //Nota: si renombraste la carpeta a algo diferente de "vendor" cambia el nombre en esta línea

date_default_timezone_set("America/Bogota");

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$nombre_impresora = "POS"; 

$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
$jsonData = file_get_contents("php://input");
$_POST = json_decode($jsonData,true);
?>