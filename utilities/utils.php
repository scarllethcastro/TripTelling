<?php

// Générer l'en-tête
function generateHTMLHeader($titre, $feuilledestyle) {
    echo <<<CHAINE_DE_FIN
         <!DOCTYPE html>
   
         <html lang="fr">

         <head>
         <meta charset="UTF-8"/>
         <meta name="author" content="Nom de l'auteur"/>
         <meta name="keywords" content="Mots clefs relatifs à cette page"/>
         <meta name="description" content="Descriptif court"/>
         <title>$titre</title>
         <script type="text/javascript" src="js/jquery.min.js"></script>
         <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>  
         <!-- Bootstrap CSS -->
         <link href="css/bootstrap.min.css" rel="stylesheet">
         <!-- Mon CSS Perso -->
         <link rel="stylesheet" type="text/css" href=$feuilledestyle>
         
         </head>
         <body>
CHAINE_DE_FIN;
    echo PHP_EOL;
}

// Générer la fin
function generateHTMLFooter() {
    echo '</body>' . PHP_EOL . '</html>';
}

// Liste des pages
$page_list = array(
    array(
        "name" => "welcome",
        "title" => "TripTelling",
        "menutitle" => "Accueil"),
    array(
        "name" => "home",
        "title" => "TripTelling",
        "menutitle" => "Nous contacter"),
    array(
        "name" => "register",
        "title" => "Creer une compte",
        "menutitle" => "Enregistrement"),
    
    array(
        "name" => "profile",
        "title" => "Votre profil",
        "menutitle" => "Votre profil")
    
);
if(isset($_SESSION['username']))
    $page_list[3]["title"] = $_SESSION['username'];

// Pour vérifier la page demandée par l'utilisateur
function checkPage($askedPage) {
    global $page_list;
    foreach ($page_list as $page) {
        if ($page['name'] == $askedPage) {
            return true;
        }
    }
    return false;
}

// Pour récupérer le titre de la page demandée
function getPageTitle($askedPage) {
    global $page_list;
    foreach ($page_list as $page) {
        if ($page['name'] == $askedPage) {
            return $page['title'];
        }
    }
}

/** RECUPERER LES ENREGISTREMENTS CONTENUS DANS LA REPONSE COMME DES OBJETS * */
class Utilisateur {

    public $username;
    public $password;
    public $lastname;
    public $firstame;
    public $birth;
    public $email;

    public function __toString() {
        $date = explode('-', "$this->birth");
        return '[' . $this->username . '] ' . $this->firstame . ' ' . "<span style='font-weight:bold'>$this->lastname</span>, né le jour " . $date[2] . '/' . $date[1] . '/' . $date[0] . " <span style='font-weight:bold'>$this->email</span> <br>";
    }

    public static function getUtilisateur($dbh, $username) {
        $query = "SELECT * FROM `utilisateurs` WHERE username = ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
        $sth->execute(array($username));
        $user = $sth->fetch();
        if ($user == false)
            return null;
        else
            return $user;
    }

    public static function getUtilisateurMail($dbh, $email) {
        $query = "SELECT * FROM `utilisateurs` WHERE email = ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
        $sth->execute(array($email));
        $user = $sth->fetch();
        if ($user == false)
            return null;
        else
            return $user;
    }

    public static function insererUtilisateur($dbh, $username, $password, $last, $first, $birth, $email) {
        $lastname = ucfirst(strtolower($last));
        $firstname = ucfirst(strtolower($first));
        $sth = $dbh->prepare("INSERT INTO `utilisateurs` (`username`, `password`, `lastname`, `firstname`, `birth`, `email`) VALUES(?,SHA1(?),?,?,?,?)");
        $sth->execute(array($username, $password, $lastname, $firstname, $birth, $email));
    }

    public static function testerMdp($dbh, $user, $mdp) {
        $motdepasse = sha1($mdp);
        return $user->password == $motdepasse;
    }
    
    public static function islogged(){
        
        if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'])
            return true;
        else return false;
    }

}

//Vérifier l'utilisation des caractères spéciaux dans le mot de passe
function valide_password($motdepasse){
    if(strlen($motdepasse) < 6){
        return false;
    } elseif (!preg_match("/^([a-zA-Z0-9]+)$/", $motdepasse)){
        return false;
    } else{
        return true;
    }
}

//Vérifier l'utilisation des caractères spéciaux dans le nom d'utilisateur
//et si le nom existe déjà dans la base de données
function valide_username($dbh, $usrname){
    if (!preg_match("/^([a-zA-Z0-9]+)$/", $usrname)){
        return false;
    } else{
        $usr = Utilisateur::getUtilisateur($dbh, $usrname);
        if($usr != null){
            return false;
        } else{
            return true;
        }
    }
}

//Vérifier si le email est valide et si il est déjà utilisé dans la base de données
function valide_email($dbh, $mail){
    if(filter_var($mail, FILTER_VALIDATE_EMAIL) == false){
        return false;
    } else{
        $usr = Utilisateur::getUtilisateurMail($dbh, $mail);
        if($usr != null){
            return false;
        } else{
            return true;
        }
    }
}

// Vérifier si les mots de passes sont égaux
function valide_password_verification($motdepasse, $up2){
    if(strcmp($motdepasse,$up2)!= 0){
        return false;
    } else{
        return true;
    }      

}

class Post{
    
    public $idpost;
    public $loginuser;
    public $title;
    public $place;
    public $duration;
    public $description;
}
