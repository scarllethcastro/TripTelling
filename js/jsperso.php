<!--Partie JavaScript-->

<!--Pour la vérification côté client des formulaires-->
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

<!-- Pour la page de profil-->
<script>
    $(function () {

        $('#content-settings').hide();

        $('.button-page').on('click', function () {
            //Discover which button was clicked
            var $buttonId = $(this).attr('id');
            //Discover which is the current content
            var $activeId = $(this).closest('.list-group').find('.active').attr('id');
            //Fade out current content
            $('#content-' + $activeId).hide(function () {
                //Make current content inactive
                $(this).removeClass('active');
                //Show the corresponding content
                $('#content-' + $buttonId).show(function () {
                    //Make corresponding content active
                    $(this).addClass('active');
                });
            });

        });
    });
</script>

<!--Pour créer les arrêts dans la page newpost-->
<script>
    $(function () {
    //Variable pour conter les arrêts
    var ns = 1; // Nombre de arrêts
    var $divstops = $('#divstops');
    var newstop = ""; //Bouton créer arrêt
    
    //Géneration de la première arrêt
    generateString(1);
    $divstops.append(newstop);
    
    $('#createstop').on('click', function(){
        ns++;
        generateString(ns);
        $divstops.append(newstop);
    });
    
    $('#divstops').delegate('.remove', 'click', function(){
        var idstop = $(this).attr('data-stop');
        $('#'+idstop).remove();
    });
    
    //Função que gera a string newstop
    function generateString(n){
        newstop = "<div id='stop" + n + "'class ='shadow-none p-3 mb-5 bg-light  rounded' style='margin-bottom: 2rem!important'" + ">" +
                                    "<div class='shadow-sm p-3 mb-5 bg-white rounded'" + ">" + "<h6 class='text-muted' style ='text-align: center'" + ">" +
                            "ARRÊT " + n + "" +
                    "</h6>" +
            "</div>" +
            "<!--Formulaire d'une arrêt -->" +
                            "<div class='row'" + ">" + "<div class ='col-md-10 offset-md-1'" + ">" +
                            "<!--Titre-->" +
                            "<div class='form-group row'" + ">" +
                            "<label for='titlestop" + n + "' class='col-sm-4 offset-md-1 col-form-label'" + ">Titre</label>" +
                            "<div class='col-sm-6'" + ">" +
                    "<input type='text' class='form-control' id='titlestop" + n + "' required name='titlestop" + n + "'" + ">" +                                                                              "<div class='invalid-feedback'" + ">" +
                    "Ce champ est obligatoire!" +
                    "</div>" +
                    "</div>" +
                    "</div>"+

    "<!--Adresse-->"+
    "<div class='form-group row'"+">"+
        "<label for='adress" + n + "' class='col-sm-4 offset-md-1 col-form-label'"+">Adresse</label>"+
        "<div class='col-sm-6'"+">"+
            "<input type='text' class='form-control' id='adress" + n + "' name='adress" + n + "'"+">"+
        "</div>"+
    "</div>"+

    "<!--Description-->"+
    "<div class='form-group row'"+">"+
        "<label for='descriptionstop" + n + "' class='col-sm-4 offset-md-1 col-form-label'"+">Description</label>"+
        "<div class='col-sm-6'"+">"+
            "<textarea class='form-control' id='descriptionstop" + n + "' rows='4' required name='descriptionstop" + n + "'"+"></textarea>"+
            "<div class='invalid-feedback'"+">"+
                "Ce champ est obligatoire!"+
            "</div>"+
        "</div>"+
    "</div>"+

    "<!--Quel jour-->"+
    "<div class='form-group row'"+">"+
        "<label for='day" + n + "' class='col-sm-4 offset-md-1 col-form-label'"+">Quel jour de l'itinéraire avez vous fait cet arrêt?</label>"+
        "<div class='col-sm-6'"+">"+
            "<input type='number' class='form-control' id='day" + n + "' required name='day" + n + "' min='1'"+">"+
            "<div class='invalid-feedback'"+">"+
                "Ce champ est obligatoire!"+
            "</div>"+
        "</div>"+
    "</div>"+

    "<!--Horaire-->"+
    "<div class='form-group row'"+">"+
        "<label for='time" + n + "' class='col-sm-4 offset-md-1 col-form-label'"+">À quelle heure vous avez fait cet arrêt?</label>"+
        "<div class='col-sm-6'"+">"+
            "<input type='time' class='form-control' id='time" + n + "' required name='time" + n + "'"+">"+
            "<div class='invalid-feedback'"+">"+
                "Ce champ est obligatoire!"+
            "</div>"+
        "</div>"+
    "</div>"+

    "<!--Money-->"+
    "<div class='form-group row'"+">"+
        "<label for='moneystop" + n + "' class='col-sm-4 offset-md-1 col-form-label'"+">Argent dépensé</label>"+
        "<div class='col-sm-6'"+">"+                                                
            "<select class='form-control' id='moneystop" + n + "' name='moneystop" + n + "'"+">"+
                "<option selected>Choisissez...</option>"+
                "<option value='1'"+">$</option>"+
                "<option value='2'"+">$-$$</option>"+
                "<option value='3'"+">$$</option>"+
                "<option value='4'"+">$$-$$$</option>"+
                "<option value='5'"+">$$$</option>"+
                "<option value='6'"+">$$$-$$$$</option>"+
                "<option value='7'"+">$$$$</option>"+
            "</select>"+                                                         
        "</div>"+
    "</div>"+

    "<!--Photos de l'arrêt-->"+
    "<div class='form-group row'"+">"+
        "<label for='photostop" + n + "' class='col-sm-4 offset-md-1 col-form-label'"+">Photos de l'arrêt</label>"+
        "<div class='col-sm-4 offset-md-1 custom-file'"+">"+
            "<input type='file' class='custom-file-input' id='photostop" + n + "' multiple required name='photostop" + n + "[]'"+">"+
            "<label class='custom-file-label' for='photostop" + n + "'"+">Choisissez les fichiers</label>"+
        "</div>"+
        "<div class='container row'"+">"+
            "<div class='col-7 offset-5'"+">"+
                "<small id='photostop" + n + "HelpBlock' class='form-text text-muted' style='text-align: center'"+">"+
                    "Sélectionnez au moins 1 fichier et un maximum de 3 fichiers. Les fichiers doivent être du type JPG."+
                "</small>"+
            "</div>"+
        "</div>"+
    "</div>"+

    "<!--Bouton de suppression de l'arrêt-->"+
    "<div class='form-group row' style='margin-top: 1.5rem'"+">"+
        "<button type=submit class='col-md-4 offset-md-4 btn btn-secondary remove' data-stop='stop" + n + "'"+">Supprimer cet arrêt</button>"+
    "</div>"+
"</div>"+
"</div>"+
"</div>";
}
        
});
</script>

