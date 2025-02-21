<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<?php
if (!isset($_GET['idpost'])) {
    echo 'Post inexistente';
} else {
    $post = POST::getpost($dbh, $_GET['idpost']);
    if ($post == true) {
        $sql_code = "SELECT * FROM `stops` WHERE idpost = ? AND day = 1 ORDER BY time";
        $sth = $dbh->prepare($sql_code);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Stop');
        $sth->execute(array($post->idpost));
        $stop = $sth->fetch();
        $numrows = $sth->rowCount();
        ?>

        <div class="editable" id="divInfoPost">
            <div class="jumbotron bg-cover text-white" style="background-image:url(images/posts/<?php echo$post->idpost ?>.jpg)">
                <div class='overlay'></div>
                <div class="container">
                    <h1 class="display-4 noedit"><?php echo htmlspecialchars($post->title) ?></h1>
                    <p class="lead noedit"><?php echo htmlspecialchars($post->description) ?></p>
                    <hr class="my-4">
                    <p class="noedit"><?php echo htmlspecialchars($post->place) ?></p>
                </div>
                <!-- /.container   -->
            </div>
            <div class ="container-fluid" style="height: auto; eidth:100%; margin:0; padding:0 ; text-align: center; color: #c8cbcf; font-style: italic ">
                <p> Posted by
                    <a class="streched-link" href="index.php?page=profile&user=<?php echo htmlspecialchars($post->loginuser) ?>" style="color: #c8cbcf "><?php echo htmlspecialchars($post->loginuser) ?></a>
                </p>
                <?php if (Utilisateur::islogged() && $_SESSION['username'] == $post->loginuser) {?>
                <button class="btn btn-outline-info noedit" id="editpostbutton"> Éditer publication</button>
                <?php } ?>
                <input class="form-control edit" type="text" placeholder="Titre" value="<?php echo htmlspecialchars($post->title) ?>"> 
                <textarea class="form-control edit" style="margin-top: 1rem" placeholder="Description..."><?php echo htmlspecialchars($post->description) ?></textarea>
                <input class="form-control edit" style="margin-top: 1rem; margin-bottom: 1rem" type="text" placeholder="Lieu de voyage" value="<?php echo htmlspecialchars($post->place) ?>">
                <button class="btn btn-secondary edit" id="canceleditpost"> Annuler</button>
                <button class="btn btn-success edit"> Sauvegarder</button>
            </div>
        </div>

        <div class="container py-3">
            <?php
            $jour = 1;
            if ($numrows > 0) {

                do {
                    ?>

                    <div class = "shadow-none p-3 mb-5 bg-light rounded" style = "margin-bottom: 1rem !important; margin-top: 2rem !important">
                        <h5 class = "text-muted" style = "text-align: center">
                            JOUR <?php echo htmlspecialchars($stop->day) ?>

                        </h5>
                    </div>
                    <?php
                    do {
                        ?>
                        <!-- Card Start -->
                        <div class="card">
                            <div class="row align-content-center">

                                <div class="col-md-7 px-3 editable">
                                    <div class="card-block px-6">
                                        <p class="card-title noedit stoptitle">
                                            <?php echo htmlspecialchars($stop->title) ?>
                                        </p>
                                        <input class="form-control edit stoptitleedit" type="text" placeholder="Titre" value="<?php echo htmlspecialchars($stop->title) ?>">
                                        <p class="card-adress noedit stopaddress">
                                            <?php echo htmlspecialchars($stop->adress) ?>
                                        </p>
                                        <input class="form-control edit stopaddressedit" style="margin-top: 1rem" type="text" placeholder="Adresse" value="<?php echo htmlspecialchars($stop->adress) ?>">
                                        <p class="card-text noedit stopdescription"><?php echo htmlspecialchars($stop->description) ?></p>
                                        <br>
                                        <textarea class="form-control edit stopdescriptionedit" style="margin-top: 1rem" placeholder="Description..."><?php echo htmlspecialchars($stop->description) ?></textarea>
                                        <span class="badge badge-pill badge-secondary noedit"> <?php echo explode(":", $stop->time)[0] . "h" . explode(":", $stop->time)[1] ?> </span>
                                        <input type="time" class="form-control edit" style="margin-top: 1rem">
                                        <?php if ($stop->money != null) { ?>
                                            <span class="badge badge-pill badge-success noedit"><?php echo htmlspecialchars($stop->money) ?></span>
                                        <?php } ?>
                                        <select class="form-control edit" style="margin-top: 1rem">
                                            <option selected>Choisissez...</option>
                                            <option value="1">$</option>
                                            <option value="2">$-$$</option>
                                            <option value="3">$$</option>
                                            <option value="4">$$-$$$</option>
                                            <option value="5">$$$</option>
                                            <option value="6">$$$-$$$$</option>
                                            <option value="7">$$$$</option>
                                        </select>
                                        <br>
                                        <br>
                                        <?php if (Utilisateur::islogged() && $_SESSION['username'] == $post->loginuser) {?>
                                        <button class="btn btn-outline-info noedit editstop"> Éditer arrêt </button>
                                        <?php } ?>
                                        <button class="btn btn-secondary edit canceleditstop"> Annuler</button>
                                        <button class="btn btn-success edit"> Sauvegarder</button>
                                    </div>
                                </div>
                                <!-- Carousel start -->
                                <div class="col-md-5">
                                    <div id="CarouselTest" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <li data-target="#CarouselTest" data-slide-to="0" class="active"></li>
                                            <?php for ($i = 1; file_exists("images/stops/$stop->idpost.$stop->idstop.$i.jpg"); $i++) { ?>
                                                <li data-target="#CarouselTest" data-slide-to="<?php echo $i ?>"></li>
                                            <?php } ?>


                                        </ol> 

                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <?php echo ' <img class="d-block" src="images/stops/' . $stop->idpost . '.' . $stop->idstop . '.0.jpg"  alt="">'; ?>
                                            </div>
                                            <?php
                                            for ($j = 1; file_exists("images/stops/$stop->idpost.$stop->idstop.$j.jpg"); $j++) {
                                                echo '<div class="carousel-item">';
                                                echo '<img class="d-block" src="images/stops/' . $stop->idpost . '.' . $stop->idstop . '.' . $j . '.jpg"  alt="">';
                                                echo '</div>';
                                            }
                                            ?>
                                            <a class="carousel-control-prev" href="#CarouselTest" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#CarouselTest" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of carousel -->
                            </div>
                        </div>
                        <!-- End of card -->

                        <?php
                    } while ($stop = $sth->fetch());
                    $jour++;
                    $sql_code = "SELECT * FROM `stops` WHERE idpost = ? AND day =" . $jour . " ORDER BY time";
                    $sth = $dbh->prepare($sql_code);
                    $sth->setFetchMode(PDO::FETCH_CLASS, 'Stop');
                    $sth->execute(array($post->idpost));
                    $stop = $sth->fetch();
                    $numrows = $sth->rowCount();
                } while ($jour <= $post->duration && $stop != null);
            }
            ?>

            <br>
            <div class="editable" id="divnewstop">
                <button type="button" id="createStop" class="col-md-2 offset-md-5 btn btn-success edit">+ Ajouter un arrêt</button>
            </div>
            <br>
        </div>
        <!-- End of container -->
        <?php
    } else {
        echo 'Post inexistente';
    }
}
