$("document").ready(function(){   
   getRecords(1,5);  
   
   $("#nextPage").click(function() {
      var actualPage = parseInt($("#page").html());
      var numRows = parseInt($("#numRows").val());
      var totalPages = parseInt($("#totalPages").html());
      if ((actualPage+1)===totalPages)
         getRecords(totalPages,numRows); 
      else
         getRecords(actualPage+1,numRows); 
   });
   
   $("#prevPage").click(function() {
      var actualPage=parseInt($("#page").html());
      var numRows=parseInt($("#numRows").val());      
      if ((actualPage-1)===0)
         getRecords(1,numRows); 
      else
         getRecords(actualPage-1,numRows); 
   });
   
   $("#firstPage").click(function() {
      var numRows=parseInt($("#numRows").val());  
      getRecords(1,numRows);      
   });
   
   $("#lastPage").click(function() {
      var totalPages = parseInt($("#totalPages").html());      
      var numRows=parseInt($("#numRows").val());  
      
      getRecords(totalPages,numRows);      
   });
   
   $("#numRows").change(function() {         
      var numRows=parseInt($("#numRows").val());  
      var actualPage=parseInt($("#page").html());
      getRecords(actualPage,numRows);      
   });

});

function getRecords(pageParam,rowsParam){
   
   var paginator={
      page:pageParam,
      rows:rowsParam      
   }   
   $.ajax({
      type: "GET",
      url: "php/getListProducts.php",
      data:{ page : paginator.page,
             rows : paginator.rows 
           },
      dataType: "json",
      contentType : 'application/json; charset=utf-8',
      success: function(data) {
          //alert("Respuesta ajax (User) "+data.tipoUsuario);
          
          $("#totalPages").text(data.totalPages);
          $("#records").text(data.totalRecords);
          $("#page").text(data.pageNum);
          // Add rows to table
          $("#tableProducts tbody").empty();
          $.each(data.rows, function(idx, product) {               
            var cells="<tr><th>"+product.cell[0]+"</th>";             
            cells +="<td>"+product.cell[1]+"</td>";
            cells +="<td>"+product.cell[2]+"</td>";            
            cells +="<td>"+product.cell[3]+"</td>";
            cells +="<td>"+product.cell[4]+"</td></tr>";            
            //cells +="<td><a href='#' title='Eliminar capa' onclick=\"borrar("+product.cell[0]+");\" class='ui-btn ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-notext ui-btn-inline'>Borrar</a></td>";                                       
            $("#tableProducts tbody").append(cells);
          });
          
      },
      error: function (jqXHR, textStatus, errorThrown) {
         console.log("Error ajax:"+textStatus);
      }
   });
}

function borrar(id){
          
   var a=confirm("¿Esta seguro de borrar el usuario con id "+id+" ?");

   if(a){
     //document.borrarCategoria.id.value=id;
     //document.borrarCategoria.submit();
   }
}
