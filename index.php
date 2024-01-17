<?php
require "bd.php";
$bdd = new PDO('sqlite:ma_base_de_donnees.db');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();

if (!isset($_SESSION['nom_utilisateur'])) {
    header('Location: login.php'); 
    exit();

}
$nom_utilisateur = $_SESSION['nom_utilisateur'];
echo 'Bonjour ' . $nom_utilisateur;
=======
$nom_utilisateur= $_SESSION['nom_utilisateur'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Acceuil</title>
</head>

<?php
echo '<p> Bonjour ' . $nom_utilisateur ."</p>";
$queryQuizz = $bdd->query("SELECT * FROM Quizz");
echo "<div>";
$id = getMaxIDQuizz($bdd);
echo '<form method="get" action="formulaireQuizz.php">';
echo '<label for="quiz">Nom du nouveau quiz :</label>';
echo '<input type="hidden" name="id_quizz" value="' . $id . '">';
echo '<input type="text" name="quiz" required>';
echo '<button type="submit">Créer le quiz</button>';
echo "</div>";
echo "<h1>MES QUIZS</h1>";
echo '<ul>';
while ($quizz = $queryQuizz->fetch(PDO::FETCH_ASSOC)) {
    echo '<li>';
    echo '<form method="post" action="un_quizz.php">';
    echo "<a href='un_quizz.php?id_quizz=" . $quizz['id_quizz'] . "&nom_utilisateur=".$nom_utilisateur."' title='voir les commentaires'>".$quizz['nom']."</a>";

    echo '</form>';
    echo '</li>';
}
    echo '</ul>';

    $id = getMaxIDQuizz($bdd);
    echo '<form method="get" action="formulaireQuizz.php">';
    echo '<label for="quiz">nom du quiz :</label>';
    echo '<input type="hidden" name="id_quizz" value="' . $id . '">';
    echo '<input type="text" name="quiz" required>';
    echo ' <button type="submit">Créer un quiz</button>';
    echo "<a href='profil.php?id=".$nom_utilisateur."'>Profil</a>";

?>

