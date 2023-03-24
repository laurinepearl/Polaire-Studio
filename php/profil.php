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
    $style = implode(",", $_POST["style"]);
    $couleur = implode(",", $_POST["couleur"]);
    $taille = implode(",", $_POST["taille"]);
    $button = $_POST ["button_color"];
    $reseau1 = $_POST["reseau1"];
	$reseau2 = $_POST["reseau2"];
    $border = $_POST ["border"];
    $submit = $_POST["submit"];
    $id =  $_SESSION["identification"]["id_utilisateur"];

	function findAvatar($id)
	{
		$files = scandir("upload/$id/");

		foreach ($files as $file)
		{
			if (strpos($file, "profil.") !== false)
			{
				return "upload/$id/$file";
			}
		}

		return "";
	}

    function getProfilID($pdo, $id_utilisateur)
    {
        $resultat = $pdo->query ("SELECT `id_profil` FROM `profil_tatoueur` WHERE `id_utilisateur`= '$id_utilisateur'");
        $resultat = $resultat->fetch();

        return $resultat["id_profil"];
    }

    if (!empty($_POST["id_utilisateur"]))
    {
        // Mise à profil
        updateProfil($pdo, $name, $color, $font, $style, $couleur, $taille, $reseau1, $reseau2, $background, $button, $border, $id);

        // Suppression
        $profil_id = getProfilID($pdo, $id);

        mkdir("upload/$profil_id/");
        mkdir("upload/$profil_id/realisations/");

        if ($_FILES["userfile1"]["size"] > 0)
        {
            $fichier = findAvatar($profil_id);

            if( file_exists ( $fichier))
                unlink( $fichier ) ;

            // Ajout
            $info = pathinfo($_FILES['userfile1']['name']);

            move_uploaded_file($_FILES['userfile1']['tmp_name'], 'upload/' . $profil_id."/profil." . $info['extension']);
        }

        // Réalisations
        $fichiers = $_FILES["realisations"];

        for ($i = 0; $i < count($fichiers["name"]); $i++)
        {
            $info = pathinfo($fichiers['name'][$i]);

            move_uploaded_file($fichiers['tmp_name'][$i], 'upload/' . $profil_id."/realisations/$i." . $info['extension']);
        }


        header("Location: ../profil_tatoueur.php?message=1");
        exit();

    }
    elseif (!empty($name) && !empty($color) && !empty($font) && !empty($style) && !empty($couleur) && !empty($taille) && !empty($reseau1) && !empty($reseau2) && !empty($background) && !empty($button) && !empty($border));
    {
        // Nouveau profil
        userProfil($pdo, $name, $color, $font, $style, $couleur, $taille, $reseau1, $reseau2, $background, $button, $border, $id);

        // Avatar
        $profil_id = $pdo->lastInsertId();
        $info = pathinfo($_FILES['userfile1']['name']);
        
        mkdir("upload/" . $profil_id . "/");
        mkdir("upload/" . $profil_id . "/realisations/");

        move_uploaded_file($_FILES['userfile1']['tmp_name'], 'upload/' . $profil_id."/profil." . $info['extension']);

        // Réalisations
        $fichiers = $_FILES["realisations"];

        for ($i = 0; $i < count($fichiers["name"]); $i++)
        {
            $info = pathinfo($fichiers['name'][$i]);

            move_uploaded_file($fichiers['tmp_name'][$i], 'upload/' . $profil_id . "/realisations/$i." . $info['extension']);
        }

    // On redirige vers la page d'accueil sans le message de
    //  confirmation (erreur ?).
        header("Location: ../profil_tatoueur.php?message=1");
        exit();
    }


    header("Location: ../profil_tatoueur.php?erreur=1");
    exit();
?>