<?php

// Formulaire de connexion
function printLoginForm() {
    echo <<<CHAINE_DE_FIN
    <form class = "form-inline my-2 my-lg-0" action= "index.php?todo=login&page=home" method='post'>
        <input class="form-control mr-sm-2" type="text" name= "email" placeholder="email" aria-label="email">
        <input class="form-control mr-sm-2" type = "password" name = "password" placeholder = "mot de passe" required />
       <input class="btn btn-outline-success my-2 my-sm-0" type="submit" value = 'Conecter'> 
    </form>
CHAINE_DE_FIN;
}

function printLogoutForm($nom_de_la_page) {
    echo <<<CHAINE_DE_FIN
    <form class = "form-inline my-2 my-lg-0" action="index.php?todo=logout&page=$nom_de_la_page" method="post" style="margin-left: 8px">
        <input class = "btn btn-outline-secondary my-2 my-sm-0" type = "submit" value = "Déconnexion" />
    </form>
CHAINE_DE_FIN;
}

function printAskRegisterForm() {
    echo <<<CHAINE_DE_FIN
    <form class = "form-inline my-2 my-lg-0" action="index.php?page=register" method="post" style="margin-left: 8px">
        <input class="btn btn-outline-success my-2 my-sm-0" type = "submit" value = "Créer un compte" />
    </form>
CHAINE_DE_FIN;
}
