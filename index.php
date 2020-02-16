<?php
session_name("meilleuresession");
session_start();      // Pour indiquer que ce site utilise des sessions
if (!isset($_SESSION['initiated'])) {  // Si la personne vient d'arriver sur le site
    session_regenerate_id();           // On génère son id de session  
    $_SESSION['initiated'] = true;     // Et on commence sa session
}
// Décommenter la ligne suivante pour afficher le tableau $_SESSION pour le debuggage
//var_dump($_SESSION);
// Les "requires" nécessaires
require('utils/utils.php');
require('utils/printForms.php');
require('base/basededonnees.php');
require('utils/logInOut.php');

// Connexion à la base de données
$dbh = Database::connect();

// Test de la page demandée
$authorized = true;
$askedPage = 'welcome';
if (array_key_exists('page', $_GET)) {
    $authorized = checkPage($_GET['page']); //ajuster checkpage
    if ($authorized) {
        $askedPage = $_GET['page'];
    } else {
        require('pages/error.php');
    }
}

// Si la page demandée est valide
if ($authorized) {
    $pageTitle = getPageTitle($askedPage);
    generateHTMLHeader($pageTitle, "css/perso.css");
    ?>

    <div class="container">

        <!--         Menu 
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
        
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="?page=welcome">Accueil <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?page=info">Informations pratiques</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?page=contacts">Contact</a>
                            </li>
                        </ul>
                    </div>
                </nav>-->


        <!-- Partie du haut de la page -->
        <div class="jumbotron">
            <h1>TripTelling</h1>
            <p class="lead">Racontez votre voyage!</p>
        </div>

        <!-- Contenu principal -->
        <?php
        // Traitement des contenus de formulaires
        if (isset($_GET['todo'])) {
            if ($_GET['todo'] == 'login') {
                logIn($dbh);
            } elseif ($_GET['todo'] == 'logout') {
                logOut();
            } else {
                $askedPage = 'error';
            }
        }

//        // Vérifier si la personne est connectée
//        if (!isset($_SESSION['loggedIn'])){
//            if(!isset($_GET['todo'] )){
//                require('pages/welcome.php');
//            }
//            if(isset($_GET['todo']) && $_GET['todo']=='logout'){
//                require('pages/welcome.php');
//            }
//        } else{
//            require('pages/home.php');
//        }

        require ('pages/' . $askedPage . '.php'); // À la place d'un switch
        ?>

        <!-- footer -->
        <div id="footer">
            <p>Site réalisé en Modal par SC</p>
        </div>

    </div>

    <?php
// Déconnexion de la base de données MySQL
    $dbh = null;
    generateHTMLFooter();
}