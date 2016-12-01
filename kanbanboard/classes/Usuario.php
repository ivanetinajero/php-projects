<?php
/**
 * Description of Usuario
 *
 * @author itinajero
 */
class Usuario {
    //put your code here
    private $id;
    private $username;
    private $oauth_token;
    private $oauth_token_secret;
    private $active="1";
    
    function __construct() {
        
    }
    
    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getOauth_token() {
        return $this->oauth_token;
    }

    function getOauth_token_secret() {
        return $this->oauth_token_secret;
    }

    function getActive() {
        return $this->active;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setOauth_token($oauth_token) {
        $this->oauth_token = $oauth_token;
    }

    function setOauth_token_secret($oauth_token_secret) {
        $this->oauth_token_secret = $oauth_token_secret;
    }

    function setActive($active) {
        $this->active = $active;
    }



}
