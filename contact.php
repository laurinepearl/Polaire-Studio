<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	session_start();

	include("php/requete_index.php");
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="scss/contact/contact.css" />
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

		<section class="premiere">
			<h1><?php echo $contact2 [$lang]; ?></h1>

			<article>
				<p><?php echo $contenu6 [$lang]; ?></p>

				<div>
					<p class="adresse">15 Avenue de la République - Nice</p>
					<a href="tel:0699999999">06.99.99.99.99</a>
				</div>
			</article>
		</section>

		<section class="formulaire">

			<img src="images/sapin.jfif" alt="">

			<form class="contact" action="php/contact_action.php" method="POST">
			<?php
				if (isset($_GET["message"]))
				{
					echo("<div class='snackbar'>Votre message a été envoyé avec succès.</div>\n");
				}

				if (isset($_GET["erreur"]))
				{
					echo($_SESSION["erreur"]);
				}
			?>
				<input class="contaact" type="text" name="nom"  placeholder="Nom" required>
				<input class="contaact" type="text" name="prenom"  placeholder="Prénom" required>
				<input class="contaact" type="email" name="email"  placeholder="Email" required>
				<input class="contaact" type="tel" name="tel"  placeholder="n° téléphone" required>

				<textarea name="message" placeholder= "Votre Message" required></textarea>

				<button type="submit"> Envoyer </button>
			</form>
		</section>

		<section class="troisieme">
			<article class="social">
				<a class="btn" href="https://www.instagram.com/laurinepearl_/">
					<i class="fa-brands fa-instagram"></i>
				</a>

				<a class="btn" href="https://www.pinterest.fr/laurineferreira29/_saved/">
					<i class="fa-brands fa-pinterest"></i>
				</a>

				<a class="btn" href="https://www.facebook.com/laurine.ferreira.543">
					<i class="fa-brands fa-facebook"></i>
				</a>
			</article>
		</section>

		<?php
				include("messagerie.php");

		?>

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