<?php
$user = Utilisateur::getUtilisateur($dbh, $_GET['user']);
?>
<div class ="container-fluid" style="  height: 800px">
    <div class =" column_profile">
        <div class ='up'>
            <div class ="username" >
                <?php echo "<h5>" . $user->name . " </h5>" ?>
            </div>            
        </div>
        <div class ='profile_image'>
            <img src = 'https://www.casadasciencias.org/themes/casa-das-ciencias/assets/images/icons/icon-login-default.png' alt = ''>

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


            <div class="row justify-content-around" style = "margin-top: 10px">
                <div class="col-md-8 col-lg-8 col-sm-10">
                    <div class="card text-center" style = " border: 1px solid grey; border-radius: 9mm">
                        <div class="card-header">
                            marcelosancor
                        </div>
                        <div class="card-body">
                            <img style="width: 15%; height: 80%; float: left; border: 1px solid black; margin-top:1%; " src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6e/Paris_-_Eiffelturm_und_Marsfeld2.jpg/1200px-Paris_-_Eiffelturm_und_Marsfeld2.jpg">
                            <h5 class="card-title">Paris</h5>
                            <p class="card-text">Paris é uma cidade muito chique. Na minha viagem para lá, fiquei maravilhado em como ela parece um museu a ceu aberto. 
                                Nesse itinerário voce verá como aproveitar não só os pontos turísticos de Paris, seus museus, etc, como também toda sua beleza natural.</p>

                        </div>
                        <div class="card-footer text-muted">
                            <div class ="row justify-content-between">
                                <div class="col-3" >
                                    Posted on 22/03/2019
                                </div>
                                <div class="col-4 justify-content-end">
                                    <span class="badge badge-pill badge-success">$$</span>
                                    <span class="badge badge-pill badge-secondary">2 days</span>
                                    <a href="#" class="btn btn-primary" style = "border-radius: 4mm;">Voir post</a>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>


        </div>


    </div>