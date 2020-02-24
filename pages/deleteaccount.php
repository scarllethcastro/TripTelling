<?php
if (!Utilisateur::islogged()) {
    echo "<h4 style='text-align: center; margin-top: 1rem'> Page non autorisée </h4>";
    return;
} else {
    $user = Utilisateur::getUtilisateur($dbh, $_SESSION['username']);
    
    // Variables de test
    $form_values_valid = false;
    $password_fail = false;
    
    // Vérifier s'il y a des données à traiter
    // Vérification des champ requis
    if (isset($_POST['password']) && $_POST['password'] != ""){
        
        //Traitement des données
        if (!Utilisateur::testerMdp($dbh, $user, $_POST['password'])) { // Vérifier le mot de passe
            $password_fail = true;
        } else{
            $form_values_valid = true;
            // Fazer logout em algum momento
            Utilisateur::deleteUser($dbh, $user->username);
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
    }
    
    if (!$form_values_valid){
        ?>
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
                    <form class="needs-validation" novalidate action="index.php?page=deleteaccount" method=post>              

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
                            <input type=submit class="col-md-4 offset-md-4 btn btn-primary" value="Supprimer compte">
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
