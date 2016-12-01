<?php

  require_once 'Connection.php';
  require_once 'Product.php';   
  require_once 'ProductDao.php';   
   
  $pageNum = $_GET['page'];  
  $pageSize = $_GET['rows']; 
  
  $conn = new Connection();
  $productoDao = new ProductDao($conn->getConnection());  
  
  $count = $productoDao->countAll(); 
  if( $count >0 ) {
       $total_pages = ceil($count/$pageSize);
  } 
  else {
       $total_pages = 0;
  }
  if ($pageNum > $total_pages) 
     $pageNum=$total_pages;
  
  $start = $pageSize*$pageNum - $pageSize; 
  
  $response->pageNum = $pageNum; 
  $response->pageSize = $pageSize;
  $response->totalRecords = $count; 
  $response->totalPages = $total_pages; 
  
  $resultSet = $productoDao->findByPagination($start, $pageSize);
  
  $i=0;
  foreach($resultSet as $product) {
     
     $response->rows[$i]['id']=$product->getId(); 
     $response->rows[$i]['cell']=array(
         $product->getId(),
         $product->getDescription(),
         $product->getPrice(),
         $product->getBuyDate(),         
         $product->getStock(),         
     );    
     $i++;                   
  } 
  echo json_encode($response);