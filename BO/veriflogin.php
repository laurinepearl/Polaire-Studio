
<?php
    /* login = login, mdp = mdp */

	include("../php/pdo.inc.php");

	// 1- On récupère le login et le mot de passe du formulaire !

	$login = "";
	$mdp = "";
	if(isset($_POST['validelogin'])) {
		if(isset($_POST['login']))
			$login = $_POST['login'];
		if(isset($_POST['mdp']))
			$mdp = $_POST['mdp'];
	}
	if(isset($_POST['Deco'])){
		unset($_SESSION['login']);
	}
	else {
	    if(isset($_SESSION['login']))
		  $checklogin = $_SESSION['login'];
	    else
		  $checklogin = false;




        // A peaufiner sur le plan sécurité ... ca pique un peu!


		// 1- On récupère le login et le mot de passe du formulaire !

		// 2- On vérifie les informations du formulaire (par exemple si ce n'est pas une chaîne vide) !
		function verifchaine($info, $length)
		{
			// On rend affichable les caractères HTML.
			$info = htmlentities($info);

			// On supprime les espaces blanc dans la chaîne.
			$info = trim($info);

			// On vérifie la taille de la chaîne de caractères et
			//  on vérifie si la chaîne contient uniquement des
			//  caractères alphabétiques.
			if (strlen($info) > $length && ctype_print($info))
			{
			  return true;
			}

			  return false;
			}

			if(isset($_POST['validelogin']))
			{
				if (!verifchaine($login, 3))
				{
				echo "Votre identifiant est invalide !";
				}


				// 3- On fait une requête à la base de données avec le login fournis.
				$pdo = getPDO();
				$info = checklogin($pdo,$login);

				if ($info)
				{
					//	SI RESULTAT : alors on compare le mot de passe.
					if (password_verify( $mdp , $info['mdp'])) {
						//	SI VALIDE : on redirige l'utilisateur.

						$checklogin=true;
						$_SESSION['login'] = true;
					} else {
						// SINON : message d'erreur
						echo 'Le mot de passe est invalide.';
					}
				}
				else
					// 	SINON : on met un message d'erreur.
					echo " ou vous n'avez pas de compte";
			};

        if(!$checklogin) {
?>
<section id="connexion">
	<img src="../images/blob_orange_devant.svg" class="blob_orange_devant" >
	 <img src="../images/blob_orange_derriere.svg" class="blob_orange_derriere" >
	 <img src="../images/blob_bleu_devant.svg" class="blob_bleu_devant" >
	 <img src="../images/blob_bleu_derriere.svg" class="blob_bleu_derriere" >

	<legend>Connexion</legend>
	<form method='post' action="choixtable.php">
		identifiant  : <input type="text" name='login'/>
		mot de passe : <input type="password" name='mdp'/>
		<input type='submit' name='validelogin' value='Valider'>
	</form>
</section>
</body>
</html>
<?php
	exit(0);
	}}
?>
