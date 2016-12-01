<?php
/**
 * Description of Product
 *
 * @author itinajero
 */
class Product {
   private $id;
   private $description;
   private $price;
   private $buyDate;
   private $stock;
  
   function __construct($id) {
      $this->id = $id;
   }
  
   public function getId() {
      return $this->id;
   }

   public function getDescription() {
      return $this->description;
   }

   public function getPrice() {
      return $this->price;
   }

   public function getBuyDate() {
      return $this->buyDate;
   }

   public function getStock() {
      return $this->stock;
   }

   public function setId($id) {
      $this->id = $id;
   }

   public function setDescription($description) {
      $this->description = $description;
   }

   public function setPrice($price) {
      $this->price = $price;
   }

   public function setBuyDate($buyDate) {
      $this->buyDate = $buyDate;
   }

   public function setStock($stock) {
      $this->stock = $stock;
   }



}
