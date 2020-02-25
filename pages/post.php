<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<?php
if (!isset($_GET['idpost'])) {
    echo 'Post inexistente';
} else {
    $post = POST::getpost($dbh, $_GET['idpost']);
    if ($post == true) {
        $sql_code = "SELECT * FROM `stops` WHERE idpost = ?";
        $sth = $dbh->prepare($sql_code);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Stop');
        $sth->execute(array($post->idpost));
        $stop = $sth->fetch();
        $numrows = $sth->rowCount();
        ?>
        <div class="jumbotron bg-cover text-white" style="background-image:url(images/posts/<?php echo$post->idpost ?>.jpg)">
            <div class='overlay'></div>
            <div class="container">
                <h1 class="display-4"><?php echo $post->title ?></h1>
                <p class="lead"><?php echo $post->description ?></p>
                <hr class="my-4">
                <p><?php echo $post->place ?></p>
            </div>
            <!-- /.container   -->
        </div>
<div class ="container-fluid" style="height: auto; eidth:100%; margin:0; padding:0 ; text-align: center; color: #c8cbcf; font-style: italic ">
    <p> Posted by
                <a class="streched-link" href="index.php?page=profile&user=<?php echo $post->loginuser?>" style="color: #c8cbcf "><?php echo $post->loginuser?></a>
    </p>
</div>

        <div class="container py-3">
            <?php
            if ($numrows > 0) {

                do {
                    ?>
                    <!-- Card Start -->
                    <div class="card">
                        <div class="row align-content-center">

                            <div class="col-md-7 px-3">
                                <div class="card-block px-6">
                                    <p class="card-title">
                <?php echo $stop->title ?>
                                    </p>
                                    <p class=" card-adress">
                <?php echo $stop->adress ?>
                                    </p>
                                    <p class="card-text"><?php echo $stop->description ?></p>
                                    <br>
                                    <span class="badge badge-pill badge-secondary"> <?php echo $stop->time ?></span>
                                    <?php if ($stop->money != null) { ?>
                                        <span class="badge badge-pill badge-success"><?php echo $stop->money ?></span>
                <?php } ?>
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
            }
            ?>
        </div>
        <!-- End of container -->
        <?php
    } else {
        echo 'Post inexistente';
    }
}
