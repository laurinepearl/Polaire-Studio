<?php
    include("pdo.inc.php");

    // On récupère toutes les variables en provenance de la requête AJAX.
    $pdo = getPDO();
    $user = new User();
    $step = $_POST["step"] ?? 1;
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    // Dans tous les cas, on vérifie si l'adresse électronique de l'utilisateur
    //  existe dans la base de données.
    if (!$user->emailExists($pdo, $email))
    {
        http_response_code(403); // Erreur 403 = non autorisé
        exit();
    }

    // Lors de la deuxième étape, on actualise la base de données avec le nouveau
    //  mot de passe de l'utilisateur.
    if ($step == 2 && trim($password) != "")
    {
        $user->updateUser($pdo, $email, $password);
    }

    // Enfin, on indique que la requête s'est déroulée sans problème :D
    http_response_code(200);
    exit();
?>