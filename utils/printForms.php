<?php

// Formulaire de connexion
function printLoginForm($nom_de_la_page){
echo <<<CHAINE_DE_FIN
    <form action="index.php?todo=login&page=$nom_de_la_page" method="post">
        <input class="form-control mr-sm-2" type="text" placeholder="email" aria-label="email">
        <input class="form-control mr-sm-2" type = "password" name = "mdp" placeholder = "mot de passe" required />
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Conecter</button>
    </form>
CHAINE_DE_FIN;
}

function printLogoutForm($nom_de_la_page){
echo <<<CHAINE_DE_FIN
    <form action="index.php?todo=logout&page=$nom_de_la_page" method="post">
        <input type = "submit" value = "Déconnexion" />
    </form>
CHAINE_DE_FIN;
}

function printAskRegisterForm($nom_de_la_page){
echo <<<CHAINE_DE_FIN
    <form action="index.php?page=register" method="post">
        <input type = "submit" value = "Créer un compte" />
    </form>
CHAINE_DE_FIN;
}
