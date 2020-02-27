<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<?php
if (isset($_GET['user'])) {
    $user = Utilisateur::getUtilisateur($dbh, $_GET['user']);
    if ($user == null) {
        echo "<h4 style='text-align: center; margin-top: 1rem'> Cet utilisateur n'existe pas </h4>";
        return;
    }
} elseif (Utilisateur::islogged()) {
    $user = Utilisateur::getUtilisateur($dbh, $_SESSION['username']);
} else {
    echo "<h4 style='text-align: center; margin-top: 1rem'> Page non autorisée </h4>";
    return;
}
// Pagination et requetes des posts
if (isset($_GET['pagenum'])) {
    $pagenum = intval($_GET['pagenum']);
} else {
    $pagenum = 0;
}

$itemsperpage = 3;
//$sth = Post::getposts($dbh, $user->username, $pagenum, $itemsperpage);
$offsetpost = $pagenum * $itemsperpage;
$sql_code = "SELECT * FROM `posts` WHERE loginuser = ? LIMIT $itemsperpage OFFSET $offsetpost";
$sth = $dbh->prepare($sql_code);
$sth->setFetchMode(PDO::FETCH_CLASS, 'Post');
$sth->execute(array($user->username));
$post = $sth->fetch();
$numrows = $sth->rowCount();

