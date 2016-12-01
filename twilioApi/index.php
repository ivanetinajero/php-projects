<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Twilio SMS Web Application</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
  
    <!-- In head section we should include the style sheet for the grid -->
    <link rel="stylesheet" type="text/css" media="screen" href="themes/redmond/jquery-ui-1.8.2.custom.css" />     
    <link rel="stylesheet" type="text/css" media="screen" href="themes/ui.jqgrid.css" />        
    <link rel="stylesheet" type="text/css" media="screen" href="themes/ui.multiselect.css" />
    
    <!-- Of course we should load the jquery library -->   
    
    <script src="js/jquery.min.js"></script>    
    <script src="js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
    <script src="js/jquery.layout.js" type="text/javascript"></script>
    <script src="js/i18n/grid.locale-en.js" type="text/javascript"></script> 
    <script src="js/ui.multiselect.js" type="text/javascript"></script> 
    <script src="js/jquery.tablednd.js" type="text/javascript"></script>
    <script src="js/jquery.contextmenu.js" type="text/javascript"></script>
    <script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>    
    
    <script type="text/javascript"> 
        jQuery().ready(function (){ 
            jQuery("#featured").jqGrid({ 
                url:'xmlSms.php?q=1', 
                datatype: "xml", 
                colNames:['Sid','Type','Date','From', 'To', 'Message','Status'], 
                colModel:[ 
                    {name:'sid',index:'sid', width:15,align:'left',hidden:true,sortable:false},
                    {name:'direction',index:'direction', width:20,align:'center',sortable:false}, 
                    {name:'date',index:'date', width:35,sortable:false}, 
                    {name:'from',index:'from', width:33,align:'left',sortable:false}, 
                    {name:'to',index:'to', width:33, align:"left",sortable:false}, 
                    {name:'body',index:'body', width:150, align:"left",sortable:false},
                    {name:'status',index:'status', width:25,align:'center',sortable:false}                    
                ], 
                width: 1150,
                height:300,
                rowNum:15, 
                //autowidth: true, 
                rowList:[15,30,50], 
                pager: jQuery('#pager'), 
                sortorder: "desc",
                sortname:"ID(propiedad)",
                viewrecords: true, 
                //multiselect:true,
                // Indica si puede haber una barra de herramientas y la posicion
                //toolbar: [true,"top"],
                caption:"List of SMS's" }); 
            
                // Declaracion de botones
                //***************************************************************************************
                $("#t_featured").append("<input type='button' id='sh' name='sh' value='Nuevo' onclick=alert(0);>");                
            
                // Botones de la barra del paginador
                jQuery("#featured").jqGrid('navGrid','#pager',{add:false,edit:false,del:false,search:false,refresh:true}); 
                // Administrador de columnas
                jQuery("#featured").jqGrid('navButtonAdd','#pager',
                { 
                  caption: "Manage Columns", 
                  title: "Show / Hide Columns", 
                  onClickButton : function ()
                  { 
                      jQuery("#featured").jqGrid('columnChooser'); 
                  } 
                }); 
        });
               
        function deleteSms(sid){
            if (confirm("The SMS with Sid "+sid+ " will be deleted.\n. Are you Sure?")){
               document.frmDelete.sid.value=sid;
               document.frmDelete.submit();
            }   
        }
    </script>  
</head>
<body>
    
    <form action="deleteSms.php" method="post" name="frmDelete">
		<input type="hidden" name="sid">
	 </form>
    
    <center>
    <table border="0" style="width: 90%;color: #1d5987">
        <tr>
            <td colspan="3" style="font-size: 30px; font-weight: bold"><center>CIMAT, UNIDAD ZACATECAS</center></td>
            <!--
            <td style="text-align: right" colspan="2"><img src="images/cimat.png" style="width: 100px;height: 100px"></td>            
            -->
        </tr>
        <tr>
            <td colspan="3" style="font-size: 25px;font-weight: bold"><center>Master in Software Engineering</center></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr style="font-size: 20px">            
            <td><b>Tutor</b><br/>Alejandro García Fernández</td>
            <td><b>Subject</b><br/>Components Based Software Development</td>   
            <td><b>Date</b><br/>February 2015</td>
        </tr>
        <tr style="font-size: 20px">            
            <td colspan="3"><b>Student</b><br/>Iván E. Tinajero Díaz</td>           
        </tr>
        <tr>            
            
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="font-size: 18px;">
               <b>Homework</b><br>Web application to demostrate the use of Twilio API.
            </td>
        </tr>
    </table>
    <br/>
    <!-- Aqui inicia el contenido -->                
    
    <?php
      if(isset($_GET['deleted'])){
    ?>     
        <div style="color: red;font-size: 20px;font-weight: bold">The SMS was deleted.</div>
    <?php      
      }
    ?>
    
    <div></div>
    <table id="featured" ></table>
    <div id="pager"></div>
    
    <br/>
    <table border="0" style="width: 90%">
        <tr>
            <td><b>Legend (SMS type)</b><br/><br/>
                <img src='images/calling.png' style="vertical-align:middle"></img>&nbsp;SMS sent to me through Twilio API<br/>
                <img src='images/answeringMachine.png' style="vertical-align:middle"></img>&nbsp;Auto-Reply (Twilio API)<br/>
                <img src='images/answer.png' style="vertical-align:middle"></img>&nbsp;My answers from my phone.<br/>
            </td>
        </tr>       
              
    </table>
    
    </center>
    <!-- Aqui termina el contenido -->
</body>            
</html>
