<?php

function  logIn($dbh){
    $user = Utilisateur::getUtilisateurMail($dbh, $_POST['email']);
    if($user != null && Utilisateur::testerMdp($dbh, $user, $_POST['password'])){
        $_SESSION['loggedIn'] = true;
    }
}

function logOut(){
    session_unset();
    session_destroy();
}

