<?php
// tratamento

$photo_post_fail = false;
$photo_post_error_message = 'lalala';
$photo_stop_fail = false;
$photo_stop_error_message = 'lalala';
?>



<div class="container" style="padding: 20px; background-color: white">
    <!--Titre du formulaire-->
    <div class="shadow-none p-3 mb-5 bg-light rounded">
        <h5 class="text-muted" style="text-align: center">
            NOUVEAU POST
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
                        <input type="text" class="form-control" id="titlepost" required name="titlepost">
                        <div class="invalid-feedback">
                            Ce champ est obligatoire!
                        </div>
                    </div>
                </div>

                <!--Ville-->
                <div class="form-group row">
                    <label for="place" class="col-sm-4 offset-md-1 col-form-label">Ville</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="place" required name="place">
                        <div class="invalid-feedback">
                            Ce champ est obligatoire!
                        </div>
                    </div>
                </div>

                <!--Durée-->
                <div class="form-group row">
                    <label for="duration" class="col-sm-4 offset-md-1 col-form-label">Durée en jours</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" id="tentacles" required name="duration" min="1">
                        <div class="invalid-feedback">
                            Ce champ est obligatoire!
                        </div>
                    </div>
                </div>

                <!--Description-->
                <div class="form-group row">
                    <label for="descriptionpost" class="col-sm-4 offset-md-1 col-form-label">Description</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" id="descriptionpost" rows="4" required name="descriptionpost"></textarea>
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

                <!--Photo de profil-->
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
                            STOPS
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

                                Bouton de suppression de l'arrêt
                                <div class="form-group row" style="margin-top: 1.5rem">
                                    <button type=submit class="col-md-4 offset-md-4 btn btn-secondary remove" data-stop="stop1">Supprimer cet arrêt</button>
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



