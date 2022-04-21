<?php
    if (isset($_GET["message"]) AND $_GET["message"]=="1")
    {
        echo("<div class='snackbar'>Vous êtes bien connecté.</div>\n");
    }

    if (isset($_GET["erreur"]))
    {
        if ($_GET["erreur"] == "1")
        {
            // Erreur pour la connexion.
            echo("<div class='snackbar'>Les identifiants renseignés n'existent pas.</div>");
        }
        elseif ($_GET["erreur"] == "2")
        {
            // Erreur pour l'inscription.
            echo("<div class='snackbar'>L'adresse email est déjà utilisée. Veuillez en choisir une autre.</div>");
        }
    }

    if (isset($_GET["message"])AND $_GET["message"]=="2")
				{
					echo("<div class='snackbar'>Vous êtes déconnecté.</div>\n");
				}
?>

<div class="formContainer">
    <div class="form-wrapper">
        <div class="card">
            <button class="btn" id="hideform">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="card-header">
                <div id="forLogin" class="form-header">Se connecter</div>
                <div id="forRegister" class="form-header">S'inscrire</div>
            </div>

            <div class="card-body" id="formContainer">
                <form id="loginForm" action="php/connexion.php" method="POST" novalidate>
                    <!-- Adresse électronique -->
                    <input type="email" name="Email" class="champs" id="login_email" placeholder="email" autocomplete="off" />

                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>

                    <small>Error message</small>

                    <!-- Mot de passe -->
                    <input type="password" name="password" class="champs" id="login_password" placeholder="mot de passe" autocomplete="off" />
                    <i class="fa-solid fa-eye-slash eye"></i>

                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    <small>Error message</small>

                    <!-- Oubli du mot de passe -->
                    <a href="#" id="mdpforget" class="link">Mot de passe oublié ?</a> <br>

                    <button class="formButton"> Connexion</button>
                </form>

                <form id="registerForm" class="toggleform" action="php/inscription.php" method="POST" novalidate>
                    <!-- Adresse électronique -->
                    <div class="form-control">
                        <input type="email" name="Email" class="champs" id="register_email" placeholder="email" />

                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>

                        <small>Error message</small>
                    </div>

                    <div class="form-control">
                        <input type="texte" name="prenom" class="champs" id="register_prenom" placeholder="prénom" />

                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>

                    </div>

                    <!-- Mot de passe (première étape) -->
                    <div class="form-control">
                        <input type="password" name="password" class="champs" id="register_password" placeholder="mot de passe" />
                        <i class="fa-solid fa-eye-slash eye"></i>

                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>

                    <br />

                    <!-- Mot de passe (confirmation) -->
                    <div class="form-control">
                        <input type="password" name="password2" class="champs"  id="register_confirmation" placeholder="Confirmer Mot de passe" autocomplete="off"/>
                        <i class="fa-solid fa-eye-slash eye"></i>

                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>

                    <div>
                        <input type="checkbox" id="conditions" name="conditions" value="">
                        <label for="" id="conditions1">J'ai lu et accepté les <a href="php/conditions_generales.php">conditions générales d'utilisation</a> </label>
                        <i class="fas fa-check-circle"></i>
                        <i class="fas fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>

                    <br />

                    <button class="formButton">Inscription</button>
                </form>
            </div>
        </div>
    </div>
</div>