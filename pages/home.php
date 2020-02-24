<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<?php
$sql_code = 'SELECT * FROM `posts` WHERE loginuser LIKE ? AND place LIKE ? AND duration ';
$array = array(
    'username' => '%%',
    'place' => '%%',
    'duration' => '0'
);
if (isset($_POST['username'])) {
    $array['username'] = "%" . $_POST['username'] . "%";
}
if (isset($_POST['duration']) && $_POST['duration'] != '') {
    $sql_code = $sql_code . " = ?";
    $array['duration'] = $_POST['duration'];
} else {
    $sql_code = $sql_code . "> ?";
}

if (isset($_POST['place'])) {
    $array['place'] = '%' . $_POST['place'] . '%';
}

if (isset($_GET['pagenum'])) {
    $pagenum = intval($_GET['pagenum']);
} else {
    $pagenum = 0;
}

$itemsperpage = 8;
//$sth = Post::getposts($dbh, $user->username, $pagenum, $itemsperpage);
$offsetpost = $pagenum * $itemsperpage;
$sql = $sql_code . " LIMIT $itemsperpage OFFSET $offsetpost";
$sth = $dbh->prepare($sql);
$sth->setFetchMode(PDO::FETCH_CLASS, 'Post');
$sth->execute(array($array['username'], $array['place'], $array['duration']));
$post = $sth->fetch();
$numrows = $sth->rowCount();

$totalposts = Post::numpostsconstraint($dbh, $sql_code, array($array['username'], $array['place'], $array['duration']));
$totalpages = ceil($totalposts / $itemsperpage);
?>



<div class ="prof">
    <div class="shadow-none p-3 bg-light rounded">
        <div class ="row align-content-center" style="text-align: center; font-family: Georgia; margin: 4px">
            <div class="col-12">
                <a style="font-size: 18pt">Recherchez un itinéraire!</a>
            </div>
        </div>
        <div class="row justify-content-center align-content-center" style="margin-top: 10px;">
            <form class="form-inline" action="index.php?page=home" method="post">
                <div class="col-md-12 col-lg-3 col-sm-12" style=" text-align: center; margin: 5px;">
                    <input class="form-control mr-sm-2" placeholder="Auteur du post" name="username">
                </div>
                <div class="col-md-12 col-lg-3 col-sm-12" style=" text-align: center; margin: 5px;">
                    <input class="form-control mr-sm-2" placeholder="Duration de voyage" name="duration">
                </div>
                <div class="col-md-12 col-lg-3 col-sm-12" style=" text-align: center; margin: 5px;">
                    <input class="form-control mr-sm-2" placeholder="Lieu de voyage" name="place">
                </div>
                <div class="col-md-12 col-lg-1 col-sm-12" style=" text-align: center;margin: 5px;">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </div>
            </form>

        </div>
    </div>
    <div class="row" style="margin: 5px; background-color: white">
        <div class ="justify-content-around active" id="content-posts">       
            <?php
            if ($totalposts > 0) {
                do {
                    ?>
                    <div class="row justify-content-between" style="margin: 1%">
                        <div class ="col-md-4 col-lg-4">
                            <img class="rounded" style = "display: block; margin-left: auto; margin-right: auto; width: 100%; height: auto;" alt=""<?php echo "src='images/posts/" . $post->idpost . ".jpg'" ?>  >

                        </div> 
                        <div class ="col-md-8 col-lg-8">
                            <div class ="row" style= "max-height:40%; text-align: left;margin: 1%;">
                                <h1 class="postitle"><?php echo $post->title ?></h1>
                            </div>
                            <div class='row' style='text-align: left; margin:1%'>
                                <h3 class="postsubtitle"> <?php echo $post->place ?> </h3>
                            </div>
                            <div class='row' style ='max-height: 10%;margin: 1%;'>
                                <span class="badge badge-pill badge-success">
                                    <?php
                                    if ($post->money != null) {
                                        echo $post->money;
                                    }
                                    ?>
                                </span>
                                <span class="badge badge-pill badge-secondary"> <?php echo $post->duration ?> jours</span>
                            </div>
                            <div class='row ' style='max-height: 40%; text-align: left; margin: 2% 1% 1% 1%;'>
                                <a class="posttext"> <?php echo $post->description ?> </a>
                            </div>
                            <div class='row justify-content-between' style ='max-height: 10%; margin: 1%;'>
                                <div class='col-3'>
                                    <a href="index.php?page=profile&user=<?php echo $post->loginuser ?>" class="stretched-link" style="color: #c8cbcf;">
                                        <?php echo $post->loginuser ?>
                                    </a>       
                                </div>
                                <div class="col-3">
                                    <a href="index.php?page=post&idpost=<?php echo $post->idpost ?>" class="btn" style = "border-radius: 4mm;">Voir post</a>
                                </div>
                            </div>


                        </div>

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
                        <li class="page-item"><a class="page-link" href="index.php?page=home&pagenum=<?php echo $back ?>" >Previous</a></li>
                        <?php
                        $style = '';
                        for ($i = 0; $i < $totalpages; $i++) {
                            if ($pagenum == $i) {
                                $style = 'active';
                            } else {
                                $style = '';
                            }
                            echo '<li class="page-item ' . $style . ' " ><a class="page-link" href="index.php?page=home&pagenum=' . $i . '">' . $i . '</a></li>';
                        }
                        ?>
                        <li class="page-item"><a class="page-link" href="index.php?page=home&pagenum=<?php echo $next ?>" >Next</a></li>
                    </ul>
                </nav>
            <?php } else {
                ?>
                <!--                        <div class="shadow-sm p-3 mb-5 bg-white rounded">-->
                <h6 class="text-muted" style="font-style: italic; text-align: center">
                    Aucun post
                </h6>
                <!--                        </div>-->
            <?php }
            ?>

        </div>
    </div>
</div>


