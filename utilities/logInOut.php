<?php

function  logIn($dbh){
    $user = Utilisateur::getUtilisateur($dbh, $_POST['username']);
    if($user != null && Utilisateur::testerMdp($dbh, $user, $_POST['password'])){
        $_SESSION['loggedIn'] = true;
    }
}

function logOut(){
    session_unset();
    session_destroy();
}

