<!DOCTYPE html>

<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	session_start();

	include("php/init_twig.php");
	include("php/requete_index.php");

	function include_get_contents($file)
	{
		// https://stackoverflow.com/a/18190546
		include("php/requete_index.php");

		ob_start();
		include($file);
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	echo $twig->render("index.twig",
	[
		"titre" => $titre [$lang],
		"soustitre" => $soustitre [$lang],
		"aboutus" => $aboutus [$lang],
		"contenu1" => $contenu1 [$lang],
		"savoir" => $savoir [$lang],
		"tatoo" => $tattoo [$lang],
		"contenu2" => $contenu2 [$lang],
		"decouvrir" => $decouvrir [$lang],
		"header" => include_get_contents("header.php"),
		"connexion" => include_get_contents("connexion.php"),
		"messagerie" => include_get_contents("messagerie.php"),
		"footer" => include_get_contents("footer.php")
	]);
?>