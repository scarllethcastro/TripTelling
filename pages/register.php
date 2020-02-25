<?php
// Variables de test
$form_values_valid = false;
$username_fail = false;
$email_fail = false;
$password_fail = false;
$password_verification_fail = false;
$photo_fail = false;

//var_dump($_FILES);

if (isset($_POST['username']) && $_POST['username'] != "" && //Vérification des champ requis
        isset($_POST['lastname']) && $_POST['lastname'] != "" &&
        isset($_POST['firstname']) && $_POST['firstname'] != "" &&
        isset($_POST['birth']) && $_POST['birth'] != "" &&
        isset($_POST['email']) && $_POST['email'] != "" &&
        isset($_POST['password']) && $_POST['password'] != "" &&
        isset($_POST['up2']) && $_POST['up2'] != "") {

    //Traitement des données
    //Username
    if (!valide_username($dbh, $_POST['username'])) {
        $username_fail = true;
    } elseif (!valide_email($dbh, $_POST['email'])) { // Email
        $email_fail = true;
    } elseif (!valide_password($_POST['password'])) { // Password
        $password_fail = true;
    } elseif (!valide_password_verification($_POST['password'], $_POST['up2'])) {
        $password_verification_fail = true;
    } elseif (!empty($_FILES['photo']['tmp_name']) && valide_photo($_POST['username'], $_FILES['photo']) != 0) {
        $photo_fail = true;
        // Vérification du type d'erreur de la photo de profil
        switch (valide_photo($_POST['username'], $_FILES['photo'])) {
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
    } else {
        $form_values_valid = true;
        Utilisateur::insererUtilisateur($dbh, $_POST['username'], $_POST['password'], $_POST['lastname'], $_POST['firstname'], $_POST['birth'], $_POST['email']);
        ?>
        <div class ="row" style="margin-top: 7rem">
            <div class="col-md-4 offset-md-4 card text-center" style="width: 30rem;">
                <div class="card-body">
                    <h5 class="card-title">Vous avez bien été enrégistré(e)!</h5>
                    <p class="card-text">Cliquez ci-dessous pour revenir à la page initiale</p>
                    <a href="index.php?page=welcome" class="btn btn-primary">Page initiale</a>
                </div>
            </div>
        </div>
        <?php
    }
}

if (!$form_values_valid) {
    // Pour les champs déjà remplis
    // Username
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
    } else {
        $username = "";
    }
    // Lastname
    if (isset($_POST['lastname'])) {
        $lastname = $_POST['lastname'];
    } else {
        $lastname = "";
    }
    // Firstname
    if (isset($_POST['firstname'])) {
        $firstname = $_POST['firstname'];
    } else {
        $firstname = "";
    }
    // Email
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $email = "";
    }
    ?>

    <div class="container" style="padding: 20px; background-color: white">
        <!--Titre du formulaire-->
        <div class="shadow-none p-3 mb-5 bg-light rounded">
            <h5 class="text-muted" style="text-align: center">
                ENREGISTREMENT
            </h5>
        </div>
        <!--Formulaire-->
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form class="needs-validation" novalidate action="index.php?page=register" method=post enctype="multipart/form-data"
                      oninput="up2.setCustomValidity(up2.value != password.value ? 'Les mots de passe diffèrent.' : '')">              
                    <!--Nom d'utilisateur-->
                    <div class="form-group row">
                        <label for="username" class="col-sm-4 offset-md-1 col-form-label">Nom d'utilisateur</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="username" required name="username" value="<?php echo $username ?>">
                            <div class="invalid-feedback">
                                Ce champ est obligatoire!
                            </div>
                            <small id="usernameHelpBlock" class="form-text text-muted">
                                Le nom d'utilisateur sert à vous identifier dans notre communauté, et sera affiché sur votre page de profil. Il ne doit pas contenir d'espace ni des caractères spéciaux.
                            </small>
                            <?php
                            if ($username_fail) {
                                ?>
                                <div class="alert alert-danger" role="alert">
                                    <small>
                                        Ce nom d'utilisateur n'est pas valide ou n'est pas disponible.
                                    </small>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

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

                    <!--Email-->
                    <div class="form-group row">
                        <label for="email" class="col-sm-4 offset-md-1 col-form-label">Email</label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="email" required name="email" value="<?php echo $email ?>">
                            <div class="invalid-feedback">
                                Ce champ est obligatoire!
                            </div>
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            <?php
                            if ($email_fail) {
                                ?>
                                <div class="alert alert-danger" role="alert">
                                    <small>
                                        Email non valide ou déjà enregistré.
                                    </small>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <!--Mot de passe-->
                    <div class="form-group row">
                        <label for="password1" class="col-sm-4 offset-md-1 col-form-label">Mot de passe</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="password1" required name="password">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Your password must be at least 6 characters long and contain only letters and numbers. It should not contain spaces, special characters, or emoji.
                            </small>
                            <div class="invalid-feedback">
                                Ce champ est obligatoire!
                            </div>
                            <?php
                            if ($password_fail) {
                                ?>
                                <div class="alert alert-danger" role="alert">
                                    <small>
                                        Mot de passe non valide. Vérifier l'existence des caractères spéciaux ou si votre mot de passe a au moins 6 caractères.
                                    </small>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <!--Confirmation du mot de passe-->
                    <div class="form-group row">
                        <label for="password2" class="col-sm-4 offset-md-1 col-form-label">Confirmez votre mot de passe</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="password2" name="up2">
                            <div class="invalid-feedback">
                                Les mots de passe diffèrent!
                            </div>
                            <?php
                            if ($password_verification_fail) {
                                ?>
                                <div class="alert alert-danger" role="alert">
                                    <small>
                                        Les mots de passe diffèrent.
                                    </small>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <!--Photo de profil-->
                    <div class="form-group row">
                        <label for="customFile" class="col-sm-4 offset-md-1 col-form-label">Photo de profil</label>
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

                    <!--Bouton de submission-->
                    <div class="form-group row" style="margin-top: 1.5rem">
                        <input type=submit class="col-md-4 offset-md-4 btn btn-info" value="Créer compte">
                    </div>

                </form>
            </div>
        </div>
    </div>

<?php }

