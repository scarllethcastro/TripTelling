<!--Página inútil por enquanto-->
<?php
echo '<h3>Vous êtes connecté(e)!</h3>';
?>
<form action="index.php?todo=upload" method="post" enctype="multipart/form-data">
    <h3>Mettre à jour votre photo de profil:</h3>
    <input type="file" name="fichier"/>
    <input type="submit" value="envoyer" />
</form>
