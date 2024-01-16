<?php
$bdd = new PDO('sqlite:ma_base_de_donnees.db');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$queryQuizz = $bdd->query("SELECT * FROM Quizz");
echo "<h1>MES QUIZS</h1>";
while ($quizz = $queryQuizz->fetch(PDO::FETCH_ASSOC)) {
    echo "<a href='un_quizz.php?id=" . $quizz['id'] . "' title='voir les commentaires'>".$quizz['nom']."</a>";


}