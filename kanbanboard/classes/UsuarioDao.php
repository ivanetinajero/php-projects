<?php
require_once 'Usuario.php';

class UsuarioDao
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
    function insert($usuario) 
    {           
       // Buscamos el usuario en la base de datos, si ya existe, solo actualizamos el nuevo token       
       $oUserDb = $this->findByUserName($usuario->getUsername());
       if ($oUserDb->getId()==0){ // No existe el usuario       
         $sql="INSERT INTO user values ('0',"        
          ."'".$usuario->getUsername()."'," 
          ."'".$usuario->getOauth_token()."',"
          ."'".$usuario->getOauth_token_secret()."',"        
          ."'".$usuario->getActive()."')";         
          $response=mysqli_query($this->connDb, $sql);                         
          
       }
       else{ // Ya existe el usuario, solo actualizamos el token
          $sql="update user set oauth_token = '".$usuario->getOauth_token()."' where id=".$oUserDb->getId();
          $response=mysqli_query($this->connDb, $sql);                         
       }
       return $response;
    }
    
    function findByUserName($userName)
    {      
        $sql="select * from user where username='".$userName."'";  
        
        $userResultSet = mysqli_query($this->connDb, $sql); 
        $oUsuario=new Usuario(0);
        while ($row = mysqli_fetch_array($userResultSet)) 
        {                     
           $oUsuario->setId($row['id']);
           $oUsuario->setUsername($row['username']);           
           $oUsuario->setOauth_token($row['oauth_token']);
           $oUsuario->setOauth_token_secret($row['oauth_token_secret']);
           $oUsuario->setActive($row['active']);
        }
        
        return $oUsuario;
    }
       
}

?>
