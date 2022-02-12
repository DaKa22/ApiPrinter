<?php

use Mike42\Escpos\Printer;


try {
    try {
        include_once('../modelo/head.php');
        foreach ($_POST['elementos'] as $key => $elemento) {
            if ($elemento['valor']==null) {
                $printer->{$elemento['metodo']}();
            }else{
                $printer->{$elemento['metodo']}($elemento['valor']);
            }
        }
    
        $printer->text("\n");
        $printer->cut();
    } finally{
        $printer->close();
    }
} catch (Exception $th) {
    return var_dump([
        'STATUS'=> 'ERROR',
        'MENSAJE 1'=>'ERROR EN LA API DE IMPRESION (TIQUETE)',
        'MENSAJE 2'=> $th
    ]);
}


?>