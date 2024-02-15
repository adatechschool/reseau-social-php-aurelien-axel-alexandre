<?php
session_start();

if (!isset($_COOKIE['autologin'])) {
    // Si le cookie d'auto-connexion n'est pas défini, redirigez vers la page de connexion
    header('Location: registration.php');
    exit;
}

list($username, $hash) = explode('&', $_COOKIE['autologin']);
$username = urldecode($username);
$hash = urldecode($hash);

// Ici, vous devriez vérifier le hash avec les informations de l'utilisateur stockées dans la base de données
// Si le hash est valide, démarrez une nouvelle session et connectez l'utilisateur automatiquement

if ($hash === $expectedHashFromDatabase) {
    $_SESSION['username'] = $username;
    // Redirigez l'utilisateur vers la page d'accueil ou le profil utilisateur
    header('Location: index.php');
    exit;
} else {
    // Si le hash n'est pas valide, redirigez vers la page de connexion
    header('Location: login.php');
    exit;
}
?>