<?php
if ($authorized){
echo '<h2> Cette page n\'existe pas. </h2>';
}
else{
    generateHTMLHeader('Erreur', "css/perso.css");
    ?>
    <div class = 'container justify-content-center'>
      <div class ="row" style="margin-top: 7rem">
            <div class="col-md-4 offset-md-4 card text-center" style="width: 30rem; border: 1px solid red;">
                <div class="card-body" >
                    <h5 class="card-title"><span class="glyphicon glyphicon-remove"></span>TripTelling</h5>
                    <p class="card-text"> Erreur! Cette page n'existe pas! Veuillez retourner à la page initiale</p>
                    <a href="index.php?page=welcome" class="btn btn-info">Page initiale</a>
                </div>
            </div>
        </div>
     <div style="text-align:center; margin: 8px" id="footer">
            <p>Site réalisé en Modal par SC</p>
     </div>
    </div>
 <?php     
    generateHTMLFooter();
}
    

