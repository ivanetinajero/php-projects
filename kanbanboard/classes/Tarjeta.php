<?php
/**
 * Description of Card
 *
 * @author itinajero
 */
class Tarjeta {
   //put your code here
   private $id;
   private $nombre;
   private $descripcion;
   private $url;
   private $fechaCreacion;
   private $idLista;
   private $noColumn;
   private $shortLink;
   
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

   public function getFechaCreacion() {
      return $this->fechaCreacion;
   }

   public function getIdLista() {
      return $this->idLista;
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

   public function setFechaCreacion($fechaCreacion) {
      $this->fechaCreacion = $fechaCreacion;
   }

   public function setIdLista($idLista) {
      $this->idLista = $idLista;
   }

   function getNoColumn() {
       return $this->noColumn;
   }

   function setNoColumn($noColumn) {
       $this->noColumn = $noColumn;
   }
   
   function getShortLink() {
       return $this->shortLink;
   }

   function setShortLink($shortLink) {
       $this->shortLink = $shortLink;
   }

  
}
