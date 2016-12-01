<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>PhysicalTrello</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="js/vendor/jquery-1.9.0.min.js"></script>        
        <script src="https://api.trello.com/1/client.js?key=dc0af7e595488131774490357b151087"></script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <p class="loggedIn navbar-text pull-right">
                      You are logged as <span class="fullName"></span> 
                        <a id="disconnect" class="btn btn-primary btn-small" style="margin-top: 0">Logout</a>
                    </p>
                    <a class="brand" href="#">PhysicalTrello</a>                    
                </div>
            </div>
        </div>

        <div class="container">
            <div class="loggedOut">
                <!-- Main hero unit for a primary marketing message or call to action -->
                <div class="hero-unit">
                    <!-- Main content -->
                    <h1>Sincroniza tus tableros de Trello con un tablero f&iacute;sico utilizando c&oacute;digos QR.</h1><br>                        
                    <div class="loggedOut pullright"><a id="connectLink" class="btn btn-primary btn-large">Log In &raquo;</a></div>
                    <br/>
                    
                    <div class="loggedOut pullright">
				                       
                       <center>
			<h2>¿Como funciona?</h2>
			 <iframe width="560" height="315" src="https://www.youtube.com/embed/TZsxo8bFDzo" frameborder="0" allowfullscreen></iframe>			 	
		       </center>	
		       	
		    </div>
                    
                </div>
            </div>

            <div class="row-fluid loggedIn">
                <div class="span3">
                  <div id="boardList" class="well sidebar-nav">
                  </div><!--/.well -->
                </div><!--/span-->
                <div class="span9">
                    <div class="saveBoard" style="display:none">
                        <form action="save.php" method="POST">
                            <input class="boardHtml" type="hidden" name="contents" value="">
                            <input class="boardName" type="hidden" name="name" value="">
                            <input class="btn btn-large btn-success" type="submit" name="submit" value ="Save as HTML">
                        </form>
                    </div>
                    <div id="output" style="margin-bottom: 30px">
                        <div class="hero-unit">
                            <h1>Welcome <span class="fullName"></span>, select a board...</h1>
                        </div>
                    </div>
                </div>
            </div>   
            <footer>
            </footer>

        </div> <!-- /container -->
        <div id='div_session_write'> </div>
    </body>
</html>
