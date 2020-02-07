<?php

function  logIn($dbh){
    $user = Utilisateur::getUtilisateur($dbh, $_POST['login']);
    if($user != null && Utilisateur::testerMdp($dbh, $user, $_POST['mdp'])){
        $_SESSION['loggedIn'] = true;
    }
}

function logOut(){
    session_unset();
    session_destroy();
}

