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

        $('#content-new-post').hide();
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

