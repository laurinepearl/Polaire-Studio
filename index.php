<!DOCTYPE html>

<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	session_start();

	include("php/requete_index.php");



?>

<html lang="fr">
	<head>
		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="scss/index/index.css" />
		<link rel="stylesheet" href="scss/reset.css">

		<script src="https://kit.fontawesome.com/b2ac465a5f.js" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>

		<script src="js/script.js" defer></script>
		<script src="js/index.js" defer></script>

		<title>Polaire Studio</title>
	</head>
	<body onload="demarrer();">
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
			<h2><?php echo $titre [$lang]; ?></h2>

			<h3><?php echo $soustitre [$lang]; ?></h3>

			<img src="images/photo_accueil.png" alt="" />

			<img src="images/photo_accueil2.png" alt="" />

			<img src="images/photo_accueil4.png" alt="" />
		</section>


		<section class="deuxieme">
			<article class="shop">
				<h2><?php echo $aboutus [$lang]; ?></h2>

				<img src="images/tattooshop.jpg">

				<p>
					<?php echo $contenu1 [$lang]; ?>
				</p>

				<a href="apropos.php"> <?php echo $savoir [$lang]; ?></a>
			</article>
			<article class="image">
				<h2 class="tatoo"><?php echo $tattoo [$lang]; ?></h2>

                	<img id="show" src="images/caroussel/rea5.jpg" alt="Paysage" />

				<p>
					<?php echo $contenu2 [$lang]; ?>
				</p>

				<a href="tatouages.php"><?php echo $decouvrir [$lang]; ?></a>
			</article>
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