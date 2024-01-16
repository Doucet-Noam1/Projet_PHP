<?php
// Connexion à la base de données SQLite
require "bd.php";
try {
    $bdd = new PDO('sqlite:ma_base_de_donnees.db');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Vérifier si le formulaire a été soumis
if ($_POST) {
    // Récupérer la question et les réponses du formulaire
    $question = $_POST['question'];
    $reponses = $_POST['reponses'];
    $types = $_POST['types'];
    $est_correct = $_POST['est_correct'];


    // Insérer la question dans la base de données
    $idQuestion = getMaxIDQuestion(2, $bdd);
    $stmt = $bdd->prepare("INSERT INTO Question (id_quizz,id_question, id_type, libelle_question) VALUES (2,".$idQuestion.", ?, ?)");
    $stmt->execute([$types,$question]);

    $idReponse = getMaxIDReponse(2, $idQuestion, $bdd);
    foreach (explode(',', $reponses) as $reponse) {
        $stmtR = $bdd->prepare("INSERT INTO Reponse (id_question, id_quizz, id_reponse, libelle_reponse, est_correct) VALUES (?, 2, ?, ?, 0)");
        $stmtR->execute([$idQuestion, $idReponse, $reponse]);
        $idReponse++;
    }

    $idReponse = getMaxIDReponse(2, $idQuestion, $bdd);
    foreach (explode(',', $est_correct) as $est_correctR) {
        $stmtR = $bdd->prepare("INSERT INTO Reponse (id_question, id_quizz, id_reponse, libelle_reponse, est_correct) VALUES (?, 2, ?, ?, 1)");
        $stmtR->execute([$idQuestion, $idReponse, $est_correctR]);
        $idReponse++;
    }


    
}

// Vérifier si la table 'questions' existe
$table_exists = $bdd->query('SELECT 1 FROM question LIMIT 1');

if ($table_exists === false) {
    die('La table "question" n\'existe pas. Assurez-vous d\'avoir exécuté le script create_db.php.');
}

// Récupérer toutes les questions de la base de données
$requete = $bdd->query('SELECT * FROM question') or die(print_r($bdd->errorInfo(), true));
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

    <h1>Questions et Réponses</h1>

    <!-- Formulaire d'ajout de question -->
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
                <select type="select" name="types" required>
                    <option value="1">QCM</option>
                    <option value="2">Texte</option>
                    <option value="3">Chiffre</option>
                    <option value="4">Autre</option>
                </select>
            </li>
        </ul>
        <button type="submit">Ajouter la question</button>
    </form>

    <!-- Affichage des questions et réponses -->
    <h2>Liste des Questions</h2>
    <ul>
        <?php 
        foreach ($questions as $q) : 
            echo "<li>";
                echo "<h2>". htmlspecialchars($q['libelle_question']). "</h2>" ;
                $rep = $bdd->query('SELECT * FROM reponse WHERE id_question =' . $q["id_question"]);
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

</body>
</html>