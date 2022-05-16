<?php
use Mike42\Escpos\Printer;
try {
    include_once('../modelo/head.php');
    foreach ($_POST['elementos'] as $key => $elemento) {
        if ($elemento['condicion'] == true) {
            $printer->{$elemento['metodo']}(new item(substr($elemento['valor'][0], 0, 19),substr($elemento['valor'][1],0,14),substr($elemento['valor'][2],0,14),$elemento['valor'][3]));

        }else if($elemento['despacho'] == true) {
            $printer->{$elemento['metodo']}(new despacho(substr($elemento['valor'][0], 0, 17),substr($elemento['valor'][1],0,20),substr($elemento['valor'][2],0,10),$elemento['valor'][3]));

        }else{
            if ($elemento['valor'] == null) {
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

    }
    // $printer->text("\n");
    $printer->cut();
}catch (Exception $th) {
    echo json_encode(var_dump([
        'STATUS'=> 'ERROR',
        'MENSAJE 1'=>'ERROR EN LA API DE IMPRESION (TIQUETE)',
        'MENSAJE 2'=> $th
    ]));
}finally{
    $printer->close();
    echo json_encode('Impresion Correcta');
}

class item
{
    private $valor1;
    private $valor2;
    private $valor3;
    private $dollarSign;

    public function __construct($valor1 = '', $valor2 = '',$valor3 = '', $dollarSign = false)
    {
        $this -> valor1 = $valor1;
        $this -> valor2 = $valor2;
        $this -> valor3 = $valor3;
        $this -> dollarSign = $dollarSign;
    }

    public function __toString()
    {
        $rightCols = 14;
        $midCols = 14;
        $leftCols = 20;
        // if ($this -> dollarSign) {
        //     $leftCols = $leftCols / 2 - $midCols / 2 - $rightCols / 2 ;
        // }
        $left = str_pad('|'.$this -> valor1, $leftCols) ;
        // $mid = str_pad(''.$this -> valor2, $midCols) ;

        $sign = ($this -> dollarSign ? '|$' : '|');
        $mid = str_pad($sign . $this -> valor2, $midCols);
        $right = str_pad($sign . $this -> valor3, $rightCols);
        return "$left$mid$right\n";
    }
}

class despacho
{
    private $valor1;
    private $valor2;
    private $valor3;
    private $dollarSign;

    public function __construct($valor1 = '', $valor2 = '',$valor3 = '', $dollarSign = false)
    {
        $this -> valor1 = $valor1;
        $this -> valor2 = $valor2;
        $this -> valor3 = $valor3;
        $this -> dollarSign = $dollarSign;
    }

    public function __toString()
    {
        $rightCols = 10;
        $midCols = 21;
        $leftCols = 17;
        // if ($this -> dollarSign) {
        //     $leftCols = $leftCols / 2 - $midCols / 2 - $rightCols / 2 ;
        // }
        $left = str_pad('|'.$this -> valor1, $leftCols) ;
        // $mid = str_pad(''.$this -> valor2, $midCols) ;

        $sign = ($this -> dollarSign ? '|' : '|');
        $mid = str_pad($sign . $this -> valor2, $midCols);
        $right = str_pad($sign . $this -> valor3, $rightCols);
        return "$left$mid$right\n";
    }
}

?>