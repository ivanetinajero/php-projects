<?php

//Despliega el contenido de una variable en pantalla
//Modo de uso
//despError("Nombre de archivo", entre comillas
//          "Numero de l�nea donde se inserta la funci�n",
//          Nombre de la Variable
//          "pre", si se quiere que la ejecuci�n del script contin�e; si se deja en blanco, el script se detiene.
//          )
//Por ejemplo: despError("AppRegistro","12",$Variable,"pre")
function despError($archivo,$Linea,$Variable,$TipoSalida="die"){
    //$salida ="<pre>File: $archivo  Line: $Linea  NombreVariable:{$Variable}\n".print_r($Variable,true)."</PRE>\n";
    if ($TipoSalida=="die"){
    echo "<pre> File: $archivo  Line: $Linea \n";
      print_r($Variable);
    echo "</pre>";
    die();
    } else{
        echo "<pre> File: $archivo  Line: $Linea \n";
      print_r($Variable);
    echo "</pre>";
    }
}

?>
