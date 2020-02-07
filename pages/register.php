<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form action="index.php?page=register&todo=..." method=post
                  oninput="up2.setCustomValidity(up2.value != up.value ? 'Les mots de passe diffèrent.' : '')">              
<!--                <p>
                    <label for="login">Login:</label>
                    <input id="login" type=text required name=login>
                </p>-->
                <div class="form-group row">
                    <label for="username" class="col-sm-4 offset-md-1 col-form-label">Nom d'utilisateur</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="username" required name="username">
                        <small id="usernameHelpBlock" class="form-text text-muted">
                            Le nom d'utilisateur sert à vous identifier dans notre communauté, et sera affiché sur votre page de profil. Il ne doit pas contenir d'espace.
                        </small>
                    </div>
                </div>

<!--                <p>
                    <label for="nom">Nom</label>
                    <input id="nom" type=text required name=nom>
                </p>-->
                <div class="form-group row">
                    <label for="nom" class="col-sm-4 offset-md-1 col-form-label">Nom</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="nom" required name="nom">
                    </div>
                </div>

<!--                <p>
                    <label for="prenom">Prenom</label>
                    <input id="prenom" type=text required name=prenom>
                </p>-->
                <div class="form-group row">
                    <label for="prenom" class="col-sm-4 offset-md-1 col-form-label">Prenom</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="prenom" required name="prenom">
                        <div class="invalid-feedback">
                            Please provide a valid city.
                        </div>
                    </div>
                </div>

<!--                <p>
                    <label for="naissance">Date de naissance:</label>
                    <input id="naissance" type=date required name=naissance>
                </p>-->
                <div class="form-group row">
                    <label for="naissance" class="col-sm-4 offset-md-1 col-form-label">Date de naissance</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="naissance" required name="naissance">
                    </div>
                </div>

<!--                <p>
                    <label for="email">Email:</label>
                    <input id="email" type=email required name=email>
                </p>-->
                <div class="form-group row">
                    <label for="email" class="col-sm-4 offset-md-1 col-form-label">Email</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" id="email" required name="email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                </div>

<!--                <p>
                    <label for="password1">Password:</label>
                    <input id="password1" type=password required name=up>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                    </small>
                </p>-->
                <div class="form-group row">
                    <label for="password1" class="col-sm-4 offset-md-1 col-form-label">Mot de passe</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" id="password1" required name="up">
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                        </small>
                    </div>
                </div>

<!--                <p>
                    <label for="password2">Confirm password:</label>
                    <input id="password2" type=password name=up2>
                </p>-->
                <div class="form-group row">
                    <label for="password2" class="col-sm-4 offset-md-1 col-form-label">Confirmez votre mot de passe</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" id="password2" name="up2">
                    </div>
                </div>

                <input type=submit value="Create account">
            </form>



        </div>
    </div>
</div>
