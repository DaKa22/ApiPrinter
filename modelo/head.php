<?php
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
include_once('../modelo/conexion.php');

$printer->setJustification(Printer::JUSTIFY_CENTER);
$logo = EscposImage::load('./../src/img/logo-dark.png', false);
$printer->bitImage($logo);
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->setLineSpacing(10);
$printer->text("\n");


?>