<?php
require_once 'Product.php';
/**
 * Description of ProductDao
 *
 * @author itinajero
 */
class ProductDao {
  
    private $_connDb;
   
    function __construct($connDb) 
    {
        $this->_connDb = $connDb;
    }   
    
    function findByPagination($start, $limit) {
      $productList = array();

      $sql = "select id,description,price,buyDate,stock from Product order by id desc limit ". $start .",". $limit;
      
      $rs = mysqli_query($this->_connDb, $sql);
      $n = 0;

      while ($row = mysqli_fetch_array($rs)) {
         // Icono
         $objProduct = new Product($row['id']);
         $objProduct->setDescription($row['description']);
         $objProduct->setPrice($row['price']);
         $objProduct->setBuyDate($row['buyDate']);
         $objProduct->setStock($row['stock']);

         $productList[$n] = $objProduct;
         $n++;
      }
      return $productList;
   }
   
   function countAll() {
      $sql = "select count(*) as total from Product"; 
      $rs = mysqli_query($this->_connDb, $sql);
      while ($row = mysqli_fetch_array($rs)) {
         $count = $row['total'];
      }
      return $count;
   }

}