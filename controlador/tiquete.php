<?php
use Mike42\Escpos\Printer;
try {
    include_once('../modelo/head.php');
    foreach ($_POST['elementos'] as $key => $elemento) {
        if ($elemento['valor']==null) {
            $printer->{$elemento['metodo']}();
        }else{
            if (is_array($elemento['valor'])) {
                switch (count($elemento['valor'])) {
                    case 2:
                        $printer->{$elemento['metodo']}($elemento['valor'][0],$elemento['valor'][1]);
                        break;
                    case 3:
                        $printer->{$elemento['metodo']}($elemento['valor'][0],$elemento['valor'][1],$elemento['valor'][2]);
                        break;
                    case 4:
                        $printer->{$elemento['metodo']}($elemento['valor'][0],$elemento['valor'][1],$elemento['valor'][2],$elemento['valor'][3]);
                        break;
                    default:
                        // $printer->text("\n");
                        $printer->cut();
                        $printer->close();
                        break;
                }
            } else {
                $printer->{$elemento['metodo']}($elemento['valor']);
            }
            
        }
    }
    // $printer->text("\n");
    $printer->cut();
}catch (Exception $th) {
    return var_dump([
        'STATUS'=> 'ERROR',
        'MENSAJE 1'=>'ERROR EN LA API DE IMPRESION (TIQUETE)',
        'MENSAJE 2'=> $th
    ]);
}finally{
    $printer->close();
}



?>