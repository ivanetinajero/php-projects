<?php
require_once 'Tablero.php';

class TableroDao
{

    private $connDb;
    /**
     * Constructor de la clase
     * 
     * @param connDb $connDb conexion a la base de datos abierta
     */
    function __construct($connDb) 
    {
        $this->connDb = $connDb;
    }       
    /**
     * Metodo para insertar un usuario en la base de datos
     * 
     * @param usuario $usuario Objeto usuario
     * 
     * @return type
     */
    function insert($tablero) 
    {    
        $sql="INSERT INTO board values ('0',"        
        ."'".$tablero->getId()."'," 
        ."'".$tablero->getActive()."')";         
        mysqli_query($this->connDb, $sql);                         
        return mysql_insert_id();      
    }
       
}

?>
