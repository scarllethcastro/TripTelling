<?php

class Database {

    public static function connect() {
        $dsn = 'mysql:dbname=basemsgc;host=127.0.0.1';
        $user = 'root';
        $password = '';
        $dbh = null;
        try {
            $dbh = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
            exit(0);
        }
        return $dbh;
    }

}

// $dbh->query("INSERT INTO `utilisateurs` (`login`, `mdp`, `nom`, `prenom`, `promotion`, `naissance`, `email`, `feuille`) VALUES('moi',SHA1('nombril'),'bebe','louis','2005','1980-03-27','Marcel.Dupont@polytechnique.edu','modal.css')");
// $sth = $dbh->prepare("INSERT INTO `utilisateurs` (`login`, `mdp`, `nom`, `prenom`, `promotion`, `naissance`, `email`, `feuille`) VALUES(?,SHA1(?),?,?,?,?,?,?)");
// $sth->execute(array('SuperMarcel', 'Mystere', 'Marcel', 'Dupont', '2005', '1980-03-27', 'Marcel.Dupont@polytechnique.edu', 'modal.css'));
//insererUtilisateur($dbh, 'eu', 'senha', 'Castro', 'Scarlleth', '2018', '1997-09-04', 'scarllethcastro@gmail.com', 'qualqueruma.css');

/** PARCOURIR LA LISTE D'ENREGISTREMENTS CONTENUS DANS LA REPONSE * */
//$query = "SELECT * FROM `utilisateurs`";
//$sth = $dbh->prepare($query);
//$request_succeeded = $sth->execute();
//if($request_succeeded){
//    while($courant = $sth->fetch(PDO::FETCH_ASSOC)){
//        echo $courant['nom'].' '.$courant['prenom'].' '.$courant['promotion'].'<br>';
//    }
//}

//echo '<h3> Affiche de toutes les données: <br> </h3>';
//$query = "SELECT * FROM `utilisateurs`";
//$sth = $dbh->prepare($query);
//$sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
//$sth->execute();
//while ($user = $sth->fetch()) {
//    echo $user . '<br>';
//}


