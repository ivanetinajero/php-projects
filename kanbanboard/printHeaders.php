<?php

  session_start();
  // Include the main TCPDF library (search for installation path).
  require_once 'tcpdf_include.php';
  
    if (isset($_GET['idBoard'])) {
      
      
      require_once 'classes/Sesion.php';  
      require_once 'classes/Lista.php';
      require_once 'classes/Tarjeta.php';
      require_once 'classes/Tablero.php';

      require_once 'Hhelp.php';

      $sesion = new sesion();
      $sesion->set("idBoard", $_GET['idBoard'] );
      $tokenSesion= $sesion->get("auth_token");

      /*session_start();
      $_SESSION['idBoard'] = $_GET['idBoard'];
      echo "Paso :: ".$_SESSION['idBoard'];*/

      // echo "Si Paso Ver al final... del Form -> ".$sesion->get('idBoard');

       try {
            // Put your key and secret provided by Trello. https://trello.com/1/appKey/generate 
            define("CONSUMER_KEY", "dc0af7e595488131774490357b151087");
            define("CONSUMER_SECRET", "c3ce066cc3444631b3311e11062787785b4cfb153b0ede191ae36c77aa303e7b");

            $oauth = new OAuth(CONSUMER_KEY, CONSUMER_SECRET);
            $oauth->disableSSLChecks(); 

            //$oauth->setToken("9b1405382df181210a775c807d42da1312648d356ce25e7c1cd45f2ea0132f47","58e3ed927313788241e500c2c33bee97"); 
            $oauth->setToken($tokenSesion,""); 

            /**
             * Trello API Operations 
             */
            // Read all lists from an idBoard
            $idBoard=$sesion->get('idBoard');
            $oauth->fetch("https://trello.com/1/boards/".$idBoard."/lists", array(), OAUTH_HTTP_METHOD_GET); 

            //$oauth->fetch("https://trello.com/1/boards/".$idBoard."/cards", array(), OAUTH_HTTP_METHOD_GET);            

            $data = json_decode($oauth->getLastResponse());

            // Get name columns of the board
            $listas = array();
            $n = 0;

            for ($index = 0; $index < count($data); $index++) {    
               //Obj Categoria

               $oLista = new Lista($data[$index]->id);
               $oLista->setNombre($data[$index]->name);
               $oLista->setIdTablero($data[$index]->idBoard);

               // Empezamos en $n+1, para meter en el cero el login del user.
               $listas[$n+1] = serialize($oLista);
               $n++;
            }

            // Get the cards
            $oauth->fetch("https://trello.com/1/boards/".$idBoard."/cards", array(), OAUTH_HTTP_METHOD_GET); 
            $data = json_decode($oauth->getLastResponse());

            $tarjetas = array();
            $n = 0;
            for ($index = 0; $index < count($data); $index++) {    
               //Obj Categoria

               //$oTarjeta = new Tarjeta($data["cards"][$index]["id"]);
               $oTarjeta = new Tarjeta($data[$index]->idShort);
               $oTarjeta->setNombre($data[$index]->name);
               $oTarjeta->setDescripcion($data[$index]->desc);
               $oTarjeta->setUrl($data[$index]->shortUrl);
               $oTarjeta->setFechaCreacion($data[$index]->dateLastActivity);
               $oTarjeta->setIdLista($data[$index]->idList);

               $tarjetas[$n] = serialize($oTarjeta);
               $n++;
            }

            // Get the Board info
            $oauth->fetch("https://trello.com/1/boards/".$idBoard, array(), OAUTH_HTTP_METHOD_GET); 
            $data = json_decode($oauth->getLastResponse());


            $oTablero=new Tablero($data->id);
            $oTablero->setNombre($data->name);
            $oTablero->setUrl($data->url);

            // Put objects into a session
            // $sesion = new sesion();
            $sesion->set("lstLista", serialize($listas));
            $sesion->set("lstTarjeta", serialize($tarjetas));
            $sesion->set("tablero", serialize($oTablero));

            /*****************************************************
             * End objects Tablero, Listas y Tarjetas            *
             ****************************************************/  
            // Obtenemso el id de usuario
            
            $oauth->fetch("https://trello.com/1/members/me", array(), OAUTH_HTTP_METHOD_GET);
            $data = json_decode($oauth->getLastResponse());
            
            $usuarioTrello=$data->username;

        } catch(OAuthException $E) {
            echo "Response: ". $E->getMessage(). "\n";
        }

    }

  
  
  
  // Ya no necesito ir a Trello, ya en este punto tendremos en sesion las tarjetas, solo seria cuestion de 
  // Recorrer la lista y generar el pdf con los encabezdos qr
  
  //$sesion = new sesion();
    
  $listas = unserialize($sesion->get("lstLista"));
  $tarjetas = unserialize($sesion->get("lstTarjeta"));
  $tablero = unserialize($sesion->get("tablero"));
  
  
   
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  
  
