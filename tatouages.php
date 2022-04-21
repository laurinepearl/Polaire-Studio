<!DOCTYPE html>

<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	session_start();

	include("php/requete_index.php");

	$pdo = getPDO();

	function profil ($pdo)
	{
		$resultat = $pdo->query("SELECT * FROM `profil_tatoueur`");
		$resultat = $resultat->fetchAll();

		return $resultat;
	}

	function findAvatar($id)
	{
		$files = scandir("php/upload/");

		foreach ($files as $file)
		{
			if (strpos($file, "$id.") !== false)
			{
				return "php/upload/$file";
			}
		}

		return "";
	}

	$profils = profil($pdo);

	$html4 = "";
	foreach($profils as $profil)
	{
		$html4.='<article style="background-color: ' .$profil["background_color"].'">
		<img src="' . findAvatar($profil ["id_profil"]) . '" alt="">

		<h2 style="color: ' .$profil["couleur"].'; font-family: ' .$profil["font"].'">'.$profil ["prenom"].'</h2>
		<h3>'.$profil ["style"].' </h3>

		<a class="button" href="realisations.php?id=' . $profil ["id_profil"] . '" style="background-color: ' .$profil["button_color"].'"><span> Réalisations</span></a>

		<br />

		<a class="media" href="'.$profil ["reseau1"].'">
			<i class="fa-brands fa-instagram"> </i>
		</a>

		<a class="media" href="'.$profil ["reseau2"].' ">
			<i class="fa-brands fa-facebook"> </i>
		</a>
	</article>';

	}
?>

<html lang="fr">
	<head>
		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="scss/tatouage/tatouage.css" />
		<link rel="stylesheet" href="scss/reset.css">

		<script src="https://kit.fontawesome.com/b2ac465a5f.js" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>

		<script src="js/script.js" defer></script>

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
			<h1> <?php echo $tattoo [$lang]; ?></h1>
			<h2 class="team"> <?php echo $equipe [$lang]; ?></h2>

			<?php
					echo($html4);
			?>




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