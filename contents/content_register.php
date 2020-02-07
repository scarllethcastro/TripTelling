
<form action="index.php?page=register&todo=..." method=post
      oninput="up2.setCustomValidity(up2.value != up.value ? 'Les mots de passe diffèrent.' : '')">
    <p>
        <label for="login">Login:</label>
        <input id="login" type=text required name=login>
    </p>
    <p>
        <label for="nom">Nom:</label>
        <input id="nom" type=text required name=nom>
    </p>
    <p>
        <label for="prenom">Prenom:</label>
        <input id="prenom" type=text required name=prenom>
    </p>
    <p>
        <label for="promotion">Promotion:</label>
        <input id="promotion" type=number name=promotion>
    </p>
    <p>
        <label for="naissance">Date de naissance:</label>
        <input id="naissance" type=date required name=naissance>
    </p>
    <p>
        <label for="email">Email:</label>
        <input id="email" type=email required name=email>
    </p>
    <p>
        <label for="password1">Password:</label>
        <input id="password1" type=password required name=up>
    </p>
    <p>
        <label for="password2">Confirm password:</label>
        <input id="password2" type=password name=up2>
    </p>
    <input type=submit value="Create account">
</form>
