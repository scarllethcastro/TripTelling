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
         <!-- Bootstrap CSS -->
         <link href="css/bootstrap.min.css" rel="stylesheet">
         <!-- Mon CSS Perso -->
         <link rel="stylesheet" type="text/css" href="css/perso.css">
         
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
        "menutitle" => "Enregistrement")
);

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

    public static function insererUtilisateur($dbh, $username, $password, $lastname, $firstname, $birth, $email) {
        if (Utilisateur::getUtilisateur($dbh, $username) == null) {
            if (Utilisateur::getUtilisateurMail($dbh, $email) == null) {
                $sth = $dbh->prepare("INSERT INTO `utilisateurs` (`username`, `password`, `lastname`, `firstname`, `birth`, `email`) VALUES(?,SHA1(?),?,?,?,?)");
                $sth->execute(array($username, $password, $lastname, $firstname, $birth, $email));
            } else {
                echo 'Email déjà existant! <br>';
                return false;
            }
        } else {
            echo 'Username déjà existant! <br>';
            return false;
        }
        return true;
    }

    public static function testerMdp($dbh, $user, $mdp) {
        $motdepasse = sha1($mdp);
        return $user->password == $motdepasse;
    }

}
