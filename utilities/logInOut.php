<?php

function  logIn($dbh){
    $user = Utilisateur::getUtilisateurMail($dbh, $_POST['email']);
    if($user != null && Utilisateur::testerMdp($dbh, $user, $_POST['password'])){
     $_SESSION['loggedIn'] = true;
     $_SESSION['username'] = $user->username;
     return 0; // Succès
    } elseif($user == null){
        return 1; // Utilisateur inexistant
    } else{
        return 2; // Mot de passe incorrect
    }
}

function logOut(){
    session_unset();
    session_destroy();
}