// set document information
/*$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 005');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');*/

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 005', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// remove default header/footer
$pdf->setPrintHeader(false);
//$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 10);

// add a page
$pdf->AddPage();

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
$pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255,255,255);


$style = array(
    'border' => 0,
    'padding' => 0,
    //'fgcolor' => array(0,0,255),
    //'bgcolor' => array(255,255,64)
);


// Enviaremos en un renglon el header del tablero con

$columna=0;$renglon=0;
$x=10;$y=5;


$pdf->SetFont('timesB', '', 10);
   
// $pdf->SetFillColor(0,102,0);
$pdf->setTextColor(255,255,255);

$pdf->MultiCell(87, 87, '', 1, 'L', 1, 0, $x, $y, true); // Este es el postit en si

$oTablero=  unserialize($tablero);
$numcolumnasDelTablero=count($listas);
$idTableroDecimal=$tablero->getId();
$datosQrTablero='['.$idTableroDecimal.','.$numcolumnasDelTablero.']';

// Enviamos el codigo QR
$pdf->write2DBarcode($datosQrTablero, 'QRCODE,Q', $x+14, $y+5, 64, 64, $style, 'N');

$pdf->setTextColor(0,0,0);
$pdf->SetFont('times', '', 18);

$pdf->MultiCell(60, 20, "Board - ".$tablero->getNombre(), 0, 'C', 1, 0, $x+16, $y+67, true); // Titulo del Ticket


$columna+=1;

$x+=100;

$arrListas=array();


if(count($listas)>0){
    $arrListas[0]=$usuarioTrello;
}

foreach ($listas as $id=>$olista) {
    $lista = unserialize($olista);
    $arrListas[$id]=$lista->getNombre();
}

if(count($listas)>0){
    $arrListas[$id+1]="End";
}


// foreach ($listas as $olista) {
foreach ($arrListas as $id=>$lista) {

   
   // $lista = unserialize($olista);

   // set color for background
   //$pdf->SetFillColor(255,255,255);
   
   $pdf->MultiCell(87, 87, '', 1, 'L', 1, 0, $x, $y, true); // Este es el postit en si


   if($id==0){
       $pdf->write2DBarcode('|'.$usuarioTrello.'|', 'QRCODE,Q', $x+14, $y+5, 64, 64, $style, 'N');
       $pdf->MultiCell(60, 20, "Usuario", 0, 'C', 1, 0, $x+18, $y+67, true); // Titulo del Ticket
   }else{
   
    // Enviamos el codigo QR
    $pdf->write2DBarcode('__', 'QRCODE,Q', $x+14, $y+5, 64, 64, $style, 'N');
  
    // $pdf->Image('img/qrcolumna.jpg', $x+20, $y+5, 55, 55);
    // $pdf->MultiCell(60, 20, $lista->getNombre(), 1, 'C', 1, 0, $x+16, $y+65, true); // Titulo del Ticket
    $pdf->MultiCell(60, 20, $lista, 0, 'C', 1, 0, $x+18, $y+67, true); // Titulo del Ticket
   }
   
   $columna+=1;
  
   $x+=100;


   if($columna==2){
    $renglon+=1;
    $columna=0;
    $x=10;
    $y+=90;
    $pdf->Ln(4);
   }

   if($renglon==3){
    $columna=0;
    $renglon=0;
    $x=10;$y=5;
    $pdf->AddPage();
   }
   

}

//Close and output PDF document
$pdf->Output('physicalTrello.pdf', 'I');

// Y enviamos los QR de las columnas con su nombre, eso lo obtenemos de $listas


?>
