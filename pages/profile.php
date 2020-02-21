<?php
$user = Utilisateur::getUtilisateur($dbh, $_GET['user']);
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
<div class ="container-fluid" style="  height: 800px">
    <div class =" column_profile">
        <div class ='up'>
            <div class ="username" >
                <?php echo "<h5>" . $user->username . " </h5>" ?>
            </div>            
        </div>
        <div class ='profile_image'>
            <?php
            if(file_exists('images/avatars/'.$user->username.'.jpg')){
                echo "<img src = 'images/avatars/" .$user->username. ".jpg' alt = ''>";
            } else{

                echo "<img src = 'https://www.casadasciencias.org/themes/casa-das-ciencias/assets/images/icons/icon-login-default.png' alt = ''>";
            }
            ?>

        </div>
        <div class ='down'> 
            <div class ="container">
                <div class ="row justify-content-end">
                    <div class ="col-md-8">
                        <?php echo "<h2>" . $user->firstname . " " . $user->lastname . " </h2>"; ?>
                    </div>

                </div>
                <div class ="row justify-content-end">
                    <div class ="col-md-8">

                    </div>
                </div>
                <div class ="row justify-content-end">


                </div>

            </div>

        </div>
    </div>

    <div class ="posts justify-content-around">
        <div class ="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light" style = "background-color: #17a2b8 ; border: 1.5px solid #0056b3"> 

                <h2 style=" font-family: Comic Sans MS; font-style: italic"> Vos postages</h2>      
            </nav>

            <?php
            if ($totalposts > 0) {
                do {
                    ?>
                    <div class="row justify-content-around" style = "margin-top: 10px">
                        <div class="col-md-8 col-lg-8 col-sm-10">
                            <div class="card text-center" style = " border: 1px solid grey; border-radius: 9mm">
                                <div class="card-header">
        <?php echo $post->loginuser; ?>
                                </div>
                                <div class="card-body">
                                    <img style="width: 15%; height: 80%; float: left; border: 1px solid black; margin-top:1%; " <?php echo "src='avatars/" . $post->idpost . ".jpg'" ?> >
                                    <h5 class="card-title"> <?php echo $post->title ?> </h5>
                                    <p class="card-text"><?php echo $post->description ?></p>

                                </div>
                                <div class="card-footer text-muted">
                                    <div class ="row justify-content-between">
                                        <div class="col-3" >
                                            Posted on 22/03/2019
                                        </div>
                                        <div class="col-4 justify-content-end">
                                            <span class="badge badge-pill badge-success">
                                                <?php
                                                if ($post->money != null) {
                                                    echo '' . Post::generatemoneysimbol($post->money);
                                                }
                                                ?>
                                            </span>
                                            <span class="badge badge-pill badge-secondary"><?php echo $post->duration ?> </span>
                                            <a href="#" class="btn btn-primary" style = "border-radius: 4mm;">Voir post</a>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                <?php } while ($post = $sth->fetch()) ?>

                <?php
                if ($pagenum == $totalpages) {
                    $next = $totalpages;
                } else {
                    $next = $pagenum + 1;
                }
                if ($pagenum == 0) {
                    $back = 0;
                } else {
                    $back = $pagenum - 1;
                }
                ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="index.php?page=profile&user=<?php echo $user->username ?>&pagenum=<?php echo $back ?>" >Previous</a></li>
                        <?php
                        $style = '';
                        for ($i = 0; $i < $totalpages; $i++) {
                            if ($pagenum == $i) {
                                $style = 'active';
                            } else {
                                $style = '';
                            }
                            echo '<li class="page-item ' . $style . ' " ><a class="page-link" href="index.php?page=profile&user=' . $user->username . '&pagenum=' . $i . '">' . $i . '</a></li>';
                        }
                        ?>
                        <li class="page-item"><a class="page-link" href="index.php?page=profile&user=<?php echo $user->username ?>&pagenum=<?php echo $next ?>" >Next</a></li>
                    </ul>
                </nav>
<?php } ?>


        </div>


    </div>