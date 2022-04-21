<?php

    ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

    include("pdo.inc.php");

    session_start();

    $pdo = getPDO();
	$message = $_POST["message"];
	$origine = $_POST["origine"];
	$id =  $_SESSION["identification"]["id_utilisateur"];

    if (isset($_POST["cible"]))
    {
        $cible = $_POST["cible"];
    }

	if ($message);
    {
        userMessage($pdo, $message, $id, $cible);



    // On redirige vers la page d'accueil sans le message de
    //  confirmation (erreur ?).
        header("Location: " . $origine . "?success=1");
        exit();
    }

	header("Location: " . $origine . "?erreur=1");
    exit();



?>