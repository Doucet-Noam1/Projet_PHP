<?php

$bdd = new PDO('sqlite:ma_base_de_donnees.db');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_quizz = $_GET["id_quizz"];
$username = $_GET['username'];

$query = $bdd->query("SELECT * FROM Quizz WHERE id_quizz =".$id_quizz);
$quizz = $query->fetch(PDO::FETCH_ASSOC);
echo "<head><link rel='stylesheet' href='css/reponses.css'></head>";
echo "<h1>". $quizz['nom']." - Correction</h1>";

$queryQuestions = $bdd->query("SELECT * FROM Question where id_quizz=".$id_quizz);

echo "<h2>Questions</h2>";
echo "<form action='reponses.php?id_quizz=".$id_quizz."' method='POST'>";

$count = 0;
while ($question = $queryQuestions->fetch(PDO::FETCH_ASSOC)) {
    $queryCorrecte = $bdd->query("SELECT libelle_reponse FROM Reponse WHERE id_question =".$question['id_question']." and est_correct=true and id_quizz =".$question['id_quizz']);
    $bonneReponse = $queryCorrecte->fetch(PDO::FETCH_ASSOC);
    $reponse = $_POST[$question['id_question']];

    echo "<p><strong>".$question['libelle_question']."</strong></p>";
    echo "<p>Réponse : ".$bonneReponse['libelle_reponse']."</p>";
    

    if ($bonneReponse['libelle_reponse'] == $reponse) {
        echo "<p class='true'>Vous gagnez 1 point !";
        $count += 1;
    } else {
        echo "<p class='false'>Vous n'avez pas eu bon !";
    }
}

echo "<p><strong>SCORE: ".$count."</strong></p>";
$stmtR = $bdd->prepare("INSERT INTO A_Repondu (id_quizz, nom_utilisateur, score) VALUES (?,?,?)");
$stmtR->execute([$id_quizz, $username, $count]);
?>
