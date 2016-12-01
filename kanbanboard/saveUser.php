<?php
    //incluimos la clase
    require_once 'classes/Connection.php';
    require_once 'classes/UsuarioDao.php';
    require_once 'classes/Usuario.php';
    require_once 'classes/Sesion.php';
    try {   
        header("Content-type:text/plain ");
        EXTRACT($_POST);   
        // Save Access Token and username to database.
        $conn = new Connection();
        $usuarioDao = new UsuarioDao($conn->getConexion());
        $usuario = new Usuario();
        $usuario->setId(0);
        $usuario->setUsername($username);
        $usuario->setOauth_token($token);
        $usuario->setOauth_token_secret("");
        $response=$usuarioDao->insert($usuario);
        
        if ($response==1){
            // Put the username and token in a session variable in order to use it throughout application
            $sesion = new sesion();
            $sesion->set("username", $usuario->getUsername);
            $sesion->set("auth_token", $usuario->getOauth_token());
        }
        echo $response;
        
    } catch (Exception $e) {
       echo "error";
    }
?>