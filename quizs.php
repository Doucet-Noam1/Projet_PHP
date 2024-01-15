<?php
$bdd = new PDO('sqlite:ma_base_de_donnees.db');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$queryQuizz = $bdd->query("SELECT * FROM Quizz");
echo "<h1>MES QUIZS</h1>";
while ($quizz = $queryQuizz->fetch(PDO::FETCH_ASSOC)) {
    $id = $quizz['id'];
    echo "<p><em><a href='un_quiz.php?id=" . $id . "' title='voir les commentaires'>Commentaires</a></em></p>";


}