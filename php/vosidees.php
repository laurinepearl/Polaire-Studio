<?php

    ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

    include("pdo.inc.php");

    session_start();

    $pdo = getPDO();
    $id =  $_SESSION["identification"]["id_utilisateur"];
    $origine =  $_POST["origine"] . "?message=3";

    mkdir("upload/idees/");
    mkdir("upload/idees/$id/");

    if (!empty($_POST["image"])) {

        // enregistrer
        $image = $_POST["image"];
        $origine .= "&id=" . $_POST["id_tatoueur"];
    
        $info = pathinfo($image);
        copy($image, "upload/idees/$id/" . rand() . "." . $info["extension"]);
    } else {

        // télécharger
        $fichiers = $_FILES["realisations"];

        for ($i = 0; $i < count($fichiers["name"]); $i++)
        {
            $info = pathinfo($fichiers['name'][$i]);

            move_uploaded_file($fichiers['tmp_name'][$i], "upload/idees/$id/" . rand() . "." . $info['extension']);
        }
    }

    header("Location: $origine");
    exit();
    ?>