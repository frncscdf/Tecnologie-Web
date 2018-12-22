<?php

    session_start();

    $pagesToIgnore = array("login.php", "errore.php", "registrazione.php");

    $shouldBeIgnored = false;

    //Controllo se la pagina va ignorata
    foreach($pagesToIgnore as $page){
        if (strpos($_SERVER['REQUEST_URI'], $page)) {
            $shouldBeIgnored = true;
        }
    }
    //Se non va ignorata aggiorno l'ultima pagina visitata
    if(!$shouldBeIgnored){
        $_SESSION["lastVisitedPage"] = $_SERVER['REQUEST_URI'];
    }

    class SessionManager {

        //Metodo comodo per il redirect all'ultima pagina visitata
        static function getPageRedirect(){
            if(isset($_SESSION["lastVisitedPage"])){
                return $_SESSION["lastVisitedPage"];
            }else{
                return "index.php";
            }
        }

    }//End class

?>