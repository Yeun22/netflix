<?php

    $fichier = fopen('count.txt', 'r+');

    $pages = fgets($fichier);

    

    fseek($fichier, 0); //JE remet mon cursor à zéro
    
    $pages= $pages + 1;

    fputs($fichier, $pages);


    fclose($fichier);

    echo "Vous êtes la ".$pages." eme personne sur ce site !";

?>