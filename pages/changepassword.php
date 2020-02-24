<?php
if (!Utilisateur::islogged()) {
    echo "<h4 style='text-align: center; margin-top: 1rem'> Page non autorisée </h4>";
    return;
} else {
    $user = Utilisateur::getUtilisateur($dbh, $_SESSION['username']);

    // Variables de test
    $form_values_valid = false;
    $current_password_fail = false;
    $password_fail = false;
    $password_verification_fail = false;

    // Vérifier s'il y a des données à traiter
    // Vérification des champ requis
    if (isset($_POST['currentPassword']) && $_POST['currentPassword'] != "" &&
            isset($_POST['password']) && $_POST['password'] != "" &&
            isset($_POST['up2']) && $_POST['up2'] != "") {

        //Traitement des données
        if (!Utilisateur::testerMdp($dbh, $user, $_POST['currentPassword'])) { // Vérifier l'ancien mot de passe
            $current_password_fail = true;
        } elseif (!valide_password($_POST['password'])) { // Password
            $password_fail = true;
        } elseif (!valide_password_verification($_POST['password'], $_POST['up2'])) { //Vérifier que les deux entrées pour le nouveau mot de passe sont identiques
            $password_verification_fail = true;
        } else {
            $form_values_valid = true;
            Utilisateur::changePassword($dbh, $user->username, $_POST['password']);
            ?>
            <div class ="row" style="margin-top: 7rem">
                <div class="col-md-4 offset-md-4 card text-center" style="width: 30rem;">
                    <div class="card-body">
                        <h5 class="card-title">Votre mot de passe a bien été mis à jour!</h5>
                        <p class="card-text">Cliquez ci-dessous pour revenir à la page de profil</p>
                        <a href="index.php?page=profile" class="btn btn-primary">Profil</a>
                    </div>
                </div>
            </div>
            <?php
        }

//      Mettre à jour le mot de passe haché (fonction SHA1($passwd)) dans la base de données.
    }

    if (!$form_values_valid) {
        ?>
        <div class="container" style="padding: 20px; background-color: white">
            <!--Titre du formulaire-->
            <div class="shadow-none p-3 mb-5 bg-light rounded">
                <h5 class="text-muted" style="text-align: center">
                    CHANGER LE MOT DE PASSE
                </h5>
            </div>
            <!--Formulaire-->
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <form class="needs-validation" novalidate action="index.php?page=changepassword" method=post
                          oninput="up2.setCustomValidity(up2.value != password.value ? 'Les mots de passe diffèrent.' : '')">              

                        <!--Mot de passe actuelle-->
                        <div class="form-group row">
                            <label for="currentPassword" class="col-sm-4 offset-md-1 col-form-label">Mot de passe actuel</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="currentPassword" required name="currentPassword">
                                <div class="invalid-feedback">
                                    Ce champ est obligatoire!
                                </div>
                                <?php
                                if ($current_password_fail) {
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

                        <!--Nouveau mot de passe-->
                        <div class="form-group row">
                            <label for="password1" class="col-sm-4 offset-md-1 col-form-label">Nouveau mot de passe</label>
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

                        <!--Confirmation du nouveau mot de passe-->
                        <div class="form-group row">
                            <label for="password2" class="col-sm-4 offset-md-1 col-form-label">Confirmez votre nouveau mot de passe</label>
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
?>

<!-- Pour la vérification côté client-->
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<!-- Pour l'animation de l'input de la photo de profil-->
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
<script>
    $(document).ready(function () {
        bsCustomFileInput.init();
    });

    bsCustomFileInput.init();

    var btn = document.getElementById('btnResetForm');
    var form = document.querySelector('form');
    btn.addEventListener('click', function () {
        form.reset();
    });
</script>

