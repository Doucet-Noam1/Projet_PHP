<?php
$r1 = $_POST["q1"];
$r2 = $_POST["q2"];
$r3 = $_POST["reponse_dizaine"];

echo "Question 1 : ";
if ($r1 == "blanc"){
    echo "👍 Bonne réponse ! ";
}
else{
    echo "👎 La réponse était blanc";
}

echo "</br>Question 2 : ";
if ($r2 == "Russie"){
    echo "👍 Bonne réponse !";
}
else{
    echo "👎 La réponse était la Russie";
}

echo "</br>Question 3 : ";
if ($r3 == 4){
    echo "👍 Bonne réponse !";
}
else{
    echo "👎 La réponse était 4";
}
?>