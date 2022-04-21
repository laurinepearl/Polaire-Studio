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

		<link rel="stylesheet" type="text/css" href="scss/rdv/rendezvous.css" />
		<link rel="stylesheet" href="scss/reset.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"/>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"/>

		<script src="https://kit.fontawesome.com/b2ac465a5f.js" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>

		<script src="js/script.js" defer></script>
		<script src="js/rdv.js" defer></script>

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
			<h1> <?php echo $rdv [$lang]; ?></h1>

			<p>
				<?php echo $contenu3 [$lang]; ?>
			</p>
		</section>

		<!-- Calendrier -->
		<section class="deuxieme">
			<iframe src="https://koalendar.com/e/polaire-studio" width="100%" height="800px" name="iframe1" id="iframe1"></iframe>

			<!-- <div class="container">
			<div class="calendar">
			<div class="month">
			<i class="fas fa-angle-left prev"></i>
			<div class="date">
			<h1></h1>
			<p></p>
			</div>
			<i class="fas fa-angle-right next"></i>
			</div>
			<div class="weekdays">
			<div>Lun</div>
			<div>Mar</div>
			<div>Mer</div>
			<div>Jeu</div>
			<div>Ven</div>
			<div>Sam</div>
			<div>Dim</div>
			</div>
			<div class="days"></div>
			</div>
			</div> -->
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