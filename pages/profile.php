<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
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
<div class="prof" >
    <div class="row profile">
        <div class="col-md-3">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="" style="text-align: center">
                    <?php if (file_exists('images/avatars/' . $user->username . '.jpg')) { ?>
                        <img src="images/avatars/<?php echo $user->username ?>.jpg" class="img-responsive" alt=""> <?php } else {
                        ?>
                        <img src ="https://www.casadasciencias.org/themes/casa-das-ciencias/assets/images/icons/icon-login-default.png" class="img-responsive" alt = ''> 
                    <?php } ?>
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <?php echo $user->firstname;
                        echo " " . $user->lastname;
                        ?>
                    </div>
                    <div class="profile-usertitle-job">
<?php echo $user->username; ?>
                    </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
<!--                <div class="profile-userbuttons">
                    <button type="button" class="btn btn-success btn-sm">Follow</button>
                    <button type="button" class="btn btn-danger btn-sm">Message</button>
                </div>-->
                <!-- END SIDEBAR BUTTONS -->
                <!-- SIDEBAR MENU -->
                <div class="container" style ="margin-top: 5%; margin-bottom:5%;">
                    <div class="row">
                        <div class="col">
                            <div class="list-group" id="list-tab" role="tablist">
                                <a class="list-group-item list-group-item-action button-page active" id="posts" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Posts</a>
                                <a class="list-group-item list-group-item-action button-page" id="new-post" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Nouveau post</a>
                                <a class="list-group-item list-group-item-action button-page" id="settings" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">Gérer compte</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END MENU -->
            </div>
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                <!--Content posts-->
                <div class ="justify-content-around active" id="content-posts">       
                    <div class="shadow-none p-3 mb-5 bg-light rounded">
                        <h5 class="text-muted" style="text-align: center">
                            POSTS
                        </h5>
                    </div>
                    <?php
                    if ($totalposts > 0) {
                        do {
                            ?>
                            <div class="row justify-content-between" style="margin: 1%">
                                <div class ="col-md-4 col-lg-4">
                                    <img class="rounded" style = "display: block; margin-left: auto; margin-right: auto; width: 100%; height: auto;" alt=""<?php echo "src='avatars/" . $post->idpost . ".jpg'" ?>  >

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
                                                echo '' . Post::generatemoneysimbol($post->money);
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
                                            <a style="color: #c8cbcf;"><?php echo $post->loginuser ?></a>
                                        </div>
                                        <div class="col-3">
                                            <a href="#" class="btn" style = "border-radius: 4mm;">Voir post</a>
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
                
                <!--Content new post-->
                <div class ="justify-content-around" id="content-new-post">
                    <div class="shadow-none p-3 mb-5 bg-light rounded">
                        <h5 class="text-muted" style="text-align: center">
                            Nouveau post
                        </h5>
                    </div>
                </div>
                
                <!--Content settings-->
                <div class ="justify-content-around" id="content-settings">
                    <div class="shadow-none p-3 mb-5 bg-light rounded">
                        <h5 class="text-muted" style="text-align: center">
                            Gérer compte
                        </h5>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>

<script>
    $(function(){
        
        $('#content-new-post').hide();
        $('#content-settings').hide();
         
        $('.button-page').on('click',function(){
            //Discover which button was clicked
            var $buttonId = $(this).attr('id');
            //Discover which is the current content
            var $activeId = $(this).closest('.list-group').find('.active').attr('id');
            //Fade out current content
            $('#content-'+$activeId).hide(function(){
                //Make current content inactive
                $(this).removeClass('active');
                //Show the corresponding content
                $('#content-'+$buttonId).show(function(){
                    //Make corresponding content active
                    $(this).addClass('active');
                });
            });
            
        });
    });
</script>




