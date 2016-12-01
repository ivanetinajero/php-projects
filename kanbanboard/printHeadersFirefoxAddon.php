<?php     
   require_once 'tcpdf_include.php';
   require_once './classes/Lista.php';
   require_once './classes/Connection.php';  
   require_once './classes/Usuario.php';  
   require_once './classes/UsuarioDao.php';

   $idCard=$_GET['idCard'];
   $username=$_GET['username'];
   
   define("CONSUMER_KEY", "dc0af7e595488131774490357b151087");
   define("CONSUMER_SECRET", "c3ce066cc3444631b3311e11062787785b4cfb153b0ede191ae36c77aa303e7b");

   $oauth = new OAuth(CONSUMER_KEY, CONSUMER_SECRET);
   $oauth->disableSSLChecks(); 
   
   $conn = new Connection();
   $usuarioDao = new UsuarioDao($conn->getConexion());
   $oUser=$usuarioDao->findByUserName($username);   
   
   $oauth->setToken($oUser->getOauth_token(),""); 
      
   // Look for idBoard
   $oauth->fetch("https://trello.com/1/cards/".$idCard."/board", array(), OAUTH_HTTP_METHOD_GET);
   $data = json_decode($oauth->getLastResponse());
   $idBoard=$data->id;
   $boardName=$data->name;

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
    
   
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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
$numcolumnasDelTablero=count($listas);

$datosQrTablero='['.$idBoard.','.$numcolumnasDelTablero.']';

// Enviamos el codigo QR
$pdf->write2DBarcode($datosQrTablero, 'QRCODE,Q', $x+14, $y+5, 64, 64, $style, 'N');

$pdf->setTextColor(0,0,0);
$pdf->SetFont('times', '', 18);

$pdf->MultiCell(60, 20, "Board - ".$boardName, 0, 'C', 1, 0, $x+16, $y+67, true); // Titulo del Ticket


$columna+=1;

$x+=100;

$arrListas=array();


if(count($listas)>0){
    $arrListas[0]=$username;
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
   
   $pdf->MultiCell(87, 87, '', 1, 'L', 1, 0, $x, $y, true); // Este es el postit en si


   if($id==0){
       $pdf->write2DBarcode('|'.$username.'|', 'QRCODE,Q', $x+14, $y+5, 64, 64, $style, 'N');
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
$pdf->Output('headers.pdf', 'I');

?>
