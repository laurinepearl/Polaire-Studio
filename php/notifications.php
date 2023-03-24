<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	session_start();

	include("requete_index.php");

    $pdo = getPDO();

	function messagesTatoueur ($pdo, $id)
	{
		$resultat = $pdo->query("SELECT * FROM `messagerie`;");
		$resultat = $resultat->fetchAll();

		return $resultat;
	}

	function messagesClient ($pdo, $id)
	{
		$resultat = $pdo->query("SELECT * FROM `messagerie` WHERE `id_utilisateur` = '$id' OR `id_cible` = '$id' ORDER BY `id_message` ASC;");
		$resultat = $resultat->fetchAll();

		return $resultat;
	}

    if (isset($_SESSION["identification"]["id_utilisateur"]))
	{
        $id = $_SESSION["identification"]["id_utilisateur"];

        if ($_SESSION["identification"]["role"] == "tatoueur")
        {
            $messages = messagesTatoueur($pdo, $id);
        }
        else
        {
            $messages = messagesClient($pdo, $id);
        }
        
        echo(json_encode($messages));
    }
?>