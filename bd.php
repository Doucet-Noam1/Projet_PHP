<?php
try {
    // Création de la base SQLite
    $bdd = new PDO('sqlite:ma_base_de_donnees.db');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $bdd->exec('CREATE TABLE IF NOT EXISTS Quizz (
        id INTEGER PRIMARY KEY,
        nom TEXT
    )');

// Création de la table TypeQuestion
$bdd->exec('CREATE TABLE IF NOT EXISTS TypeQuestion (
        id_type INTEGER PRIMARY KEY,
        libelle_type TEXT
    )');

// Création de la table Question
$bdd->exec('CREATE TABLE IF NOT EXISTS Question (
    id_quizz INTEGER,
    id_type INTEGER,
    id_question INTEGER,
    libelle_question TEXT,
    PRIMARY KEY(id_quizz, id_question),
    FOREIGN KEY(id_quizz) REFERENCES Quizz(id),
    FOREIGN KEY(id_type) REFERENCES TypeQuestion(id_type)
)');

// Création de la table Reponse
$bdd->exec('CREATE TABLE IF NOT EXISTS Reponse (
        id_question INTEGER,
        id_reponse INTEGER,
        libelle_reponse TEXT,
        est_correct BOOLEAN,
        PRIMARY KEY(id_question, id_reponse),
        FOREIGN KEY(id_question) REFERENCES Question(id)
    )');

 // Ajout d'un quizz
 $bdd->exec("INSERT INTO Quizz (nom) VALUES ('Quiz PHP')");

 // Ajout de types de questions
 $bdd->exec("INSERT INTO TypeQuestion (libelle_type) VALUES ('Vrai/Faux')");
 $bdd->exec("INSERT INTO TypeQuestion (libelle_type) VALUES ('Nombre')");

 // Ajout d'une question liée à un quizz
 $bdd->exec("INSERT INTO Question (id_quizz, id_type, libelle_question) VALUES (1, 1, 'Le PHP est un langage de programmation')");

 // Ajout de réponses associées à la question
 $bdd->exec("INSERT INTO Reponse (id_question, id_reponse, libelle_reponse, est_correct) VALUES (1, 1, 'Vrai', 1)");
 $bdd->exec("INSERT INTO Reponse (id_question, id_reponse, libelle_reponse, est_correct) VALUES (1, 2, 'Faux', 0)");

 echo "Données insérées avec succès.";

} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}
?>