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
        "menutitle" => "Votre profil"),
    array(
        "name" => "newprofile",
        "title" => "Votre profil",
        "menutitle" => "Votre profil"),
    array(
        "name" => "post",
        "title" => "Votre profil",
        "menutitle" => "Votre profil"),
    array(
        "name" => "editprofile",
        "title" => "Éditer profil",
        "menutitle" => "Éditer profil"),
    array(
        "name" => "changepassword",
        "title" => "Changer le mot de passe",
        "menutitle" => "Changer le mot de passe"),
    array(
        "name" => "deleteaccount",
        "title" => "Suppression du compte",
        "menutitle" => "Suppression du compte")
);

if (isset($_SESSION['username']))
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
        $lastname = ucfirst($last);
        $firstname = ucfirst($first);
        $password_encrypted = password_hash($password, PASSWORD_DEFAULT);
        $sth = $dbh->prepare("INSERT INTO `utilisateurs` (`username`, `password`, `lastname`, `firstname`, `birth`, `email`) VALUES(?,?,?,?,?,?)");
        $sth->execute(array($username, $password_encrypted, $lastname, $firstname, $birth, $email));
    }

    public static function testerMdp($dbh, $user, $mdp) {
        return password_verify($mdp, $user->password);
    }

    public static function islogged() {
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'])
            return true;
        else
            return false;
    }
    
    public static function editProfile($dbh, $username, $last, $first, $birth) {
        $lastname = ucfirst($last);
        $firstname = ucfirst($first);
        $sth = $dbh->prepare("UPDATE `utilisateurs` SET `lastname` = ?, `firstname` = ?, `birth` = ? WHERE `username` = ?");
        $sth->execute(array($lastname, $firstname, $birth, $username));
    }
    
    public static function changePassword($dbh, $username, $password) {
        $password_encrypted = password_hash($password, PASSWORD_DEFAULT);
        $sth = $dbh->prepare("UPDATE `utilisateurs` SET `password` = ? WHERE `username` = ?");
        $sth->execute(array($password_encrypted, $username));
    }
    
    public static function deleteUser($dbh, $username) {
        $sth = $dbh->prepare("DELETE FROM `utilisateurs` WHERE `username` = ?");
        $sth->execute(array($username));
    }
}

//Vérifier l'utilisation des caractères spéciaux dans le mot de passe
function valide_password($motdepasse) {
    if (strlen($motdepasse) < 6) {
        return false;
    } elseif (!preg_match("/^([a-zA-Z0-9]+)$/", $motdepasse)) {
        return false;
    } else {
        return true;
    }
}

//Vérifier l'utilisation des caractères spéciaux dans le nom d'utilisateur
//et si le nom existe déjà dans la base de données
function valide_username($dbh, $usrname) {
    if (!preg_match("/^([a-zA-Z0-9]+)$/", $usrname)) {
        return false;
    } else {
        $usr = Utilisateur::getUtilisateur($dbh, $usrname);
        if ($usr != null) {
            return false;
        } else {
            return true;
        }
    }
}

//Vérifier si le email est valide et si il est déjà utilisé dans la base de données
function valide_email($dbh, $mail) {
    if (filter_var($mail, FILTER_VALIDATE_EMAIL) == false) {
        return false;
    } else {
        $usr = Utilisateur::getUtilisateurMail($dbh, $mail);
        if ($usr != null) {
            return false;
        } else {
            return true;
        }
    }
}

// Vérifier si les mots de passes sont égaux
function valide_password_verification($motdepasse, $up2) {
    if (strcmp($motdepasse, $up2) != 0) {
        return false;
    } else {
        return true;
    }
}

class Post {

    public $idpost;
    public $loginuser;
    public $title;
    public $place;
    public $duration;
    public $description;
    public $money;

    public static function getposts($dbh, $username, $start, $number) {

        $sql_code = "SELECT * FROM `posts` WHERE loginuser = ? LIMIT $start OFFSET $number ";

        $sth = $dbh->prepare($sql_code);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Post');
        $sth->execute(array($username));
        $post = $sth->fetch();
        return $post;
    }

    public static function numposts($dbh, $username) {

        $sql_code = "SELECT * FROM `posts` WHERE loginuser = ?";
        $sth = $dbh->prepare($sql_code);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Post');
        $sth->execute(array($username));
        $post = $sth->fetch();
        return $sth->rowCount();
    }

    public static function numpostsconstraint($dbh, $sql_code, $array) {
        $sth = $dbh->prepare($sql_code);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Post');
        $sth->execute($array);
        $post = $sth->fetch();
        return $sth->rowCount();
    }

    public static function getpost($dbh, $idpost) {
        $sql_code = "SELECT * FROM `posts` WHERE idpost = ?";
        $sth = $dbh->prepare($sql_code);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Post');
        $sth->execute(array($idpost));
        $post = $sth->fetch();
        return $post;
    }

    public static function generatemoneysimbol($money) {

        switch ($money) {
            case '1': return '$';
            case '1.5': return '$-$$';
            case '2' : return '$$';
            case '2.5': return '$$-$$$';
            case '3': return '$$$';
            case '3.5': return '$$$-$$$$';
            case '4': return '$$$$';
        }
    }

    public static function generatemoneynumber($simbol) {

        switch ($simbol) {
            case '$': return '1';
            case '$-$$': return '1.5';
            case '$$' : return '2';
            case '$$-$$$': return '2.5';
            case '$$$': return '3';
            case '$$$-$$$$': return '3.5';
            case '$$$$': return '4';
        }
    }

}

class Stop {

    public $idstop;
    public $idpost;
    public $description;
    public $money;
    public $adress;
    public $time;
    public $title;

}

// Traitement de la photo de profil
function valide_photo($username, $photo) {
    // ex pour une image jpg
    if (!empty($photo['tmp_name']) && is_uploaded_file($photo['tmp_name'])) {
        // Le fichier a bien été téléchargé
        // Par sécurité on utilise getimagesize plutot que les variables $_FILES
        list($larg, $haut, $type, $attr) = getimagesize($photo['tmp_name']);
        //echo $larg . " " . $haut . " " . $type . " " . $attr;
        // Vérification du type: JPEG => type=2
        if ($type == 2) {
            // Vérification de la taille
            $taille_maxi = 1800000;
            $taille = filesize($photo['tmp_name']);
            if ($taille > $taille_maxi) {
                //echo "fichier trop volumineux!";
                return 2;
            } elseif (move_uploaded_file($photo['tmp_name'], 'images/avatars/' . $username . '.jpg')) {
                //echo "Copie réussie";
                return 0;
            } else {
                //echo "echec de la copie";
                return 3;
            }
        } else {
            //echo "mauvais type de fichier";
            return 1;
        }
    } else {
        //echo 'echec du téléchargement';
        return 3;
    }
}
