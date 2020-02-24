<?php
if (!Utilisateur::islogged()) {
    echo "<h4 style='text-align: center; margin-top: 1rem'> Page non autorisée </h4>";
    return;
} else {
    $user = Utilisateur::getUtilisateur($dbh, $_SESSION['username']);

    // Variables de test
    $form_values_valid = false;
    $photo_fail = false;
    $photo_delete_fail = false;

    // Vérifier s'il y a des données à traiter
    //Vérification des champ requis
    if (isset($_POST['lastname']) && $_POST['lastname'] != "" &&
            isset($_POST['firstname']) && $_POST['firstname'] != "" &&
            isset($_POST['birth']) && $_POST['birth'] != "") {

        //Traitement des données
        if (!empty($_FILES['photo']['tmp_name']) && valide_photo($user->username, $_FILES['photo']) != 0) {
            $photo_fail = true;
            // Vérification du type d'erreur de la photo de profil
            switch (valide_photo($user->username, $_FILES['photo'])) {
                case 1:
                    $photo_error_message = "Mauvais type de fichier. Veuillez sélectioner un fichier du type JPG.";
                    break;
                case 2:
                    $photo_error_message = "Fichier trop volumineux. Veuillez choisir un fichier plus petit.";
                    break;
                case 3:
                    $photo_error_message = "Échec du téléchargement. Veuillez essayer à nouveau.";
                    break;
            }
        } elseif (empty($_FILES['photo']['tmp_name'])) {
            //Traiter la demande de suppression da la photo actuelle
            if (isset($_POST['checkbox'])) {
                if (!unlink('images/avatars/' . $user->username . '.jpg')) {
                    $photo_delete_fail = true;
                    $delete_fail_message = "Erreur lors de la suppression de la photo de profil actuelle.";
                } else {
                    $form_values_valid = true;
                    Utilisateur::editProfile($dbh, $user->username, $_POST['lastname'], $_POST['firstname'], $_POST['birth']);
                    ?>
                    <div class ="row" style="margin-top: 7rem">
                        <div class="col-md-4 offset-md-4 card text-center" style="width: 30rem;">
                            <div class="card-body">
                                <h5 class="card-title">Votre profil a bien été mis à jour!</h5>
                                <p class="card-text">Cliquez ci-dessous pour revenir à la page de profil</p>
                                <a href="index.php?page=profile" class="btn btn-primary">Profil</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                $form_values_valid = true;
                Utilisateur::editProfile($dbh, $user->username, $_POST['lastname'], $_POST['firstname'], $_POST['birth']);
                ?>
                <div class ="row" style="margin-top: 7rem">
                    <div class="col-md-4 offset-md-4 card text-center" style="width: 30rem;">
                        <div class="card-body">
                            <h5 class="card-title">Votre profil a bien été mis à jour!</h5>
                            <p class="card-text">Cliquez ci-dessous pour revenir à la page de profil</p>
                            <a href="index.php?page=profile" class="btn btn-primary">Profil</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {

            $form_values_valid = true;
            Utilisateur::editProfile($dbh, $user->username, $_POST['lastname'], $_POST['firstname'], $_POST['birth']);
            ?>
            <div class ="row" style="margin-top: 7rem">
                <div class="col-md-4 offset-md-4 card text-center" style="width: 30rem;">
                    <div class="card-body">
                        <h5 class="card-title">Votre profil a bien été mis à jour!</h5>
                        <p class="card-text">Cliquez ci-dessous pour revenir à la page de profil</p>
                        <a href="index.php?page=profile" class="btn btn-primary">Profil</a>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    if (!$form_values_valid) {
        // Pour les champs déjà remplis
        // Lastname
        if (isset($_POST['lastname'])) {
            $lastname = $_POST['lastname'];
        } else {
            $lastname = $user->lastname;
        }
        // Firstname
        if (isset($_POST['firstname'])) {
            $firstname = $_POST['firstname'];
        } else {
            $firstname = $user->firstname;
        }
        ?>

        <div class="container" style="padding: 20px; background-color: white">
            <!--Titre du formulaire-->
            <div class="shadow-none p-3 mb-5 bg-light rounded">
                <h5 class="text-muted" style="text-align: center">
                    ÉDITION DE PROFIL
                </h5>
            </div>
            <!--Formulaire-->
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <form class="needs-validation" novalidate action="index.php?page=editprofile" method=post enctype="multipart/form-data">              

                        <!--Nom-->
                        <div class="form-group row">
                            <label for="nom" class="col-sm-4 offset-md-1 col-form-label">Nom</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="nom" required name="lastname" value="<?php echo $lastname ?>">
                                <div class="invalid-feedback">
                                    Ce champ est obligatoire!
                                </div>
                            </div>
                        </div>

                        <!--Prenom-->
                        <div class="form-group row">
                            <label for="prenom" class="col-sm-4 offset-md-1 col-form-label">Prenom</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="prenom" required name="firstname" value="<?php echo $firstname ?>">
                                <div class="invalid-feedback">
                                    Ce champ est obligatoire!
                                </div>
                            </div>
                        </div>

                        <!--Naissance-->
                        <div class="form-group row">
                            <label for="naissance" class="col-sm-4 offset-md-1 col-form-label">Date de naissance</label>
                            <div class="col-sm-6">
                                <input type="date" class="form-control" id="naissance" required name="birth">
                                <div class="invalid-feedback">
                                    Ce champ est obligatoire!
                                </div>
                            </div>
                        </div>

                        <!--Photo de profil-->
                        <div class="form-group row">
                            <label for="customFile" class="col-sm-4 offset-md-1 col-form-label">Changer la photo de profil</label>
                            <div class="col-sm-4 offset-md-1 custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="photo">
                                <label class="custom-file-label" for="customFile">Choisissez le fichier</label>
                            </div>
                            <div class="container row">
                                <div class="col-7 offset-5">
                                    <small id="photoHelpBlock" class="form-text text-muted">
                                        Le fichier doit être du type JPG. La photo de profil n'est pas obligatoire.
                                    </small>
                                    <?php
                                    if ($photo_fail) {
                                        ?>
                                        <div class="alert alert-danger" role="alert">
                                            <small>
                                                <?php echo $photo_error_message; ?>
                                            </small>
                                        </div>         
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!--Supprimer la photo de profil actuelle-->
                        <?php
                        if (file_exists('images/avatars/' . $user->username . '.jpg')) {
                            ?>
                            <div class="form-group row">
                                <div class="col-sm-6 offset-5 form-group form-check" style="text-align: center">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="checkbox">
                                    <label class="form-check-label" for="exampleCheck1">Supprimer la photo de profil actuelle</label>
                                    <?php
                                    if ($photo_delete_fail) {
                                        ?>
                                        <div class="alert alert-danger" role="alert">
                                            <small>
                                                <?php echo $delete_fail_message; ?>
                                            </small>
                                        </div>         
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        <!--Bouton de submission-->
                        <div class="form-group row" style="margin-top: 1.5rem">
                            <input type=submit class="col-md-4 offset-md-4 btn btn-primary" value="Sauvegarder">
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <?php
    }
}


