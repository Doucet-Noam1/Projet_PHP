<?php
require "input.php";
$bdd = new PDO('sqlite:ma_base_de_donnees.db');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$id_quizz = $_GET["id"];


$query = $bdd->query("SELECT * FROM Quizz WHERE id =".$id_quizz);
$quizz = $query->fetch(PDO::FETCH_ASSOC);
// TYPES QUESTIONS : 1=NOMBRES, 2=StringFIELD, 3=RADIOBUTTON

echo "<h1>". $quizz['nom']."</h1>";

$queryQuestions = $bdd->query("SELECT * FROM Question where id_quizz=".$id_quizz);
echo "<h2>Questions</h2>";
echo "<form action='reponses.php?id=".$id_quizz."' method='POST'>";
while ($question = $queryQuestions->fetch(PDO::FETCH_ASSOC)) {
    $queryReponses = $bdd->query("SELECT * FROM Reponse where id_question=".$question['id_question']);
    if ($question['id_type']==1){
        $number = new NumberInput("nombre",$question['id_question'],$question['libelle_question'],0);
        $number -> render();
        }
    else if ($question['id_type']==2){
        $txt = new TextInput("texte",$question['id_question'],$question['libelle_question']);
        $txt -> render();
        }
    else if ($question['id_type']==3){
        echo "<label for='".$question['id_question']."'>".$question['libelle_question']."</label></br>";
        while ($reponse = $queryReponses->fetch(PDO::FETCH_ASSOC)){
            $radio = new RadioButtonInput($reponse['id_reponse'],$reponse['libelle_reponse'],$question['id_question']);
            $radio -> render();
        }
    }
}
$submit = new SubmitButtonInput("submit","Valider");
$submit -> render();
echo "</form>";
?>