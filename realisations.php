<!DOCTYPE html>
<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	session_start();

	include("php/requete_index.php");

	$pdo = getPDO();
	$id = $_GET["id"];
	$nombre = 1;
	$galerie = "";
	$slides = "";

	if (file_exists("php/upload/$id/realisations/"))
	{
		$photos = scandir("php/upload/$id/realisations/");
		$photos = array_diff($photos, array('..', '.', ".DS_Store"));

		foreach ($photos as $photo)
		{
			$galerie .= "<div class='column'><img src='php/upload/$id/realisations/" . $photo . "' onclick='openModal(); currentSlide($nombre);' class='hover-shadow' alt=''></img></div>";
			$slides .= "<div class='mySlides'>
				<div class='favorite'>
					<form action='php/vosidees.php' method='POST'>
						<button class='enregister' data-login='" . (isset($_SESSION["identification"]) ? "false" : "true") . "' onClick='closeModal();' type='submit' name='submit'>Enregistrer </button>
						<input type='hidden' name='image' value='upload/$id/realisations/" . $photo . "' />
						<input type='hidden' name='id_tatoueur' value='$id' />
						<input type='hidden' name='origine' value='" . $_SERVER['PHP_SELF'] . "' />
					</form>
				</div>
				<div class='numbertext'>$nombre / " . count($photos) . "</div>
					<img src='php/upload/$id/realisations/" . $photo . "'>
				</div>";

			$nombre++;
		}
	}
?>
<html lang="fr">
	<head>
		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="scss/realisations/realisations.css" />
		<link rel="stylesheet" href="scss/reset.css">

		<script src="https://kit.fontawesome.com/b2ac465a5f.js" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>

		<script src="js/script.js" defer></script>
		<script src="js/realisations.js" defer></script>

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

				if (isset($_GET["message"]) AND $_GET["message"]=="3")
				{
					echo("<div class='snackbar'>L'image a bien été enregistrée.</div>\n");
				}
			?>
		</section>

		<section id="galerie">
			<article class="row">
				<?php echo($galerie); ?>
			</article>

			<div id="myModal" class="modal">

				<span class="close cursor" onclick="closeModal()">&times;</span>

				<div class="modal-content">
					<?php echo($slides); ?>

					<!-- fleches -->
					<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
					<a class="next" onclick="plusSlides(1)">&#10095;</a>
				</div>
			</div>
		</section>

	<a id="remonter" href="#">
		<i class="fas fa-chevron-up"></i>
	</a>

	<footer>
		<?php
			include("footer.php");
		?>
	</footer>

	</body>
</html>