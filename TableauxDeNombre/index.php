<?php 


echo '<h1> Tableau de multiplication </h1> <br>';


//tableau de mutliplication

echo "<table border style='border-collapse: collaspe;'>
            <tr>
                <th> </th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
                <th>10</th>
            </tr>";
           
            for($i=1; $i<=10; $i++){
                echo '<tr> <th>'.$i.'</th>';
            
                for($j=1; $j<=10; $j++){
                    echo ' <td> ' . ($j*$i) . '</td>';
                }
             echo '</tr>';
            };
echo '</table>';



 echo '<br> <h1> Tableau de nombre </h1> <br>';
//tableau de nombre 

echo "<table border style='border-collapse: collaspe;'>
            <tr>
                <th> Nombre </th>
                <th>Carré</th>
                <th>Racine</th>
            </tr>";
           

            for($i=1; $i<=10; $i++){
                echo '<tr> 
                         <th>'.$i.'</th>
                         <td>' .($i*$i) . '</th>
                         <td>'. sqrt($i).'</th>
                      </tr>';
            };



echo '</table>';



echo '<br> <h1> Fonction Pour Solution Equation 2nd Degré </h1> <br>';



//Définir une fonction : Les racines d'une équation
// ax² + bx =c 0  DELTA = b² - 4*a*c , si <0 = pas de soluce, 
//  si DELTA = 0 alors Une seule solution : -b/2*a
// si > 0 2 solutions (-b -racine(delta))/2*a ou (-b + racine(delta))/2*a

function RacineEquation($nbrA, $nbrB,$nbrC){

    //equation 0 

    if($nbrA == 0){
        echo "EQUATION INVALIDE";
        exit;
    }

    $delta = ($nbrB*$nbrB) - (4*$nbrA*$nbrC); 

        if($delta > 0 ){
            $solution1 = (-$nbrB -sqrt($delta))/(2*$nbrA);
            $solution2 = (-$nbrB + sqrt($delta))/(2*$nbrA);

            $resultat = $solution1 . ' OU ' . $solution2;

        } else if ($delta == 0) {
            $resultat = (-$nbrB)/(2*$nbrA);
        }else{
            $resultat = "Pas de solution";
        }

    return $resultat;

}

$calcul = RacineEquation(5,5,1);

echo 'LE RESULTAT EST  : ' . $calcul;