<?php
    include("pdo.inc.php");

    session_start();

    function checkEmail($email)
    {
        // On vérifie que la variable "email" n'est pas vide et que sa taille
        //  excède 7 caractères.
        if (empty($email) || !verifInfo($email, 7))
        {
            return false;
        }

        // On vérifie si la variable "email" semble correspondre à une véritable adresse.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return false;
        }

        // Si les vérifications réussissent, alors on retourne la variable.
        return $email;
    }

    function checkPassword($password, $confirmation)
    {
        // On vérifie qu'il existe quelque chose dans les deux mots de passe.
        if (empty($password) || empty($confirmation))
        {
            return false;
        }

        // On vérifie que le premier mot de passe correspond au second.
        if ($password != $confirmation)
        {
            return false;
        }

        // On retourne le mot de passe si les vérifications réussissent.
        return $password;
    }

    // Vérification des informations.
    $pdo = getPDO();
    $user = new User();
    $email = checkEmail($_POST["Email"]);
    $password = checkPassword($_POST["password"], $_POST["password2"]);
    $prenom = $_POST["prenom"];

    if ($user->emailExists($pdo, $email))
    {
        // L'adresse email existe déjà.
        header("Location: ../index.php?erreur=2");
        exit();
    }

    if ($email && $password)
    {
        // On insère les informations dans la base de données.
        $user->addUser($pdo, $email, $password, $prenom);
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