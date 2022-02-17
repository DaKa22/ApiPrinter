<?php
include_once('../modelo/head.php');
use Mike42\Escpos\Printer;

/* Text of various (in-proportion) sizes */
// title($printer, "Change height & width\n");
// for ($i = 1; $i <= 8; $i++) { $printer->setTextSize($i, $i);
//     $printer->text($i);
//     }
//     $printer->text("\n");
//     /* Width changing only */
//     title($printer, "Change width only (height=4):\n");
//     for ($i = 1; $i <= 8; $i++) { $printer->setTextSize($i, 4);
//         $printer->text($i);
//         }
//         $printer->text("\n");
//         /* Height changing only */
//         title($printer, "Change height only (width=4):\n");
//         for ($i = 1; $i <= 8; $i++) { $printer->setTextSize(4, $i);
//             $printer->text($i);
//             }
//             $printer->text("\n");
//             /* Very narrow text */
//             title($printer, "Very narrow text:\n");
//             $printer->setTextSize(1, 8);
//             $printer->text("The quick brown fox jumps over the lazy dog.\n");
//             /* Very flat text */
//             title($printer, "Very wide text:\n");
//             $printer->setTextSize(4, 1);
//             $printer->text("Hello world!\n");
//             /* Very large text */
//             title($printer, "Largest possible text:\n");
//             $printer->setTextSize(8, 8);
//             $printer->text("Hello\nworld!\n");
//             $printer->cut();
//             $printer->close();
//             function title(Printer $printer, $text)
//             {
//             // $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
//             $printer->text("\n" . $text);
//             $printer->selectPrintMode();
//             // Reset
//             }
/* Line spacing */
/*
$printer -> setEmphasis(true);
$printer -> text("Line spacing\n");
$printer -> setEmphasis(false);
foreach(array(16, 32, 64, 128, 255) as $spacing) {
    $printer -> setLineSpacing($spacing);
    $printer -> text("Spacing $spacing: The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog.\n");
}
$printer -> setLineSpacing(); // Back to default
*/
/* Stuff around with left margin */
$printer->setEmphasis(true);
$printer->text("Left margin\n");
$printer->setEmphasis(false);
$printer->text("Default left\n");
foreach (array(1, 2, 4, 8, 16, 32, 64, 128, 256, 512) as $margin) {
    $printer->setPrintLeftMargin($margin);
    $printer->text("left margin {$margin}\n");
}
/* Reset left */
$printer->setPrintLeftMargin(0);
/* Stuff around with page width */
$printer->setEmphasis(true);
$printer->text("Page width\n");
$printer->setEmphasis(false);
$printer->setJustification(Printer::JUSTIFY_RIGHT);
$printer->text("Default width\n");
foreach (array(512, 256, 128, 64) as $width) {
    $printer->setPrintWidth($width);
    $printer->text("page width {$width}\n");
}
/* Printer shutdown */
$printer->cut();
$printer->close();
?>
