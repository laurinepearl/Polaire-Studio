<?php

	function getPDO() {
		$host = 'localhost';
		$db   = 'projet_ferreira';
		$user = 'root';
		$pass = 'root';
		$charset = 'utf8';


		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
		try {
			return new PDO($dsn, $user, $pass, $options);
		} catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(), (int)$e->getCode());
		}
	}

	function verifInfo($info, $length)
	{
		// On rend affichable les caractères HTML.
		$info = htmlentities($info);

		// On supprime les espaces blanc dans la chaîne.
		$info = trim($info);

		// On vérifie la taille de la chaîne de caractères et
		//  on vérifie si la chaîne contient uniquement des
		//  caractères alphabétiques.
		if (strlen($info) >= $length && ctype_print($info))
		{
			return true;
		}

		return false;
	}

	function addFormMessage($pdo, $nom, $prenom, $tel, $email, $message)
	{
		// On écrit la requête SQL sans ses paramètres.
		// "NULL" représente la date actuelle.
		$query = $pdo-> prepare ("INSERT INTO `formulaire_contact` (`nom`,`prenom`,`telephone`,`email`, `message`) VALUES (?, ?, ?, ?, ?)");

		// On exécute la requête.
		$query->execute([$nom, $prenom, $tel, $email, $message]);
	}

	class User
	{
		public function addUser($pdo, $email, $password, $prenom)
		{
			// On "chiffre" le mot de passe.
			$password = password_hash($password, PASSWORD_DEFAULT);

			$query = $pdo->prepare("INSERT INTO `connexion` (`email`, `mot_de_passe` , `prenom`) VALUES (?, ?, ?)");
			$query->execute([$email, $password, $prenom]);
		}

		public function loginUser($pdo, $email)
		{
			$query = $pdo->prepare("SELECT * FROM `connexion` WHERE `email` = ?");
			$query->execute([$email]);
			$result = $query->fetch();

			$_SESSION["identification"]["id_utilisateur"] = $result['id_utilisateur'];
			$_SESSION["identification"]["prenom"] = $result['prenom'];
			$_SESSION["identification"]["email"] = $result['email'];
			$_SESSION["identification"]["role"] = $result['role'];
		}

		public function updateUser($pdo, $email, $password)
		{
			$password = password_hash($password, PASSWORD_DEFAULT);

			$query = $pdo->prepare("UPDATE `connexion` SET `mot_de_passe` = ? WHERE `email` = ?;");
			$query->execute([$password, $email]);
		}

		public function emailExists($pdo, $email)
		{
			$query = $pdo->prepare("SELECT `email` FROM `connexion` WHERE `email` = ?");
			$query->execute([$email]);

			$result = $query->fetch();

			if (is_array($result) && count($result) > 0)
			{
				return true;
			}

			return false;
		}

		public function passwordExists($pdo, $email, $password)
		{
			$query = $pdo->prepare("SELECT * FROM `connexion` WHERE `email` = ?");
			$query->execute([$email]);

			$result = $query->fetch();

			if (is_array($result) && count($result) > 0 && password_verify($password, $result["mot_de_passe"]))
			{
				return true;
			}

			return false;
		}
	}

	function menu ($pdo, $lang, $id)
	{
		$resultat = $pdo->query("SELECT $lang FROM `menu` WHERE id_menu =$id");
		$resultat = $resultat->fetch();

		return $resultat;
	}

	function checkLogin($pdo, $login)
{
    $resultat = $pdo->query ("SELECT * FROM `connexion_bo` WHERE `id_login`= '$login'");
    $resultat = $resultat->fetch();

    return $resultat;
}

//inserer commentaire
function userComment($pdo, $mois, $annee, $etoile ,$commentaire, $id)
	{
		$query = $pdo->prepare("INSERT INTO `commentaire` (`mois`, `annee` , `note`, `commentaire`, `id_utilisateur`) VALUES (?, ?, ?, ?, ?)");
		$query->execute([ $mois, $annee, $etoile, $commentaire, $id]);
	}

	//inserer messages
function userMessage($pdo, $message, $id, $cible)
{
	$query = $pdo->prepare("INSERT INTO `messagerie` (`message` , `id_utilisateur`, `id_cible`) VALUES (?, ?, ?)");
	$query->execute([$message, $id, $cible]);
}

	//insérer le profil tatoueur
	function userProfil($pdo, $name, $color, $font, $style, $reseau1, $reseau2, $background, $button, $id)
	{
		$query = $pdo->prepare("INSERT INTO `profil_tatoueur` (`prenom`, `couleur`, `font`,  `style`, `reseau1`, `reseau2`, `background_color`, `button_color`, `id_utilisateur` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$query->execute([ $name, $color, $font, $style, $reseau1, $reseau2, $background, $button, $id]);
	}
?>