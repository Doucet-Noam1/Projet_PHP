<?php
// Connexion à la base de données SQLite
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

    // Insérer la question dans la base de données
    
    $stmt = $bdd->prepare("INSERT INTO Question (id_quizz, id_type, libelle_question) VALUES (".getMaxIDQuestion($quiz, $bdd).", ?, ?)");
    $stmt->execute([$types],[$question]);
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
        <label for="question">Question :</label>
        <input type="text" name="question" required>

        <label for="reponses">Réponses associées (séparées par des virgules) :</label>
        <input type="text" name="reponses" required>

        <label for="types">Réponses associées (séparées par des virgules) :</label>
        <input type="select" name="types" required>

        <button type="submit">Ajouter la question</button>
    </form>

    <!-- Affichage des questions et réponses -->
    <h2>Liste des Questions</h2>
    <ul>
        <?php foreach ($questions as $q) : ?>
            <li>
            <strong><?= htmlspecialchars($q['libelle_question']); ?></strong><br>
                <?php $rep = $bdd->query('SELECT * FROM reponse where id_question =' . $q["id_question"])->fetchAll();?>
                <p>Réponses :</p>
                <?php foreach ($rep as $r) : ?>
                    <?= htmlspecialchars($r['libelle_reponse']); ?>
                <?php endforeach; ?>
            </li>
        <?php endforeach; ?>
    </ul>

</body>
</html>