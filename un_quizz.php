<?php
require "input.php";
$bdd = new PDO('sqlite:ma_base_de_donnees.db');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_quizz = $_GET["id_quizz"];
$nom_utilisateur = $_GET["nom_utilisateur"];

$a_repondu = $bdd->query("SELECT * FROM A_Repondu WHERE id_quizz = ".$id_quizz." AND nom_utilisateur = '".$nom_utilisateur."'");
$a_repondu = $a_repondu->fetch(PDO::FETCH_ASSOC);
if ($a_repondu != false){
    echo "vous avez deja repondu";
}
else{

    $query = $bdd->query("SELECT * FROM Quizz WHERE id_quizz =" . $id_quizz);
    $quizz = $query->fetch(PDO::FETCH_ASSOC);
    
    echo "<h1>". $quizz['nom']."</h1>";
    
    $queryQuestions = $bdd->query("SELECT * FROM Question where id_quizz=" . $id_quizz);
    
    echo "<h2>Questions</h2>";
    echo "<form action='reponses.php?id_quizz=" . $id_quizz . "&nom_utilisateur=" . $nom_utilisateur . "' method='POST'>";
    while ($question = $queryQuestions->fetch(PDO::FETCH_ASSOC)) {
        $queryReponses = $bdd->query("SELECT * FROM Reponse where id_question=".$question['id_question']. ' and id_quizz='.$question['id_quizz']);
        
        if ($question['id_type'] == 3) {
            $number = new NumberInput("nombre", $question['id_question'], $question['libelle_question'], 0);
            $number->render();
        } else if ($question['id_type'] == 2) {
            $txt = new TextInput("texte", $question['id_question'], $question['libelle_question']);
            $txt->render();
        } else if ($question['id_type'] == 1) {
            echo "<label for='" . $question['id_question'] . "'>" . $question['libelle_question'] . "</label></br>";
            while ($reponse = $queryReponses->fetch(PDO::FETCH_ASSOC)) {
                $radio = new RadioButtonInput($reponse['id_reponse'], $reponse['libelle_reponse'], $question['id_question']);
                $radio->render();
            }
        }
    }
    $submit = new SubmitButtonInput("submit", "Valider");
    $submit->render();
    echo "</form>";
}
echo ' <a href="index.php"> accueil</a>';

?>
