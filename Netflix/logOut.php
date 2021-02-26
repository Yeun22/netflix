<?php
    session_start(); 
    session_unset(); //désactive la session 
    session_destroy(); // détruit la session
    setcookie('auth', '',time()-1, '/',null,false,true); //Destruction du cookie

    header("Location: index.php");
    exit();
?>