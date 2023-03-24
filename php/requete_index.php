<?php
	include_once("pdo.inc.php");

	if (!isset( $_GET["lang"])) {
		$_GET["lang"] = 'FR';
	}
	$lang = $_GET["lang"];

	$pdo=getPDO();

	// MENU
	$aboutus = menu ($pdo, $lang, 1);
	$tattoo = menu ($pdo, $lang, 2);
	$rdv = menu ($pdo, $lang, 3);
	$contact = menu ($pdo, $lang, 4);
	$titre = menu ($pdo, $lang, 5);
	$soustitre = menu ($pdo, $lang, 6);
	$contenu1 = menu ($pdo, $lang, 7);
	$contenu2 = menu ($pdo, $lang, 8);
	$savoir = menu ($pdo, $lang, 9);
	$decouvrir = menu ($pdo, $lang, 10);
	$home = menu ($pdo, $lang, 11);
	$contenu3 = menu ($pdo, $lang, 12);
	$approche = menu ($pdo, $lang, 13);
	$contenu4 = menu ($pdo, $lang, 14);
	$reflexion = menu ($pdo, $lang, 15);
	$contenu5 = menu ($pdo, $lang, 16);
	$salon = menu ($pdo, $lang, 17);
	$contact2 = menu ($pdo, $lang, 18);
	$contenu6 = menu ($pdo, $lang, 19);
	$equipe = menu ($pdo, $lang, 20);
?>