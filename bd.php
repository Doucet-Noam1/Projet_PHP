<?php

function loadBD() {
try {
    if (file_exists('ma_base_de_donnees.db')) {
        unlink('ma_base_de_donnees.db');
        echo "Base de données existante supprimée.<br>";
    }


    $bdd = new PDO('sqlite:ma_base_de_donnees.db');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $bdd ->exec('CREATE TABLE IF NOT EXISTS Utilisateur ( 
        nom_utilisateur TEXT PRIMARY KEY,
        mot_de_passe TEXT)'
    );
    $bdd->exec('CREATE TABLE IF NOT EXISTS Quizz (
        id_quizz INTEGER PRIMARY KEY,
        nom TEXT
    )');

$bdd->exec('CREATE TABLE IF NOT EXISTS TypeQuestion (
        id_type INTEGER PRIMARY KEY,
        libelle_type TEXT
    )');

$bdd ->exec('CREATE TABLE IF NOT EXISTS A_Repondu(
    id_quizz INTEGER,
    id_utilisateur INTEGER,
    score INTEGER,
    PRIMARY KEY(id_quizz, id_utilisateur),
    FOREIGN KEY(id_quizz) REFERENCES Quizz(id_quizz),
    FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
)');

$bdd->exec('CREATE TABLE IF NOT EXISTS Question (
    id_quizz INTEGER,
    id_type INTEGER,
    id_question INTEGER,
    libelle_question TEXT,
    PRIMARY KEY(id_quizz, id_question),
    FOREIGN KEY(id_quizz) REFERENCES Quizz(id_quizz),
    FOREIGN KEY(id_type) REFERENCES TypeQuestion(id_type)
)');

$bdd->exec('CREATE TABLE IF NOT EXISTS Reponse (
        id_question INTEGER,
        id_reponse INTEGER,
        id_quizz INTEGER,
        libelle_reponse TEXT,
        est_correct BOOLEAN,
        PRIMARY KEY(id_question, id_reponse),
        FOREIGN KEY(id_question) REFERENCES Question(id_question)
        FOREIGN KEY(id_quizz) REFERENCES Quizz(id_quizz)
    )');

 $bdd->exec("INSERT INTO Quizz (nom) VALUES ('Quiz PHP')");
 $bdd->exec("INSERT INTO Quizz (nom) VALUES ('Quizz sur les dieux')");

 $bdd->exec("INSERT INTO TypeQuestion (libelle_type) VALUES ('Vrai/Faux')");
 $bdd->exec("INSERT INTO TypeQuestion (libelle_type) VALUES ('Texte')");
 $bdd->exec("INSERT INTO TypeQuestion (libelle_type) VALUES ('Number')");
 $bdd->exec("INSERT INTO TypeQuestion (libelle_type) VALUES ('Nombre')");


 $bdd->exec("INSERT INTO Utilisateur (nom_utilisateur, mot_de_passe) VALUES ('Noam', 'test')");

 $bdd->exec("INSERT INTO Question (id_quizz, id_type,id_question, libelle_question) VALUES (1, 1,1, 'Le PHP est un langage de programmation')");
 $bdd->exec("INSERT INTO Question (id_quizz, id_type,id_question, libelle_question) VALUES (2, 3,2, 'Combien de soeurs a Meduse?')");
 $bdd->exec("INSERT INTO Question (id_quizz, id_type,id_question, libelle_question) VALUES (2, 2,3, 'Qui est la déesse de la vengeance?')");
 $bdd->exec("INSERT INTO Question (id_quizz, id_type,id_question, libelle_question) VALUES (2, 1,4, 'Que porte Atlas sur ses épaules?')");

 $bdd->exec("INSERT INTO Reponse (id_question, id_reponse,id_quizz, libelle_reponse, est_correct) VALUES (1, 1,1, 'Vrai', 1)");
 $bdd->exec("INSERT INTO Reponse (id_question, id_reponse,id_quizz, libelle_reponse, est_correct) VALUES (1, 2,1, 'Faux', 0)");
 $bdd->exec("INSERT INTO Reponse (id_question, id_reponse,id_quizz, libelle_reponse, est_correct) VALUES (2, 3,2, '2', 1)");
 $bdd->exec("INSERT INTO Reponse (id_question, id_reponse,id_quizz, libelle_reponse, est_correct) VALUES (3, 4,2, 'Nemesis', 1)");
 $bdd->exec("INSERT INTO Reponse (id_question, id_reponse,id_quizz, libelle_reponse, est_correct) VALUES (4, 5,2, 'Noam', 0)");
 $bdd->exec("INSERT INTO Reponse (id_question, id_reponse,id_quizz, libelle_reponse, est_correct) VALUES (4, 6,2, 'Le monde', 1)");
 $bdd->exec("INSERT INTO Reponse (id_question, id_reponse,id_quizz, libelle_reponse, est_correct) VALUES (4, 7,2, 'Christelle Fernier', 0)");

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
function getMaxIDQuizz($bdd){
    $query = $bdd->query("SELECT MAX(id_quizz) AS max_id FROM Quizz");
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if($result['max_id'] == null){
        return 1;
    }
    
    return $result['max_id'] +1;
}
?>