<?php
/**
 * Description of List
 *
 * @author itinajero
 */
class Lista {
   //put your code here
   private $id;
   private $nombre;
   private $idTablero;
   private $noColumn;
   
   function __construct($id) {
      $this->id = $id;
   }

   public function getId() {
      return $this->id;
   }

   public function getNombre() {
      return $this->nombre;
   }

   public function getIdTablero() {
      return $this->idTablero;
   }

   public function setId($id) {
      $this->id = $id;
   }

   public function setNombre($nombre) {
      $this->nombre = $nombre;
   }

   public function setIdTablero($idTablero) {
      $this->idTablero = $idTablero;
   }

   function getNoColumn() {
       return $this->noColumn;
   }

   function setNoColumn($noColumn) {
       $this->noColumn = $noColumn;
   }

}
