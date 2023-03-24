<?php

    ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

    include("pdo.inc.php");

    session_start();

    $pdo = getPDO();
    $etoile = $_POST["etoile"];
    $commentaire = $_POST["commentaire"];
    $mois = $_POST["mois"];
    $annee = $_POST["annee"];
    $id =  $_SESSION["identification"]["id_utilisateur"];



    if ($commentaire && $mois && $annee);
    {
        $info = pathinfo($_FILES['userfile']['name']);

        userComment($pdo, $mois, $annee, $etoile, $commentaire, $id);

        mkdir("upload/commentaires/");

        move_uploaded_file($_FILES['userfile']['tmp_name'], 'upload/commentaires/' . $pdo->lastInsertId()."." . $info['extension']);


    // On redirige vers la page d'accueil sans le message de
    //  confirmation (erreur ?).
        header("Location: ../apropos.php?message=1");
        exit();
    }


    header("Location: ../index.php?erreur=1");
    exit();
?>