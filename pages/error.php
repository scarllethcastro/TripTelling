<?php
if ($authorized){
echo '<h2> Cette page n\'existe pas. </h2>';
}
else{
    generateHTMLHeader('Erreur', "css/perso.css");
    ?>
    <div class = 'container'>
    <div class="jumbotron">
            <h1>TripTelling</h1>
            <p class="lead">Racontez votre voyage!</p>
        </div>
    <h2> Cette page n'existe pas. </h2>
     <div id="footer">
            <p>Site réalisé en Modal par SC</p>
     </div>
    </div>
 <?php     
    generateHTMLFooter();
}
    

