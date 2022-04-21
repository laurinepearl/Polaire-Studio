<!DOCTYPE html>
<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	session_start();

	include("php/requete_index.php");

	$pdo = getPDO();
	$id = $_GET["id"];
	$html = "";

	if (file_exists("php/upload/$id/"))
	{
		$photos = scandir("php/upload/$id/");

		foreach ($photos as $photo)
		{
			if ($photo == ".." or $photo == ".")
				continue;

			$html .= "<div><img class='myImg' src='php/upload/$id/" . $photo . "' alt=''></img></div>";
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
			?>
		</section>


		<section id="galerie">
			<div class="parent">
				<?php echo($html); ?>
			</div>

			<div id="myModal" class="modal">

				<span class="close">&times;</span>

				<img class="modal-content" id="img01">

				<div id="caption"></div>
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