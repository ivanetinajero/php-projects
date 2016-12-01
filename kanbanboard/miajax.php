<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    if (isset($_GET['idBoard'])) {

      require_once 'classes/Sesion.php';  
      require_once 'classes/Lista.php';
      require_once 'classes/Tarjeta.php';
      require_once 'classes/Tablero.php';

      require_once 'Hhelp.php';

      $sesion = new sesion();
      $sesion->set("idBoard", $_GET['idBoard'] );

      /*session_start();
      $_SESSION['idBoard'] = $_GET['idBoard'];
      echo "Paso :: ".$_SESSION['idBoard'];*/

      // echo "Si Paso Ver al final... del Form -> ".$sesion->get('idBoard');

       try {
            // Put your key and secret provided by Trello. https://trello.com/1/appKey/generate 
            define("CONSUMER_KEY", "dc0af7e595488131774490357b151087");
            define("CONSUMER_SECRET", "c3ce066cc3444631b3311e11062787785b4cfb153b0ede191ae36c77aa303e7b");

            $oauth = new OAuth(CONSUMER_KEY, CONSUMER_SECRET);
            $oauth->disableSSLChecks(); 

            $oauth->setToken("9b1405382df181210a775c807d42da1312648d356ce25e7c1cd45f2ea0132f47","58e3ed927313788241e500c2c33bee97"); 

            /**
             * Trello API Operations 
             */
            // Read all lists from an idBoard
            $idBoard=$sesion->get('idBoard');
            $oauth->fetch("https://trello.com/1/boards/".$idBoard."/lists", array(), OAUTH_HTTP_METHOD_GET); 

            //$oauth->fetch("https://trello.com/1/boards/".$idBoard."/cards", array(), OAUTH_HTTP_METHOD_GET);            

            $data = json_decode($oauth->getLastResponse());

            // Get name columns of the board
            $listas = array();
            $n = 0;

            for ($index = 0; $index < count($data); $index++) {    
               //Obj Categoria

               $oLista = new Lista($data[$index]->id);
               $oLista->setNombre($data[$index]->name);
               $oLista->setIdTablero($data[$index]->idBoard);

               $listas[$n] = serialize($oLista);
               $n++;
            }

            // Get the cards
            $oauth->fetch("https://trello.com/1/boards/".$idBoard."/cards", array(), OAUTH_HTTP_METHOD_GET); 
            $data = json_decode($oauth->getLastResponse());

            $tarjetas = array();
            $n = 0;
            for ($index = 0; $index < count($data); $index++) {    
               //Obj Categoria

               //$oTarjeta = new Tarjeta($data["cards"][$index]["id"]);
               $oTarjeta = new Tarjeta($data[$index]->idShort);
               $oTarjeta->setNombre($data[$index]->name);
               $oTarjeta->setDescripcion($data[$index]->desc);
               $oTarjeta->setUrl($data[$index]->shortUrl);
               $oTarjeta->setFechaCreacion($data[$index]->dateLastActivity);
               $oTarjeta->setIdLista($data[$index]->idList);

               $tarjetas[$n] = serialize($oTarjeta);
               $n++;
            }

            // Get the Board info
            $oauth->fetch("https://trello.com/1/boards/".$idBoard, array(), OAUTH_HTTP_METHOD_GET); 
            $data = json_decode($oauth->getLastResponse());


            $oTablero=new Tablero($data->id);
            $oTablero->setNombre($data->name);
            $oTablero->setUrl($data->url);

            // Put objects into a session
            // $sesion = new sesion();
            $sesion->set("lstLista", serialize($listas));
            $sesion->set("lstTarjeta", serialize($tarjetas));
            $sesion->set("tablero", serialize($oTablero));

            /*****************************************************
             * End objects Tablero, Listas y Tarjetas            *
             ****************************************************/  


        } catch(OAuthException $E) {
            echo "Response: ". $E->getMessage(). "\n";
        }

    }
?>
