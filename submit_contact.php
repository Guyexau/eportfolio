<?php
$servername = "localhost"; // Adresse du serveur
$database = "u106196631_main"; // Nom de votre base de données
$username = "u106196631_gmx"; // Nom d'utilisateur MySQL
$password = "Romains12:2"; // Mot de passe MySQL

// Connexion à la base de données
$conn = mysqli_connect($servername, $username, $password, $database);

// Vérification de la connexion
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage des données
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Insertion des données dans la table `contact_form`
    $sql = "INSERT INTO contact_form (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Liaison des paramètres
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $subject, $message);

        // Exécution de la requête
        if (mysqli_stmt_execute($stmt)) {
            echo "Merci ! Votre message a été enregistré avec succès.";

            // Envoi de l'e-mail
            $to = "votre_email@example.com"; // Remplacez par votre adresse e-mail
            $mail_subject = "Nouveau message de contact : $subject";
            $mail_body = "Vous avez reçu un nouveau message depuis le formulaire de contact :\n\n" .
                         "Nom : $name\n" .
                         "Email : $email\n" .
                         "Sujet : $subject\n" .
                         "Message :\n$message";

            // En-têtes pour l'envoi de l'e-mail
            $headers = "From: $email\r\n" .
                       "Reply-To: $email\r\n" .
                       "X-Mailer: PHP/" . phpversion();

            // Envoi
            if (mail($to, $mail_subject, $mail_body, $headers)) {
                echo " Un e-mail a également été envoyé.";
            } else {
                echo " L'envoi de l'e-mail a échoué.";
            }
        } else {
            echo "Erreur lors de l'insertion dans la base de données : " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt); // Fermeture de la requête préparée
    } else {
        echo "Erreur de préparation de la requête : " . mysqli_error($conn);
    }
}

// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>