$totalposts = Post::numposts($dbh, $user->username);
$totalpages = ceil($totalposts / $itemsperpage);
?>
<div class="prof" >
    <div class="row profile">
        <div class="col-md-3">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="" style="text-align: center">
                    <?php if (file_exists('images/avatars/' . $user->username . '.jpg')) { ?>
                        <img src="images/avatars/<?php echo htmlspecialchars($user->username) ?>.jpg" class="img-responsive" alt=""> <?php } else {
                        ?>
                        <img src ="https://www.casadasciencias.org/themes/casa-das-ciencias/assets/images/icons/icon-login-default.png" class="img-responsive" alt = ''> 
                    <?php } ?>
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <?php
                        echo htmlspecialchars($user->firstname);
                        echo " " . htmlspecialchars($user->lastname);
                        ?>
                    </div>
                    <div class="profile-usertitle-job">
                        <?php echo htmlspecialchars($user->username); ?>
                    </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
                <!--                <div class="profile-userbuttons">
                                    <button type="button" class="btn btn-success btn-sm">Follow</button>
                                    <button type="button" class="btn btn-danger btn-sm">Message</button>
                                </div>-->
                <!-- END SIDEBAR BUTTONS -->
                <!-- SIDEBAR MENU (doit être affichée seulement si l'utilisateur est loggé et si la page de profil à afficher est la sienne)--> 
                <?php if (Utilisateur::islogged() && $_SESSION['username'] == $user->username) { ?>
                    <div class="container" style ="margin-top: 5%; margin-bottom:5%;">
                        <div class="row">
                            <div class="col">
                                <div class="list-group" id="list-tab" role="tablist">

                                    <a class="list-group-item list-group-item-action button-page active" id="posts" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Publications</a>

                                    <a class="list-group-item list-group-item-action button-page" id="settings" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">Gérer compte</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <!-- END MENU -->
            </div>
        </div>
        <div class="col-md-9">
            <div class="profile-content">

                <!--Content posts-->
                <div class ="justify-content-around active" id="content-posts">       
                    <div class="shadow-none p-3 mb-5 bg-light rounded">
                        <h5 class="text-muted" style="text-align: center">
                            PUBLICATIONS
                        </h5>
                    </div>

                    <!--Link pour créer une nouvelle publication-->
                    <?php
                    if (Utilisateur::islogged() && $_SESSION['username'] == $user->username) {
                        ?>
                        <a href='index.php?page=newpost' id="newpost" class="col-md-4 offset-md-4 btn btn-info" style="margin-bottom: 3rem">+ Nouvelle publication</a>
                        <?php }
                    ?>
                    <!--                            <div id="deletealert" class = "alert alert-danger" role = "alert" style="text-align: center">
                                                Vous êtes sûr(e) de vouloir supprimer cette publication?
                                                <button id="canceldelete">Annuler la suppression</button>
                                                <a>Supprimer la publication</a>
                                                </div>-->
                    <?php
                    if ($totalposts > 0) {
                        do {
                            ?>
                            <div class="row justify-content-between" style="margin: 1%">
                                <div class ="col-md-4 col-lg-4">
                                    <img class="rounded" style = "display: block; margin-left: auto; margin-right: auto; width: 100%; height: auto;" alt=""<?php echo "src='images/posts/" . $post->idpost . ".jpg'" ?>  >

                                </div>
                                <!--Div d'un post-->
                                <div class ="col-md-8 col-lg-8 divpost">
                                    <div class ="row" style= "max-height:40%; text-align: left;margin: 1%;">
                                        <h1 class="postitle"><?php echo htmlspecialchars($post->title) ?></h1>
                                    </div>
                                    <div class='row' style='text-align: left; margin:1%'>
                                        <h3 class="postsubtitle"> <?php echo htmlspecialchars($post->place) ?> </h3>
                                    </div>
                                    <div class='row' style ='max-height: 10%;margin: 1%;'>
                                        <span class="badge badge-pill badge-success">
                                            <?php
                                            if ($post->money != null) {
                                                echo htmlspecialchars($post->money);
                                            }
                                            ?>
                                        </span>
                                        <span class="badge badge-pill badge-secondary"> <?php echo htmlspecialchars($post->duration) ?> jours</span>
                                    </div>
                                    <div class='row ' style='max-height: 40%; text-align: left; margin: 2% 1% 1% 1%;'>
                                        <a class="posttext"> <?php echo htmlspecialchars($post->description) ?> </a>
                                    </div>
                                    <div class='row justify-content-between' style ='max-height: 10%; margin: 1%;'>
                                        <div class='col-3'>
                                            <a href="index.php?page=profile&user=<?php echo htmlspecialchars($post->loginuser) ?>" class="stretched-link" style="color: #c8cbcf;">
                                                <?php echo htmlspecialchars($post->loginuser) ?>
                                            </a>  
                                        </div>
                                        <?php if (Utilisateur::islogged() && $_SESSION['username'] == $user->username) {
                                            ?>
                                            <div class="col-1">
                                                <a data-post='<?php echo $post->idpost ?>' class="btn deletepostbutton" style = "border-radius: 4mm; color: red">Supprimer publication</a>
                                            </div>
                                        <?php }
                                        ?>
                                        <div class="col-3">
                                            <a href="index.php?page=post&idpost=<?php echo htmlspecialchars($post->idpost) ?>" class="btn" style = "border-radius: 4mm;">Voir publication</a>
                                        </div>
                                        <!--Message de confirmation de suppression du post-->
                                        <div class = "alert alert-danger deletealert" role = "alert" style="text-align: center">
                                            Vous êtes sûr(e) de vouloir supprimer cette publication?
                                            <button class="btn btn-light canceldelete">Annuler la suppression</button>
                                            <a class="btn btn-danger" href="index.php?page=profile&idpost=<?php echo $post->idpost ?>&todo=deletepost">Supprimer la publication</a>
                                        </div>
                                    </div>
                                </div>
                                <!--Fin du div d'un post-->

                            </div>
                        <?php } while ($post = $sth->fetch()) ?>

                        <?php
                        if ($pagenum == $totalpages - 1) {
                            $next = $totalpages - 1;
                        } else {
                            $next = $pagenum + 1;
                        }
                        if ($pagenum == 0) {
                            $back = 0;
                        } else {
                            $back = $pagenum - 1;
                        }
                        ?>
                        <nav  aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item"><a class="page-link" href="index.php?page=profile&user=<?php echo htmlspecialchars($user->username) ?>&pagenum=<?php echo $back ?>" >Previous</a></li>
                                <?php
                                $style = '';
                                for ($i = 0; $i < $totalpages; $i++) {
                                    if ($pagenum == $i) {
                                        $style = 'active';
                                    } else {
                                        $style = '';
                                    }
                                    echo '<li class="page-item ' . $style . ' " ><a class="page-link" href="index.php?page=profile&user=' . htmlspecialchars($user->username) . '&pagenum=' . $i . '">' . $i . '</a></li>';
                                }
                                ?>
                                <li class="page-item"><a class="page-link" href="index.php?page=profile&user=<?php echo htmlspecialchars($user->username) ?>&pagenum=<?php echo $next ?>" >Next</a></li>
                            </ul>
                        </nav>
                        <?php
                    } else {
                        ?>
                        <h6 class="text-muted" style="font-style: italic; text-align: center">
                            Aucune publication
                        </h6>
                        <?php
                        ?>
                    <?php } 
                    ?>

                </div>

                <!--Content settings-->
                <div class ="justify-content-around" id="content-settings">
                    <div class="shadow-none p-3 mb-5 bg-light rounded">
                        <h5 class="text-muted" style="text-align: center">
                            GÉRER COMPTE
                        </h5>   
                    </div>
                    <div style="margin-top: 5rem">
                        <div style="text-align: center; margin: 2rem;">
                            <a href="index.php?page=editprofile" class="btn btn-outline-secondary" style="width: 20rem">Éditer votre profil</a>
                        </div>
                        <div style="text-align: center; margin: 2rem">
                            <a href="index.php?page=changepassword" class="btn btn-outline-secondary" style="width: 20rem">Changer mot de passe</a>
                        </div>
                        <div style="text-align: center; margin: 2rem">
                            <a href="index.php?page=deleteaccount" class="btn btn-outline-danger" style="width: 20rem">Supprimer votre compte</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

