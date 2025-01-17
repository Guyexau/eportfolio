<?php
// Configuration de la base de données
$host = "193.203.168.173"; // Adresse du serveur
$dbname = "u106196631_eportfolio"; // Nom de votre base de données
$username = "u106196631_gmx"; // Nom d'utilisateur MySQL
$password = "$0penTh@tsh1t$"; // Mot de passe MySQL

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifie si les données ont été envoyées
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération et nettoyage des données
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $subject = htmlspecialchars(trim($_POST['subject']));
        $message = htmlspecialchars(trim($_POST['message']));

        // Requête pour insérer les données dans la base
        $sql = "INSERT INTO contacts (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':subject' => $subject,
            ':message' => $message,
        ]);

        echo "Merci ! Votre message a été envoyé avec succès.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
