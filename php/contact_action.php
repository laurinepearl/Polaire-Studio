<?php
    include("pdo.inc.php");

    // On créé une session.
    session_start();

    // On vérifie les informations.
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $message = trim($_POST["message"]);

    if (!verifInfo($nom, 2))
    {
        $_SESSION["erreur"] = "<p class= 'message'>". "Votre nom est invalide ! Il doit faire 2 caractères minimum sans caractères spéciaux.". "</p>\n";
        header("Location: ../contact.php?erreur=3");
        exit();
    }
    if (!verifInfo($prenom, 2))
    {
        $_SESSION["erreur"] = "<p class= 'message'>"."Votre prénom est invalide ! Il doit faire 2 caractères minimum sans caractères spéciaux.". "</p>\n";
        header("Location: ../contact.php?erreur=3");
        exit();
    }
    if (!verifInfo($tel, 10, 10))
    {
        $_SESSION["erreur"] = "<p class= 'message'>"."Votre n° de téléphone est invalide ! Il doit faire 10 caractères sans caractères spéciaux.". "</p>\n";
        header("Location: ../contact.php?erreur=3");
        exit();
    }
    if (!verifInfo($email, 8))
    {
        $_SESSION["erreur"] = "<p class= 'message'>"."Votre adresse e-mail est invalide ! Il doit faire 8 caractères minimum sans caractères spéciaux.". "</p>\n";
        header("Location: ../contact.php?erreur=3");
        exit();
    }

    // On ajoute le message dans la base de données.
    addFormMessage(getPDO(), $nom,$prenom,$tel, $email, $message);

    // On fait la redirection.
    header("Location: ../contact.php?message=1");
    exit();
?>