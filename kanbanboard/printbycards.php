<?php

/*$l=print_r(json_decode($_POST['arrayIds']),true);

file_put_contents("logs.txt", $l,FILE_APPEND);
*/



session_start();
// Include the main TCPDF library (search for installation path).
require_once 'tcpdf_include.php';
require_once './classes/Connection.php';  
require_once './classes/Usuario.php';  
require_once './classes/UsuarioDao.php';  
require_once './classes/Lista.php';
require_once './classes/Tarjeta.php';
require_once './classes/Tablero.php';
require_once './classes/Sesion.php';


//$tarjetas=json_decode($_POST['arrayIds']);
$tarjetas=explode(',',$_GET['arrayIds']);

$username = $tarjetas[0];
$idBoard  = $tarjetas[1];


// Get token from mysql database

$conn = new Connection();
$usuarioDao = new UsuarioDao($conn->getConexion());
$oUser=$usuarioDao->findByUserName($username);

//$sesion = new sesion();
//$tokenSesion = $sesion->get("auth_token");
//$idBoard = $_GET['idBoard'];



// Put your key and secret provided by Trello. https://trello.com/1/appKey/generate 

define("CONSUMER_KEY", "dc0af7e595488131774490357b151087");
define("CONSUMER_SECRET", "c3ce066cc3444631b3311e11062787785b4cfb153b0ede191ae36c77aa303e7b");

$oauth = new OAuth(CONSUMER_KEY, CONSUMER_SECRET);
$oauth->disableSSLChecks();

$oauth->setToken($oUser->getOauth_token(), "");

// Search the name of the board

//$data = json_decode($oauth->getLastResponse());
//$boardName=$data->name;

$boardName=$idBoard;

// Create an array of the cards retrieved by the API
//$oauth->fetch("https://trello.com/1/boards/" . $idBoard . "/cards", array(), OAUTH_HTTP_METHOD_GET);

// $oauth->fetch("https://trello.com/1/lists/" . $idLista. "/cards", array(), OAUTH_HTTP_METHOD_GET);

$arrTarjetas=array();

for ($index = 2; $index < count($tarjetas); $index++) {
  $oauth->fetch("https://trello.com/1/cards/" . $tarjetas[$index], array(), OAUTH_HTTP_METHOD_GET);
  $objTarjeta = json_decode($oauth->getLastResponse());
  
  $arrTarjetas[]=$objTarjeta;

}



// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
/* $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Nicola Asuni');
  $pdf->SetTitle('TCPDF Example 005');
  $pdf->SetSubject('TCPDF Tutorial');
  $pdf->SetKeywords('TCPDF, PDF, example, test, guide'); */

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 005', PDF_HEADER_STRING);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// remove default header/footer
$pdf->setPrintHeader(false);

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
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
   require_once(dirname(__FILE__) . '/lang/eng.php');
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
$pdf->SetFillColor(255, 255, 255);

$style = array(
    'border' => 0,
    'padding' => 0,
        //'fgcolor' => array(0,0,255),
        //'bgcolor' => array(255,255,64)
);

// Multicell test

$columna = 0;
$renglon = 0;
$x = 10;
$y = 5;


//   foreach ($tarjetas as $oTarjeta) {
for ($index = 0; $index < count($arrTarjetas); $index++) {

  $data=$arrTarjetas[$index];

   //$label = unserialize($oTarjeta);

   // set color for background
   //$pdf->SetFillColor(255,255,255);
   //$pdf->setTextColor(0,0,0);
  
   $pdf->MultiCell(87, 87, '', 1, 'L', 1, 0, $x, $y, true); // Este es el postit en si
   //$pdf->SetFillColor(0,102,0);
   //$pdf->SetFillColor(255,255,255);
   //$pdf->setTextColor(255,255,255);

   $pdf->SetFont('timesB', '', 12);
   // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

   $pdf->SetFillColor(0, 102, 0);
   $pdf->setTextColor(255, 255, 255);
   $pdf->MultiCell(35, 10, $boardName, 1, 'L', 1, 0, $x + 2, $y + 5, true); // Nombre del Tablero

   $pdf->SetFillColor(255, 255, 255);
   $pdf->setTextColor(0, 0, 0);
   $pdf->MultiCell(35, 60, $data->name, 1, 'L', 1, 0, $x + 2, $y + 20, true); // descripcion del Ticket
   $pdf->SetFont('times', '', 10);

   // $pdf->MultiCell(50, 38, $label->getDescripcion(), 0, 'L', 1, 0, $x+15, $y+55, true); // Descripcion del Ticket
   // $pdf->SetFont('timesB', '', 10);
   // Enviamos el codigo QR
   $pdf->write2DBarcode($data->shortUrl, 'QRCODE,Q', $x + 40, $y + 6, 46, 46, $style, 'N');

   // Numero de Ticket
   //$pdf->SetFillColor(0, 102, 0);
   //$pdf->setTextColor(255, 255, 255);
   //$pdf->MultiCell(40, 5, "Card # " . $data->idShort, 1, 'L', 1, 0, $x + 45, $y + 50, true); // Numero de Ticket

   //$pdf->SetFillColor(255, 255, 255);
   //$pdf->setTextColor(0, 0, 0);
   //$pdf->SetFont('times', '', 10);
   //$pdf->MultiCell(25, 5, date('d-m-Y H:i:s', strtotime($data->dateLastActivity)), 0, 'L', 1, 0, $x + 60, $y + 75, true); // Fecha
   // $pdf->MultiCell(25, 5, 'Posted By', 1, 'L', 1, 0, $x+60, $y+50, true); // Posted By
   // Enviamos el codigo QR
   // $pdf->write2DBarcode($label->getUrl(), 'QRCODE,Q', $x+60, $y+58, 25, 25, $style, 'N');

   $columna+=1;

   $x+=100;


   if ($columna == 2) {
      $renglon+=1;
      $columna = 0;
      $x = 10;
      $y+=90;
      $pdf->Ln(4);
   }

   if ($renglon == 3) {
      $columna = 0;
      $renglon = 0;
      $x = 10;
      $y = 5;
      $pdf->AddPage();
   }
}

//Close and output PDF document
$pdf->Output('physicalTrello.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>
