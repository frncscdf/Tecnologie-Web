<?php
    include_once ('sessionManager.php');
    include_once ('User.php');
    if(!User::isAdmin($_SESSION['email'])){
        header("Location: index.php");
    }
?>  
<!DOCTYPE html>
<html lang="it">
    <head>
    <title>Strumenti Admin &#124; DevSpace</title>
		<meta charset="UTF-8">
        <meta name="description" content="Pagina strumenti amministratore" />
        <meta name="keywords" content="computer, science, informatica, development, teconologia, technology" />
        <meta name="language" content="italian it" />
		<meta name="author" content="Barzon Giacomo, De Filippis Francesco, Greggio Giacomo, Roverato Michele" />
		<meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="theme-color" content="#F5F5F5" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>	
        
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/style.css" />
        <link rel="stylesheet" type="text/css" href="https://frncscdf.github.io/Tecnologie-Web/print.css" media="print"/>
        <script src="https://frncscdf.github.io/Tecnologie-Web/scripts.js"></script>
        
    </head>
    
    <body>
        <?php include_once ('navbar.php'); 
        
        $nickname = unserialize($_SESSION['userInfo'])->nickname;
        if(User::isBanned($nickname)) {
            echo "<span>Il tuo account è stato sospeso, pertanto non potrai più utilizzare gli strumenti 
            di amministratore.</span>";
        } else {
            echo "<div id='registration-form'>
            <div class='regform-introduction'>
                
                <h2>Strumenti amministratore</h2>
            </div>
            <div class='regform-main-section'>
                <ul class='simple-list'>
                    <li><a href='manageArguments.php'>Crea un nuovo argomento</a></li>
                    <li><a href='addAdmin.php'>Aggiungi un nuovo amministratore</a></li>
                    <li><a href='manageUsers.php'>Gestisci utenti bannati</a></li>
                </ul>
            </div>
        </div>	";
        }
        
        ?>
        
    </body>
</html>