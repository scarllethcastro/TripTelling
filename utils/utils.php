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
         <!-- Bootstrap CSS -->
         <link href="css/bootstrap.min.css" rel="stylesheet">
         <!-- Mon CSS Perso -->
         <link rel="stylesheet" type="text/css" href=$feuilledestyle />
         <script type="text/javascript" src="js/jquery.min.js"></script>

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
        "title" => "Accueil de notre site",
        "menutitle" => "Accueil"),
    array(
        "name" => "contacts",
        "title" => "Qui sommes-nous ?",
        "menutitle" => "Nous contacter"),
    array(
        "name" => "info",
        "title" => "Informations pratiques",
        "menutitle" => "Informations pratiques"),
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

    public $login;
    public $mdp;
    public $nom;
    public $prenom;
    public $promotion;
    public $naissance;
    public $email;
    public $feuille;

    public function __toString() {
        $date = explode('-', "$this->naissance");
        return '[' . $this->login . '] ' . $this->prenom . ' ' . "<span style='font-weight:bold'>$this->nom</span>, né le jour " . $date[2] . '/' . $date[1] . '/' . $date[0] . ', X' . $this->promotion . ", <span style='font-weight:bold'>$this->email</span> <br>";
    }

    public static function getUtilisateur($dbh, $login) {
        $query = "SELECT * FROM `utilisateurs` WHERE login = ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
        $sth->execute(array($login));
        $user = $sth->fetch();
        if ($user == false)
            return null;
        else
            return $user;
    }

    public static function insererUtilisateur($dbh, $login, $mdp, $nom, $prenom, $promotion, $naissance, $email, $feuille) {
        if (Utilisateur::getUtilisateur($dbh, $login) == null) {
            $sth = $dbh->prepare("INSERT INTO `utilisateurs` (`login`, `mdp`, `nom`, `prenom`, `promotion`, `naissance`, `email`, `feuille`) VALUES(?,SHA1(?),?,?,?,?,?,?)");
            $sth->execute(array($login, $mdp, $nom, $prenom, $promotion, $naissance, $email, $feuille));
        } else
            echo 'Login déjà existant! <br>';
    }

    public static function testerMdp($dbh, $user, $mdp) {
        $motdepasse = sha1($mdp);
        return $user->mdp == $motdepasse;
    }

}
