<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, X-CSRF-Token, X-CSRF-TOKEN");
header('Access-Control-Allow-Methods: GET, GET, PUT, DELETE');

header('content-type: application/json; charset=utf-8');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/src/LucidFrame/Console/ConsoleTable.php'; //Nota: si renombraste la carpeta a algo diferente de "vendor" cambia el nombre en esta línea

date_default_timezone_set("America/Bogota");

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// use LucidFrame\Console\ConsoleTable.php;

$nombre_impresora = "pos"; 

$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);

//PARA IMPRIMIR TODO CENTRADO
$printer->setJustification(Printer::JUSTIFY_CENTER);

$logo = EscposImage::load('img/logo.png', false);

$printer->bitImage($logo);
$printer->text('1193429241 - 3'."\n");
$printer->text('Regimen Simplificado - 3'."\n");
$printer->text('Sucursal: '.$_POST['sucursal']." \n\n");

//Se construye una tabla con la informacion de sucursal
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("Fecha Cierre: ".date("d/m/Y")." \n");
$printer->text("Hora Cierre: ".date("H:i:s")." \n");
$printer->text("Numero Ventas: ".$_POST['total']." \n\n");

//PARA IMPRIMIR TODO CENTRADO
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("Detalle de Ventas \n\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);

if($_POST['ventas']) {
    foreach($_POST['ventas'] as $value) {
        foreach ($value['productos'] as $row) {
            $printer->text(
                new item(
                    substr($row['cantidad'].'x '.$row['producto']['nombre'], 0, 35), 
                    '$'.number_format($row['producto']['valor'] * $row['cantidad'])
                )
            );
        }
    }
}

$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("\n\nDetalle de Ventas \n\n");

$printer->setJustification(Printer::JUSTIFY_RIGHT);
$printer->text('Ventas Fisicas: '."\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text(new item('Efectivo : ', '$'.number_format($_POST['ventas_fisicas']['efectivo'])));
$printer->text(new item('Tarjeta: ', '$'.number_format($_POST['ventas_fisicas']['tarjeta'])));
$printer->text(new item('Total: ', '$'.number_format($_POST['ventas_fisicas']['total'])));

$printer->setJustification(Printer::JUSTIFY_RIGHT);
$printer->text('Ventas Domicilio: '."\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text(new item('Efectivo : ', '$'.number_format($_POST['ventas_domicilio']['efectivo'])));
$printer->text(new item('Tarjeta: ', '$'.number_format($_POST['ventas_domicilio']['tarjeta'])));
$printer->text(new item('Total: ', '$'.number_format($_POST['ventas_domicilio']['total'])));

$printer->setJustification(Printer::JUSTIFY_RIGHT);
$printer->text('Ultimo Cierre: '."\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text(new item('Ultimo Cierre  : ', $_POST['ultimo_cierre']['fecha']));
$printer->text(new item('Hora Cierre: ', $_POST['ultimo_cierre']['hora']));
$printer->text(new item('Numero Ventas: ', $_POST['ultimo_cierre']['numero_ventas']));

$printer->setJustification(Printer::JUSTIFY_RIGHT);
$printer->text('Resumen General: '."\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text(new item('Total Efectivo : ', '$'.number_format($_POST['ventas_total']['efectivo'])));
$printer->text(new item('Total Tarjeta: ', '$'.number_format($_POST['ventas_total']['tarjeta'])));
$printer->text(new item('Total Dia: ', '$'.number_format($_POST['ventas_total']['total'])));

$printer->text("\n\n");

//ALIMENTAMOS IMPRESORA
$printer->feed();

//CORTAMOS EL PAPEL CUANDO TERMINE
$printer->cut();

//ESTE PULSE ES PARA ABRIR LA CAJA LUEGO DE IMPRIMIR LA FACTURA
$printer->pulse(); 

$printer->close();

class item
{
    private $name;
    private $price;
    private $dollarSign;

    public function __construct($name = '', $price = '', $dollarSign = false)
    {
        $this->name = $name;
        $this->price = $price;
        $this->dollarSign = $dollarSign;
    }

    public function __toString()
    {
        $rightCols = 10;
        $leftCols = 34;

        if ($this->dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }

        $left = str_pad($this->name, $leftCols) ;

        $sign = ($this->dollarSign ? '$ ' : '');
        $right = str_pad($sign . $this->price, $rightCols, ' ', STR_PAD_LEFT);

        return "$left$right\n";
    }
}

?>