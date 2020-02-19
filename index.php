<?php
session_name("meilleuresession");
session_start();      // Pour indiquer que ce site utilise des sessions
if (!isset($_SESSION['initiated'])) {  // Si la personne vient d'arriver sur le site
    session_regenerate_id();           // On génère son id de session  
    $_SESSION['initiated'] = true;     // Et on commence sa session
}
// Décommenter la ligne suivante pour afficher le tableau $_SESSION pour le debuggage
// var_dump($_SESSION);
// Les "requires" nécessaires
require('utilities/utils.php');
require('utilities/printForms.php');
require('base/basededonnees.php');
require('utilities/logInOut.php');

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

    // Traitement des contenus de formulaires
    if (isset($_GET['todo'])) {
        if ($_GET['todo'] == 'register') {
            $reponse = Utilisateur::insererUtilisateur($dbh, $_POST['username'], $_POST['password'], $_POST['lastname'], $_POST['firstname'], $_POST['birth'], $_POST['email']);
            if ($reponse)
                logIn($dbh);
        } elseif ($_GET['todo'] == 'login') {
            logIn($dbh);
        } elseif ($_GET['todo'] == 'logout') {
            logOut();
        } else {
            $askedPage = 'error';
        }
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-light" style = "background-color: #c0f2ec;"> 
        <a class="navbar-brand" href="index.php" style = "font-family: Segoe Print; font-size: 45 pt" >TripTelling</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php?page=home">Navigate<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=register">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <?php
            if (isset($_SESSION['loggedIn'])) {
                if ($_SESSION['loggedIn'] == true) {
                    ?>
                    <ul class ="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target = "dropdown_target" >
                                Dropdown
                                <span class ="caret"></span>
                            </a>
                            <div class ="dropdown-menu" aria-labelledby = "dropdown_target">
                                <a class="dropdown-item">Settings</a>
                                <a class="dropdown-item">Desconect</a> 
                            </div>
                        </li>
                    </ul>

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <form class = "form-inline my-2 my-lg-0">
                                <button class="btn btn-outline-success" type="button">Profil</button>
                            </form>
                        </li>
                    </ul>
                    <!--                    <ul class="navbar-nav">
                                            <li class="nav-item" -->
                    <?php
                    printLogoutForm($askedPage);
                    ?>
                    <!--                        </li>
                                        </ul>-->


                    <?php
                }
            } else {

                printLoginForm($askedPage);
            }
            ?>
            <br>
        </div>

    </nav> 
    <?php
    if ($askedPage == 'welcome') {
        ?>
        <div class ="image"></div>; <?php } ?>
    <?php
    require ('pages/' . $askedPage . '.php'); // À la place d'un switch
    ?>

    <!-- footer -->
    <br>
    <div class="row">
        <div id="footer" class="col-md-4 offset-md-4">
            <p style = "font-family: Segoe Print; font-size: 35 pt; text-align: center">Site réalisé en Modal par SC</p>
        </div>
    </div>


    <?php
// Déconnexion de la base de données MySQL
    $dbh = null;
    generateHTMLFooter();
}