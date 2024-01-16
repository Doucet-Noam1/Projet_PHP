<?php
require "input.php";
echo "<form action='reponses.php' method='POST'>";
echo "<h1>Répondez aux questions</h1>";
echo "<label for='q1'>De quelle couleur est le soleil?</label></br>";
$radio1 = new RadioButtonInput("r1","rouge","q1");
$radio2= new RadioButtonInput("r2","jaune","q1");
$radio3 = new RadioButtonInput("r3","blanc","q1");

$radio1 -> render();
$radio2 -> render();
$radio3 -> render();
echo "</br>";
echo "<label for='q2'>Quel pays et le plus grand?</label></br>";

$radio4 = new RadioButtonInput("r1","Russie","q2");
$radio5= new RadioButtonInput("r2","Chine","q2");
$radio6 = new RadioButtonInput("r3","Etats-Unis","q2");

$radio4 ->render();
$radio5 -> render();
$radio6 -> render();

echo "</br>";

$number = new NumberInput("nombre","reponse_dizaine","Quelle est la dizaine dans 342?",0);
$number -> render();
echo "</br>";

$submit = new SubmitButtonInput("submit","Valider");
$submit -> render();

echo "</form>";
?>