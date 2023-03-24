<?php
    ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

    include("pdo.inc.php");

    session_start();

    $pdo = getPDO();
    $id =  $_SESSION["identification"]["id_utilisateur"];

    if (!empty($_POST["heure"])) {
        updateHoraires($pdo, $id, $_POST["heure"]);
    }

    header("Location: ../profil_tatoueur.php");
    exit();
?>