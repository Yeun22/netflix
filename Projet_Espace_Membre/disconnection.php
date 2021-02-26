<?php
                    //DECONNEXION
    session_start(); //On initialise la session pour travailler dessus

    session_unset(); //Désactive la session 

    session_destroy(); //Détruit la section

    setcookie('log', '' , time()-3600,'/',null, false, true);
    
    header('location: index.php');
    exit();

?>