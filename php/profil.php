<?php

    ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

    include("pdo.inc.php");

    session_start();

    $pdo = getPDO();
    $background = $_POST["background"];
    $name = $_POST["prenom"];
	$color = $_POST["text_color"];
	$font = $_POST["font"];
    $style = $_POST["style"];
    $button = $_POST ["button_color"];
    $reseau1 = $_POST["reseau1"];
	$reseau2 = $_POST["reseau2"];
    $submit = $_POST["submit"];
    $id =  $_SESSION["identification"]["id_utilisateur"];

    if (!empty($name) && !empty($color) && !empty($font) && !empty($style) && !empty($reseau1) && !empty($reseau2) && !empty($background) && !empty($button));
    {
        // Nouveau profil
        userProfil($pdo, $name, $color, $font, $style, $reseau1, $reseau2, $background, $button, $id);

        // Avatar
        $profil_id = $pdo->lastInsertId();
        $info = pathinfo($_FILES['userfile1']['name']);

        move_uploaded_file($_FILES['userfile1']['tmp_name'], 'upload/' . $profil_id."." . $info['extension']);

        // Réalisations
        $fichiers = $_FILES["realisations"];

        mkdir("upload/" . $pdo->lastInsertId());

        for ($i = 0; $i < count($fichiers["name"]); $i++)
        {
            $info = pathinfo($fichiers['name'][$i]);

            move_uploaded_file($fichiers['tmp_name'][$i], 'upload/' . $pdo->lastInsertId()."/$i." . $info['extension']);
        }

    // On redirige vers la page d'accueil sans le message de
    //  confirmation (erreur ?).
        header("Location: ../profil_tatoueur.php?message=1");
        exit();
    }


    header("Location: ../profil_tatoueur.php?erreur=1");
    exit();
?>