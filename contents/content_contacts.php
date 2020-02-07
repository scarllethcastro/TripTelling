
<div id="content">
    <div>
        <h1>Qui sommes-nous?</h1>
        <p>Voilà la page de contacts</p>
    </div>
    <?php
    if (isset($_SESSION['loggedIn'])) {
        echo <<<FIN
        <div>
            <h3>Vous êtes connecté(e)</h3>
        </div>
FIN;
    } else {
        echo <<<FIN
        <div>
            <h3>Vous n'êtes pas connecté(e)</h3>
        </div>
FIN;
    }
    
    // Affichage de formulaires
        if (isset($_SESSION['loggedIn'])) {
            printLogoutForm($askedPage);
        } elseif(isset($_GET['todo']) && $_GET['todo'] == 'login') {
            printLoginForm($askedPage);
            echo '<p style="color:red; font-weight:bold"> Le login ou/et le mot de passe fournis ne sont pas correctes. </p>';
        } else{
            printLoginForm($askedPage);
        }
    ?>
<!--    <div class="row">
        <div class="col-md-3 col-md-offset-2">
            <h3>Olivier Serre</h3>
            <p>Olivier se charge des amphis de la période 4…</p>
        </div>
        <div class="col-md-3 col-md-offset-2">
            <h3>Dominique Rossin</h3>
            <p>Dominique est le gourou historique du modal web…</p>
        </div>
    </div>-->
</div>
