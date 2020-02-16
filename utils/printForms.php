<?php

// Formulaire de connexion
function printLoginForm($nom_de_la_page){
echo <<<CHAINE_DE_FIN
    <form action="index.php?todo=login&page=$nom_de_la_page" method="post">
        <input type = "text" name = "login" placeholder = "login" required />
        <input type = "password" name = "mdp" placeholder = "mot de passe" required />
        <input type = "submit" value = "Valider" />
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
