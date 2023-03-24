<?php
    session_start();

    include("pdo.inc.php");

    $pdo = getPDO();
    $id =  $_SESSION["identification"]["id_utilisateur"];

    deleteprofil($pdo, $id);

    session_destroy();

    header("Location: ../index.php?message=2");

    exit();
?>