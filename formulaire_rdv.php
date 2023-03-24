<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	session_start();

	include("php/requete_index.php");

	if (empty($_POST["date"]) || empty($_POST["heure"])) {
		header("Location: rendezvous.php");
		exit();
	}

	if (isset($_POST["prenom"]) && isset($_POST["nom"]) && isset($_POST["email"]) && isset($_POST["tel"]) && isset($_POST["horaires"])) {
		$pdo = getPDO();
		$id = $_SESSION["identification"]["id_utilisateur"];

		ajoutRendezVous($pdo, $_POST["prenom"], $_POST["nom"], $_POST["email"], $_POST["tel"], $_POST["horaires"], $id, $_POST["id_tatoueur"]);

		header("Location: rendezvous.php?message=1");
		exit();
	}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="scss/rdv/formulaire.css" />
		<link rel="stylesheet" href="scss/reset.css">

		<script src="https://kit.fontawesome.com/b2ac465a5f.js" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>

		<script src="js/script.js" defer></script>
		<script src="js/contact.js" defer></script>

		<title>Polaire Studio</title>
	</head>
	<body>
		<header class="header">
			<?php
				include("header.php");
			?>
		</header>

		<section id="co">
			<?php
				include("connexion.php");
			?>
		</section>

		<section class="formulaire">
            <article>
            <img class="image" src="images/papillon.jpg" alt=""> 
            <div class="form">
			<h1>Formulaire de rendez-vous</h1>
			<form class="contact" method="POST">
			<?php
				if (isset($_GET["erreur"]) && $_GET["erreur"] == "3")
				{
					echo("<div class='snackbar'>" . $_SESSION["erreur"] ."</div>\n");
				}
			?>
				<div> 
					<p>Date : <?php echo($_POST["date"]); ?></p>
					<p>Horaire : <?php echo($_POST["heure"]); ?></p>
				</div>

				<input class="contaact" type="text" name="nom" placeholder="Nom" required>
				<input class="contaact" type="text" name="prenom" placeholder="Prénom" value=<?php echo($_SESSION["identification"]["prenom"]); ?> required>
				<input class="contaact" type="email" name="email" placeholder="Email" value=<?php echo($_SESSION["identification"]["email"]); ?> required>
				<input class="contaact" type="tel" name="tel" placeholder="n° téléphone" required>
				

				<input type="hidden" name="id_tatoueur" value="<?php echo($_POST["id_tatoueur"]); ?>" />
				<input type="hidden" name="horaires" value="<?php echo($_POST["heure"] . " | " . $_POST["date"]); ?>" />
				<input type="hidden" name="date" value="<?php echo($_POST["date"]); ?>" />
				<input type="hidden" name="heure" value="<?php echo($_POST["heure"]); ?>" />

				<button type="submit"> Valider </button>
			</form>
            <div>
            </article>
		</section>


		<a id="remonter" href="#" >
			<i class="fas fa-chevron-up"></i>
		</a>

		<footer>
			<?php
				include("footer.php");
			?>
		</footer>
	</body>
</html>