<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, X-CSRF-TOKEN');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');
error_reporting(0);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/src/LucidFrame/Console/ConsoleTable.php'; //Nota: si renombraste la carpeta a algo diferente de 'vendor' cambia el nombre en esta línea

date_default_timezone_set('America/Bogota');

$jsonData = file_get_contents('php://input');
$_POST = json_decode($jsonData,true);

if (
    !(isset($_POST) && isset($_POST['elementos']))
) {
    throw new ErrorException('No existe payload');
}
echo json_encode('aaaa');

$nombre_impresora = 'POS'; 

use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

if ($_POST['os'] == 'Linux' || $_POST['os'] == 'MacOS') {
    $connector = new CupsPrintConnector($nombre_impresora);
} else {
    $connector = new WindowsPrintConnector($nombre_impresora);
}
$printer = new Printer($connector);

?>