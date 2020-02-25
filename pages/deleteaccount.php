<?php
if (!Utilisateur::islogged()) {
    echo "<h4 style='text-align: center; margin-top: 1rem'> Page non autorisée </h4>";
    return;
} else {
    $user = Utilisateur::getUtilisateur($dbh, $_SESSION['username']);

    // Variables de test
    $password_fail = false;

    // Si l'utilisateur retourne à cette page avec un password défini, c'est parce que il y a eu un problème de vérification dans la page index
    if (isset($_POST['password'])) {
        $password_fail = true;
    }
    ?>
    <!--Affichage du formulaire-->
    <div class="container" style="padding: 20px; background-color: white">
        <!--Titre du formulaire-->
        <div class="shadow-none p-3 mb-5 bg-light rounded">
            <h5 class="text-muted" style="text-align: center">
                SUPPRIMER VOTRE COMPTE
            </h5>
        </div>
        <!--Formulaire-->
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form class="needs-validation" novalidate action="index.php?todo=deleteaccount" method=post>

                    <!--Affichage de l'email de l'utilisateur-->
                    <div class="form-group row">
                        <label for="useremail" class="col-sm-4 offset-md-1 col-form-label" style="text-align: center">Email</label>
                        <div class="col-sm-6">
                            <input type="text" readonly class="form-control-plaintext" id="useremail" value="<?php echo $user->email ?>">
                        </div>
                    </div>

                    <!--Mot de passe-->
                    <div class="form-group row">
                        <label for="password" class="col-sm-4 offset-md-1 col-form-label" style="text-align: center">Mot de passe</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="password" required name="password">
                            <div class="invalid-feedback">
                                Ce champ est obligatoire!
                            </div>
                            <?php
                            if ($password_fail) {
                                ?>
                                <div class="alert alert-danger" role="alert">
                                    <small>
                                        Le mot de passe entré ne correspond pas au mot de passe actuel. 
                                    </small>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>                

                    <!--Bouton de submission-->
                    <div class="form-group row" style="margin-top: 1.5rem">
                        <input type=submit class="col-md-4 offset-md-4 btn btn-danger" value="Supprimer compte">
                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php
}

