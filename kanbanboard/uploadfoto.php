<?php
header('Content-Type: text/plain; charset=utf-8');



EXTRACT($_POST);
EXTRACT($_FILES);

//file_put_contents("qrs/data.txt",print_r($_FILES,true));


$allowedTypes = array("image/jpg", "image/png","image/gif","image/jpeg");

$temp = explode(".", $_FILES["attachment-1"]["type"]);

$uploadType = end($temp);

$nombreArchivo=$_FILES['attachment-1']['name'];
$extension=end(explode(".", $nombreArchivo));

if(in_array($uploadType, $allowedTypes)){
    
    $ext=".".$extension;
    
    // The complete path/filename 

    $filename = 'FTP_IMPORT_DIR/' . time() . $_SERVER['REMOTE_ADDR'] . $ext; 

    //echo $filename;

    // Copy the file (if it is deemed safe) 


//    if (!is_uploaded_file($_FILES['attachment-1']['tmp_name']) ||  
//            !copy($_FILES['attachment-1']['tmp_name'], $filename)) { 
    if (!is_uploaded_file($_FILES['attachment-1']['tmp_name']) ||  
            !copy($_FILES['attachment-1']['tmp_name'], $filename)) { 

        $error = "Could not  save file as $filename!"; 

        //include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php'; 

        exit(); 
    }else{
        // Ajustamos la calidad de la imagen
        shell_exec('mogrify -quality 100 '.$filename);
    }
}else{
    
    echo "Archivo no permitido";
}




?>
