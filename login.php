<?php
session_start(); 
$bdd = new PDO('sqlite:ma_base_de_donnees.db');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function verifie_utilisateur($username, $password, $bdd) {
    

    $query = $bdd->prepare("SELECT * FROM Utilisateur WHERE nom_utilisateur = ? AND mot_de_passe = ?");
    $query->execute([$username,$password ]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    return ($user !== false);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (verifie_utilisateur($username, $password, $bdd)) {
        $_SESSION['username'] = $username; 
        header('Location: index.php'); 
        exit();
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <form method="post" action="login.php">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" name="username" required><br>

        <label for="password">Mot de passe:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Se connecter</button>
    </form>
</body>
</html>