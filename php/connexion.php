<?php
    include("pdo.inc.php");

    session_start();

    $pdo = getPDO();
    $user = new User();
    $email = $_POST["Email"] ?? "";
    $password = $_POST["password"] ?? "";

    if ($user->emailExists($pdo, $email) && $user->passwordExists($pdo, $email, $password))
    {
        $user->loginUser($pdo, $email);

        // On redirige vers la page d'accueil avec un message
        //  de confirmation.
        header("Location: ../index.php?message=1");
        exit();
    }

    // On redirige vers la page d'accueil sans le message de
    //  confirmation (erreur ?).
    header("Location: ../index.php?erreur=1");
    exit();
?>