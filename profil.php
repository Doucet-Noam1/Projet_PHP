<?php

$bdd = new PDO('sqlite:ma_base_de_donnees.db');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$username = $_GET['id'];
echo "<h1>Profil - ".$username."</h1>";
$queryScores = $bdd->query("SELECT * FROM A_Repondu");

while ($scores = $queryScores->fetch(PDO::FETCH_ASSOC)){
    if ($scores['nom_utilisateur']==$username){
        $nomquizz = $bdd->query("SELECT * FROM Quizz where id_quizz=".$scores['id_quizz']);
        $quizz = $nomquizz->fetch(PDO::FETCH_ASSOC);
        echo "<p>".$quizz['nom']." - Score :".$scores['score']."</p>";
    }
    
}
echo ' <a href="index.php"> accueil</a>';