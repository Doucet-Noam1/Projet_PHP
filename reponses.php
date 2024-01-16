<?php

$bdd = new PDO('sqlite:ma_base_de_donnees.db');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$id_quizz = $_GET["id"];


$query = $bdd->query("SELECT * FROM Quizz WHERE id =".$id_quizz);
$quizz = $query->fetch(PDO::FETCH_ASSOC);
echo "<h1>". $quizz['nom']." - Correction</h1>";

$queryQuestions = $bdd->query("SELECT * FROM Question where id_quizz=".$id_quizz);
echo "<h2>Questions</h2>";
echo "<form action='reponses.php?id=".$id_quizz."' method='POST'>";
$count = 0;
while ($question = $queryQuestions->fetch(PDO::FETCH_ASSOC)) {
    $queryCorrecte = $bdd->query("SELECT libelle_reponse FROM Reponse WHERE id_question =".$question['id_question']." and est_correct=true");
    $bonneReponse = $queryCorrecte->fetch(PDO::FETCH_ASSOC);
    $reponse = $_POST[$question['id_question']];
    echo "<p>".$question['libelle_question']."</p>";
    echo "<p>Réponse : ".$bonneReponse['libelle_reponse']."</p>";
    echo $reponse;
    if ($bonneReponse['libelle_reponse'] == $reponse){
        echo "<p>Vous gagnez 1 point !";

        $count +=1;
    }
    else{
        echo "<p>Vous n'avez pas eu bon !";
    }
    
    }
    echo "<p>SCORE: ".$count."</p>"
?>

