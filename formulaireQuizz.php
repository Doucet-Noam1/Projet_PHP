<?php

require "bd.php";
try {
    $bdd = new PDO('sqlite:ma_base_de_donnees.db');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
if ($_GET){
    $quiz = $_GET['quiz'];
    $id_quizz = $_GET['id_quizz'];
    $queryCheckQuizz = $bdd->prepare("SELECT COUNT(*) AS count FROM Quizz WHERE id_quizz = ?");
    $queryCheckQuizz->execute([$id_quizz]);
    $result = $queryCheckQuizz->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] == 0) {
        // L'ID de quiz n'existe pas, procéder à l'insertion
        $stmt = $bdd->prepare("INSERT INTO Quizz (id_quizz, nom) VALUES (?, ?)");
        $stmt->execute([$id_quizz, $quiz]);
    }

}
if ($_POST) {
    $question = $_POST['question'];
    $reponses = $_POST['reponses'];
    $types = $_POST['types'];
    $est_correct = $_POST['est_correct'];


    $idQuestion = getMaxIDQuestion($id_quizz, $bdd);
    $stmt = $bdd->prepare("INSERT INTO Question (id_quizz,id_question, id_type, libelle_question) VALUES ($id_quizz,".$idQuestion.", ?, ?)");
    $stmt->execute([$types,$question]);

    $idReponse = getMaxIDReponse($id_quizz, $idQuestion, $bdd);
    foreach (explode(',', $reponses) as $reponse) {
        $stmtR = $bdd->prepare("INSERT INTO Reponse (id_question, id_reponse,id_quizz,  libelle_reponse, est_correct) VALUES (?,?,?,?, 0)");
        $stmtR->execute([$idQuestion,$idReponse, $id_quizz,$reponse]);
        $idReponse++;
    }

    foreach (explode(',', $est_correct) as $est_correctR) {
        $stmtRR = $bdd->prepare("INSERT INTO Reponse (id_question, id_quizz, id_reponse, libelle_reponse, est_correct) VALUES (?, $id_quizz, ?, ?, 1)");
        $stmtRR->execute([$idQuestion, $idReponse, $est_correctR]);
        $idReponse++;
    }


    
}
$requete = $bdd->query('SELECT * FROM question WHERE id_quizz = ' .$id_quizz) or die(print_r($bdd->errorInfo(), true));
$questions = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions et Réponses</title>
</head>
<body>

    <h1><?php echo $quiz ?></h1>

    <form method="post" action="">


        <ul>
            <li>
                <label for="question">Question :</label>
                <input type="text" name="question" required>
            </li>
 
                <li>
                <label for="reponses">Mauvaise réponses (séparées par des virgules) :</label>
                <input type="text" name="reponses" required>
                </li>

            <li>
                <label for="est_correct">Bonne réponses (séparées par des virgules) :</label>
                <input type="text" name="est_correct" required>
            </li>
            <li>
                <label for="types">Type de question :</label>
                <select type="select" name="types" required onchange="toggleReponsesField()">
                    <option value="1">QCM</option>
                    <option value="2">Texte</option>
                    <option value="3">Chiffre</option>
                </select>
            </li>
        </ul>
        <button type="submit">Ajouter la question</button>
    </form>

    <h2>Liste des Questions</h2>
    <ul>
        <?php 
        foreach ($questions as $q) : 
            echo "<li>";
                echo "<h2>". htmlspecialchars($q['libelle_question']). "</h2>" ;
                $rep = $bdd->query('SELECT * FROM Reponse WHERE id_question =' . $q["id_question"] .' and id_quizz =' .$id_quizz);
                echo "<ul>";
                    foreach ($rep as $r) : 
                        echo "<li>";
                            if ($r['est_correct'] == 1) {
                                echo "<p style='color:green'>".htmlspecialchars($r['libelle_reponse'])."</p>";
                            } else {
                                echo "<p style='color:red'>".htmlspecialchars($r['libelle_reponse'])."</p>";
                            }
                        echo "</li>";
                    endforeach; 
                echo "</ul>";
            echo "</li>";
        endforeach; 
        ?>
    </ul>
<a href="index.php"> accueil</a>
</body>
</html>
<script>
    function toggleReponsesField() {
        var selectedType = document.getElementById('types').value;
        var reponsesField = document.getElementById('reponses');

        if (selectedType == 1) {
            reponsesField.disabled = false;
        } else {
            reponsesField.disabled = true;
        }
    }
</script>