<?php
if (!Utilisateur::islogged()) {
    echo "<h4 style='text-align: center; margin-top: 1rem'> Page non autorisée </h4>";
    return;
} else {
    $user = Utilisateur::getUtilisateur($dbh, $_SESSION['username']);

    // Variables de test
    $form_values_valid = false;
    $number_days_fail = false;
    $photo_post_fail = false;
    $photo_post_error_message = 'Il y a eu un problème avec une ou plusieurs des images choisies. Veuillez choisir des fichiers JPG et au maximum 3 par arrêt.';
    // Vérifier s'il y a des données à traiter
    if (isset($_POST['titlepost'])) {
        //Vérification des champ requis
        if ($_POST['titlepost'] != "" &&
                isset($_POST['place']) && $_POST['place'] != "" &&
                isset($_POST['duration']) && $_POST['duration'] != "" &&
                isset($_POST['descriptionpost']) && $_POST['descriptionpost'] != "" &&
                isset($_POST['titlestop1']) && $_POST['titlestop1'] != "" &&
                isset($_POST['descriptionstop1']) && $_POST['descriptionstop1'] != "" &&
                isset($_POST['day1']) && $_POST['day1'] != "" &&
                isset($_POST['time1']) && $_POST['time1'] != "") {

            //Traiter les données
            if (!is_int((int) $_POST['duration']) || (int) $_POST['duration'] < 1) {
                echo '<div class = "alert alert-danger" role = "alert">';
                echo "La durée entrée n'est pas un nombre entier";
                echo '</div>';
            } else {
                //Contagem das paradas
                $continuer = true;
                $num_stops = 1;
                do {
                    $indice = $num_stops + 1;
                    if (isset($_POST['titlestop' . $indice])) {
                        $num_stops++;
                    } else {
                        $continuer = false;
                    }
                } while ($continuer);

                //teste dos campos das outras paradas
                $mybool = true;
                for ($i = 1; $i <= $num_stops; $i++) {
                    if (!(isset($_POST['titlestop' . $i]) && $_POST['titlestop' . $i] != "" &&
                            isset($_POST['descriptionstop' . $i]) && $_POST['descriptionstop' . $i] != "" &&
                            isset($_POST['day' . $i]) && $_POST['day' . $i] != "" &&
                            isset($_POST['time' . $i]) && $_POST['time' . $i] != "")) {

                        $mybool = false;
                    }
                }

                $duration = (int) $_POST['duration'];
                if ($mybool) {
                    // Test dos dias das paradas
                    $mybool2 = true;
                    for ($i = 1; $i <= $num_stops; $i++) {
                        if (!is_int((int) $_POST['day' . $i]) || (int) $_POST['day' . $i] > $duration) {
                            $mybool2 = false;
                            echo '<div class = "alert alert-danger" role = "alert">';
                            echo "Les jours des arrêts ne correspondent pas à la durée de l'itinéraire";
                            echo '</div>';
                            break;
                        }
                    }

                    if ($mybool2) {
                        // teste das imagens
                        // imagem do post
                        if (empty($_FILES['photopost']['tmp_name']) || valide_photo_post($_FILES['photopost']) != 0) {
                            echo '<div class = "alert alert-danger" role = "alert">';
                            echo $photo_post_error_message;
                            echo '</div>';
                        } else {
                            //limitar imagens post a 3
                            $mybool3 = true;
                            for ($i = 1; $i <= $num_stops; $i++) {
                                if (empty($_FILES['photostop' . $i]['tmp_name'][0]) || !empty($_FILES['photostop' . $i]['tmp_name'][3])) {
                                    $mybool3 = false;
                                    echo '<div class = "alert alert-danger" role = "alert">';
                                    echo $photo_post_error_message;
                                    echo '</div>';
                                    break;
                                }
                            }
                            if ($mybool3) {
                                $mybool4 = true;
                                for ($i = 1; $i <= $num_stops; $i++) {
                                    for ($j = 0; $j < 3; $j++) {
                                        if (!empty($_FILES['photostop' . $i]['tmp_name'][$j]) && valide_photo_post($_FILES['photopost']) != 0) {
                                            $mybool4 = false;
                                            echo '<div class = "alert alert-danger" role = "alert">';
                                            echo $photo_post_error_message;
                                            echo '</div>';
                                            break;
                                        }
                                    }
                                }

                                if ($mybool4) {
                                    $idpost = Post::insererpost($dbh, $user->username, $_POST['titlepost'], $_POST['place'], $duration, $_POST['descriptionpost'], $_POST['moneypost']);
                                    if ($idpost != null) {
                                        $form_values_valid = true;
                                        echo '<div class = "alert alert-success" role = "alert">';
                                        echo "Publication crée avec succès!";
                                        echo '</div>';
                                        move_uploaded_file($_FILES['photopost']['tmp_name'], 'images/posts/' . $idpost . '.jpg');
                                        for ($i = 1; $i <= $num_stops; $i++) {
                                            $idstop = Stop::insererstop($dbh, $idpost, $_POST['descriptionstop' . $i], $_POST['moneystop' . $i], $_POST['adress' . $i], $_POST['time' . $i], $_POST['titlestop' . $i], $_POST['day' . $i]);
                                            if ($idstop != null) {
                                                for ($j = 0; $j < 3; $j++) {
                                                    if (!empty($_FILES['photostop' . $i]['tmp_name'][$j])) {
                                                        move_uploaded_file($_FILES['photostop' . $i]['tmp_name'][$j], 'images/stops/' . $idpost . '.' . $idstop . '.' . $j . '.jpg');
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    if (!$form_values_valid) {
        if (isset($_POST['titlepost'])) {
            $titlepost = $_POST['titlepost'];
        } else {
            $titlepost = "";
        }
        // Place
        if (isset($_POST['place'])) {
            $place = $_POST['place'];
        } else {
            $place = "";
        }
        // Duration
        if (isset($_POST['duration'])) {
            $duration = $_POST['duration'];
        } else {
            $duration = "";
        }
        // descriptionpost
        if (isset($_POST['descriptionpost'])) {
            $descriptionpost = $_POST['descriptionpost'];
        } else {
            $descriptionpost = "";
        }
        ?>



        <div class="container" style="padding: 20px; background-color: white">
            <!--Titre du formulaire-->
            <div class="shadow-none p-3 mb-5 bg-light rounded">
                <h5 class="text-muted" style="text-align: center">
                    NOUVELLE PUBLICATION
                </h5>
            </div>
            <!--Formulaire-->
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <form class="needs-validation" novalidate action="index.php?page=newpost" method=post enctype="multipart/form-data">              

                        <!--Titre-->
                        <div class="form-group row">
                            <label for="titlepost" class="col-sm-4 offset-md-1 col-form-label">Titre</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="titlepost" required name="titlepost" value="<?php echo $titlepost ?>">
                                <div class="invalid-feedback">
                                    Ce champ est obligatoire!
                                </div>
                            </div>
                        </div>

                        <!--Lieu de voyage-->
                        <div class="form-group row">
                            <label for="place" class="col-sm-4 offset-md-1 col-form-label">Lieu de voyage</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="place" required name="place" value="<?php echo $place ?>">
                                <div class="invalid-feedback">
                                    Ce champ est obligatoire!
                                </div>
                            </div>
                        </div>

                        <!--Durée-->
                        <div class="form-group row">
                            <label for="duration" class="col-sm-4 offset-md-1 col-form-label">Durée en jours</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="duration" required name="duration" min="1">
                                <div class="invalid-feedback">
                                    Ce champ est obligatoire!
                                </div>
                            </div>
                        </div>

                        <!--Description-->
                        <div class="form-group row">
                            <label for="descriptionpost" class="col-sm-4 offset-md-1 col-form-label">Description</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" id="descriptionpost" rows="4" required name="descriptionpost"><?php echo $descriptionpost ?></textarea>
                                <div class="invalid-feedback">
                                    Ce champ est obligatoire!
                                </div>
                            </div>
                        </div>

                        <!--Money-->
                        <div class="form-group row">
                            <label for="moneypost" class="col-sm-4 offset-md-1 col-form-label">Argent dépensé</label>
                            <div class="col-sm-6">                                                
                                <select class="form-control" id="moneypost" name="moneypost">
                                    <option selected>Choisissez...</option>
                                    <option value="1">$</option>
                                    <option value="2">$-$$</option>
                                    <option value="3">$$</option>
                                    <option value="4">$$-$$$</option>
                                    <option value="5">$$$</option>
                                    <option value="6">$$$-$$$$</option>
                                    <option value="7">$$$$</option>
                                </select>                                                          
                            </div>
                        </div>

                        <!--Photo du post-->
                        <div class="form-group row">
                            <label for="photopost" class="col-sm-4 offset-md-1 col-form-label">Photo de la publication</label>
                            <div class="col-sm-4 offset-md-1 custom-file">
                                <input type="file" class="custom-file-input" id="photopost" required name="photopost">
                                <label class="custom-file-label" for="photopost">Choisissez le fichier</label>
                            </div>
                            <div class="container row">
                                <div class="col-7 offset-5">
                                    <small id="photopostHelpBlock" class="form-text text-muted" style="text-align: center">
                                        La photo de la publication est obligatoire. Le fichier doit être du type JPG. 
                                    </small>
                                    <?php
                                    if ($photo_post_fail) {
                                        ?>
                                        <div class="alert alert-danger" role="alert">
                                            <small>
                                                <?php echo $photo_post_error_message; ?>
                                            </small>
                                        </div>         
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!--Création des stops-->
                        <div id="divstops" style="margin-top: 4rem">
                            <div class="shadow-none p-3 mb-5 bg-light rounded" style="margin-bottom: 1rem!important">
                                <h5 class="text-muted" style="text-align: center">
                                    ARRETS
                                </h5>
                            </div>
                            <!--Div d'une arrêt (TEMPLATE)-->
                            <!--                    <div id="stop1" class="shadow-none p-3 mb-5 bg-light rounded" style="margin-bottom: 2rem!important">
                                                    <div class="shadow-sm p-3 mb-5 bg-white rounded">
                                                        <h6 class="text-muted" style="text-align: center">
                                                            ARRÊT 1
                                                        </h6>
                                                    </div>
                            
                                                    Formulaire d'une arrêt
                                                    <div class="row">
                                                        <div class="col-md-10 offset-md-1">
                            
                                                            Titre
                                                            <div class="form-group row">
                                                                <label for="titlestop1" class="col-sm-4 offset-md-1 col-form-label">Titre</label>
                                                                <div class="col-sm-6">
                                                                    <input type="text" class="form-control" id="titlestop1" required name="titlestop1">
                                                                    <div class="invalid-feedback">
                                                                        Ce champ est obligatoire!
                                                                    </div>
                                                                </div>
                                                            </div>
                            
                                                            Adresse
                                                            <div class="form-group row">
                                                                <label for="adress1" class="col-sm-4 offset-md-1 col-form-label">Adresse</label>
                                                                <div class="col-sm-6">
                                                                    <input type="text" class="form-control" id="adress1" name="adress1">
                                                                </div>
                                                            </div>
                            
                                                            Description
                                                            <div class="form-group row">
                                                                <label for="descriptionstop1" class="col-sm-4 offset-md-1 col-form-label">Description</label>
                                                                <div class="col-sm-6">
                                                                    <textarea class="form-control" id="descriptionstop1" rows="4" required name="descriptionstop1"></textarea>
                                                                    <div class="invalid-feedback">
                                                                        Ce champ est obligatoire!
                                                                    </div>
                                                                </div>
                                                            </div>
                            
                                                            Quel jour
                                                            <div class="form-group row">
                                                                <label for="day1" class="col-sm-4 offset-md-1 col-form-label">Quel jour de l'itinéraire avez vous fait cet arrêt?</label>
                                                                <div class="col-sm-6">
                                                                    <input type="number" class="form-control" id="day1" required name="day1" min="1">
                                                                    <div class="invalid-feedback">
                                                                        Ce champ est obligatoire!
                                                                    </div>
                                                                </div>
                                                            </div>
                            
                                                            Horaire
                                                            <div class="form-group row">
                                                                <label for="time1" class="col-sm-4 offset-md-1 col-form-label">À quelle heure vous avez fait cet arrêt?</label>
                                                                <div class="col-sm-6">
                                                                    <input type="time" class="form-control" id="time1" required name="time1">
                                                                    <div class="invalid-feedback">
                                                                        Ce champ est obligatoire!
                                                                    </div>
                                                                </div>
                                                            </div>
                            
                                                            Money
                                                            <div class="form-group row">
                                                                <label for="moneystop1" class="col-sm-4 offset-md-1 col-form-label">Argent dépensé</label>
                                                                <div class="col-sm-6">                                                
                                                                    <select class="form-control" id="moneystop1" name="moneystop1">
                                                                        <option selected>Choisissez...</option>
                                                                        <option value="1">$</option>
                                                                        <option value="2">$-$$</option>
                                                                        <option value="3">$$</option>
                                                                        <option value="4">$$-$$$</option>
                                                                        <option value="5">$$$</option>
                                                                        <option value="6">$$$-$$$$</option>
                                                                        <option value="7">$$$$</option>
                                                                    </select>                                                          
                                                                </div>
                                                            </div>
                            
                                                            Photos de l'arrêt
                                                            <div class="form-group row">
                                                                <label for="photostop1" class="col-sm-4 offset-md-1 col-form-label">Photos de l'arrêt</label>
                                                                <div class="col-sm-4 offset-md-1 custom-file">
                                                                    <input type="file" class="custom-file-input" id="photostop1" multiple required name="photostop1[]">
                                                                    <label class="custom-file-label" for="photostop1">Choisissez les fichiers</label>
                                                                </div>
                                                                <div class="container row">
                                                                    <div class="col-7 offset-5">
                                                                        <small id="photostop1HelpBlock" class="form-text text-muted" style="text-align: center">
                                                                            Sélectionnez au moins 1 fichier et un maximum de 3 fichiers. Les fichiers doivent être du type JPG.
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                            
                                                        </div>
                                                    </div>
                                                </div>-->

                        </div>
                        <!--Bouton d'ajout d'un arrêt-->
                        <div class="form-group row" style="margin-top: 1.5rem">
                            <button type="button" id="createstop" class="col-md-2 offset-md-5 btn btn-success">+ Ajouter un arrêt</button>
                        </div>

                        <!--Bouton de submission-->
                        <div class="form-group row" style="margin-top: 1.5rem">
                            <input type=submit class="col-md-6 offset-md-3 btn btn-info" value="Créer publication" style="margin-top: 1rem">
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <?php
    }
}