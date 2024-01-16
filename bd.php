<?php

function loadBD() {
try {
    // Suppression de la base de données existante
    if (file_exists('ma_base_de_donnees.db')) {
        unlink('ma_base_de_donnees.db');
        echo "Base de données existante supprimée.<br>";
    }

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
        id_quizz INTEGER,
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

 echo "Données insérées avec succès.";
 return $bdd;
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

 function getMaxIDquestion($id_quizz, $bdd){
    $query = $bdd->query("SELECT MAX(id_question) AS max_id FROM Question WHERE id_quizz = " . $id_quizz);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if($result['max_id'] == null){
        return 1;
    }
    
    return $result['max_id'] +1;
}
function getMaxIDReponse($id_quizz,$id_question, $bdd){
    $query = $bdd->query("SELECT MAX(id_reponse) AS max_id FROM Reponse WHERE id_quizz = " . $id_quizz ." and id_question = " . $id_question);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if($result['max_id'] == null){
        return 1;
    }
    
    return $result['max_id'] +1;
}

?>