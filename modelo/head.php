<?php
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
include_once('../modelo/coneccion.php');

$printer->setJustification(Printer::JUSTIFY_CENTER);
$logo = EscposImage::load('./../src/img/logo-dark.png', false);
$printer->bitImage($logo);
$printer->text("\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);


?>