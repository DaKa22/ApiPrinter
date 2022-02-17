
## GUIA

    apuntar a esta ruta desde el proyecto del servidor: 
    $respuesta = Http::post('http://localhost/ApiPrinter/controlador/tiquete.php', [
    'elementos' => [
        [
             'metodo' => 'setJustification', //se envia el nombre del metodo como si fuera texto en ''
             'valor' => Printer::JUSTIFY_CENTER, // lo que necesita como parametro se envia plano, si necesita      
              mas de 1 parametro se pasa todo en [] separando parametros con ,
              se esta configrada la API para recibir maximo 4 parametros por metodo, si quiere 
              aumentar el rango tiene que modificar el switch y poner mas casos con su estructura
         ],
         [
             'metodo' => 'selectPrintMode',
             'valor' => Printer::MODE_FONT_B,
         ],
         [
             'metodo' => 'setEmphasis',
             'valor' => true,
         ],
         [
             'metodo' => 'text',
             'valor' => 'NIT: 891.100.299-7' . "\n",
         ],
         [
             'metodo' => 'text',
             'valor' => 'DIR: Av. 26 No. 4-82, Neiva - Huila' . "\n",
         ],
         ejemplo de varios parametros:
         [
             'metodo' => 'qrCode',
             'valor' => [
                base64_encode($datos['id'].';'.$datos['tiquete']), //parametro 1
                Printer::QR_ECLEVEL_M,6,Printer::QR_MODEL_2 //parametro 2
             ]
         ],
       ];
       return $respuesta;

### LIBRERIA

- [mike42/escpos-php](https://github.com/mike42/escpos-php).

## Autor

- [David Bermeo](https://github.com/DaKa22).

