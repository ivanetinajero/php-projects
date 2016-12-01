$( document ).ready(function() {
$('.loggedIn').hide();
var getBoards = function (){
	updateLoggedIn();
        
	$("#boardList").empty();
	Trello.members.get("me", function(member){
	    $(".fullName").text(member.fullName);
	
            /*******Guardar username - token en mysql********/            
            
            var token = Trello.token();
            var username = member.username;            
            var formData = {username:username,token:token}; //Array
            
            $.ajax({ 
                 url: 'saveUser.php', 
                 dataType: 'text', 
                 type: 'post', 
                 data: formData,                
                 success: function( data, textStatus, jQxhr ){ 
                     
                    //alert("Server response: "+data); 
                    
                    if (data==1){
                     
                        var $boardList = $('<ul class="nav nav-list">').text("Loading Boards...").appendTo("#boardList");
                        // Output a list of all of the boards that the member 
                        Trello.get("members/me/boards", {filter: "open"}, function(boards) {
                            $boardList.empty();
                            var output = '<li class="nav-header">Open Boards:</li>';
                            $.each(boards, function(ix, board) {
                                output += '<li><a data-board-id = "'+board.id+'" href="#">'+board.name+'</a></li>';
                            });  
                            $boardList.html(output);
                            //attach behaviours
                            $('a', $boardList).click( function(){
                                    var id = $(this).data('board-id');
                                    $boardList.find('li').removeClass('active');
                                    $(this).parent().addClass('active');
                                    Trello.boards.get(id, {lists: "open", cards: "visible"}, displayBoard);
                                    return false;
                            });
                        });
                     
                    }
                    else{
                        alert("Error al guardar el token en la base de datos");
                    }
                 }, 
                 error: function( jqXhr, textStatus, errorThrown ){ 
                     alert(errorThrown); 
                 } 
            });
            
            /**************Fin Guardar en mysql**************/
        
	    
	});
}

var displayBoard = function(board){
	
 
  // Ponemos las tarjetas del tablero board en sesion, para que el user pueda imprimirlas
  // jQuery('#div_session_write').load('miajax.php?idBoard='+board.id);
  // Termina poner tarjetas en sesion... este div esta en TrelloConnection
  
  var dateString = new Date();
  var nameCheckBox="";  

  output = "<h3>Board: "+board.name+"</h3><h4><br>Print Cards "+"<br></h4><a href='printQr.php?idBoard="+board.id+"' target='_blank'><img src='img/printer.png' alt='' title='Print Cards'></a></div></em>";
  output += "<h4>Print headers</h4>"+"<a href='printHeaders.php?idBoard="+board.id+"' target='_blank'><img src='img/printer.png' alt='' title='Print Headers'></a></div></em>";
  output += "<h4>Download template</h4>"+"<a href='templatePostit.pdf' target='_blank'><img src='img/postit.png' alt='' title='Download Postit Template'></a></div></em>";
  //output = "<table><tr><td><h1>"+board.name+"</h1></td></tr></table>";
  output += "<div><em>"+dateString.toString('dddd, MMMM ,yyyy');
  
  $.each(board.lists, function(i){
        var idList = this.id;
        // Inicia div para dar formato de Lista
        output +="<div id='done' class='section'><h1>"+this.name+"</h1>";

        $.each(board.cards, function(i){
                if (this.idList == idList){
                        // Dibujamos el div para dar formato de Tarjeta
                        //nameCheckBox="<input type='checkbox' value='"+this.id+"' onclick='printQr(this)' ><br/>";
                        nameCheckBox="";
                        output += "<div id='c1' class='card'>"+nameCheckBox+this.name+"</div>";
                }
        });
        // Termina div para dar formato de lista
        output += "</div>"; 
    });
	$('#output').html(output);	
}

var updateLoggedIn = function() {
    var isLoggedIn = Trello.authorized();
    if (isLoggedIn){
    	console.log('logged in');
    	$(".loggedIn").show();     
    	$(".loggedOut").hide();   
    } else {
    	console.log('not logged in');
    	$(".loggedIn").hide();
    	$(".loggedOut").show();
    }   
};

var getDateStamp = function(){
	var d = new Date();
	var year = d.getFullYear();
	var month = d.getMonth() + 1;
	var day = d.getDate();
	return year+'-'+month+'-'+day;
};
    
var logout = function() {
    Trello.deauthorize();
    updateLoggedIn();
};
                          
Trello.authorize({
    interactive:false,
    success: getBoards
});

$("#connectLink")
.click(function(){
    Trello.authorize({
        type: "popup",
        expiration:"never",
        success: getBoards,
        name: 'PhysicalTrello',
        scope:{write:true,read:true}
    })
});

$("#showLink").click(function(){
	console.log('show link clicked');
	Trello.authorize({
	    interactive:false,
	    success: getBoards
	});	
});
    
$("#disconnect").click(logout);

});

function printQr(id){
   var checkBox=id;
   alert("IdCard: "+checkBox.value);
   
}

var moveCardToList = function() {
       updateLoggedIn();       
       //Trello.post("cards/idCard/actions/comments", { text: "Modificando datos desde php" });
       //Trello.put("cards/IdCard/",{ idList: "idListaNueva"});		   
       Trello.post("cards/54073cc73cefcb77d1f1309d/actions/comments", { text: "Modificando datos desde php" });
       Trello.put("cards/54078053605b33754c5e54c7/",{ idList: "54073bf6ac6c8854779543a9"});		   
};
