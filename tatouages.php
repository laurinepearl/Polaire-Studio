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
		$files = scandir("php/upload/$id/");

		foreach ($files as $file)
		{
			if (strpos($file, "profil") !== false)
			{
				return "php/upload/$id/$file";
			}
		}

		return "";
	}

	$profils = profil($pdo);
	$html4 = "";
	foreach($profils as $profil)
	{
		$html4.='<article id="carte" data-style="' .$profil["style"]. '" data-couleur="' .$profil["style_couleur"]. '" data-taille="' .$profil["style_taille"]. '" style="background-color: ' .$profil["background_color"].'; border-radius:' .($profil["border"] == "ron" ? '30px' : 'none').'">
		<img src="' . findAvatar($profil ["id_profil"]) . '" alt="">

		<h2 style="color: ' .$profil["couleur"].'; font-family: ' .$profil["font"].'">'.$profil ["prenom"].'</h2>
		<h3>'.$profil ["style"].' </h3>

		<a class="button" href="realisations.php?id=' . $profil ["id_profil"] . '" style="background-color: ' .$profil["button_color"].'"><span> Réalisations</span></a>

		<br />

		<a class="media" href="'.$profil ["reseau1"].'" target="_blank">
			<i class="fa-brands fa-instagram"> </i>
		</a>

		<a class="media" href="'.$profil ["reseau2"].' " target="_blank">
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
		<script src="js/filter.js" defer ></script>

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

			<button type="button" id="button-filter" onclick="myFunction()"> <img src="images/filter.png" id="img-filter" height ="23" width="26" /></button>
		 
		<article class="filter">
					
		<div id="myBtnContainer">
			<button class="btn active" onclick="filterSelection('all')"> Tout afficher</button>
			<button class="btn" onclick="filterSelection('style')"> Style</button>
			<button class="btn" onclick="filterSelection('color')"> Couleurs</button>
			<button class="btn" onclick="filterSelection('taille')"> Taille</button>
			<!-- <button class="btn" onclick="filterSelection('colors')"> Colors</button> -->
		</div>

		<div class="container">
			<div class="filterDiv style">
				<input type="checkbox" value="Japonais"> <label for="">Japonais</label>
			</div>
			<div class="filterDiv style">
				<input type="checkbox" value="Animé"> <label for="">Animé</label>
			</div>
			<div class="filterDiv style">
				<input type="checkbox" value="OldSchool"><label for="">Old School</label>
			</div>
			<div class="filterDiv color">
				<input type="checkbox" value="Couleurs"> <label for="">Couleurs</label>
			</div>
			<div class="filterDiv color">
				<input type="checkbox" value="NoirEtBlanc"> <label for="">Noir et Blanc</label>
			</div>
			<div class="filterDiv taille">
				<input type="checkbox" value="Petit"> <label for="">Petit (10 - 20cm)</label>
			</div>
			<div class="filterDiv taille">
				<input type="checkbox" value="Moyen"> <label for="">Moyen (20 - 30cm)</label>
			</div>
			<div class="filterDiv taille">
				<input type="checkbox" value="Grand"> <label for="">Grand (30 - 40cm)</label>
			</div>
			<div class="filterDiv taille">
				<input type="checkbox" value="Plus"> <label for="">Plus (40cm - et plus)</label>
			</div>
		</div>

		<button type="submit" name="submit" class="result">VOIR RÉSULTATS</button>

		<h3 class="pasresultat" style="display: none">Aucun résultat</h3>
	</article>

			<?php
					echo($html4);
			?>

		</section>

		<section class="troisieme">
			<article class="social">
				<a class="btn" href="https://www.instagram.com/laurinepearl_/" target="_blank">
					<i class="fa-brands fa-instagram"></i>
				</a>

				<a class="btn" href="https://www.pinterest.fr/laurineferreira29/_saved/" target="_blank">
					<i class="fa-brands fa-pinterest"></i>
				</a>

				<a class="btn" href="https://www.facebook.com/laurine.ferreira.543" target="_blank">
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