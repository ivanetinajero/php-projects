<?php
/**
 * Description of Board
 *
 * @author itinajero
 */
class Tablero {
   //put your code here
   private $id;
   private $nombre;
   private $descripcion;
   private $url;
   
   function __construct($id) {
      $this->id = $id;
   }

   public function getId() {
      return $this->id;
   }

   public function getNombre() {
      return $this->nombre;
   }

   public function getDescripcion() {
      return $this->descripcion;
   }

   public function getUrl() {
      return $this->url;
   }

   public function setId($id) {
      $this->id = $id;
   }

   public function setNombre($nombre) {
      $this->nombre = $nombre;
   }

   public function setDescripcion($descripcion) {
      $this->descripcion = $descripcion;
   }

   public function setUrl($url) {
      $this->url = $url;
   }


   
}
