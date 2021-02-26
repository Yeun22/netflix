<?php

    session_start();

    require('src/log.php');

    if(!empty($_POST['email']) && !empty($_POST['password'])){
        require('src/dbconnect.php');

        $email      = htmlspecialchars($_POST['email']);
        $password   = htmlspecialchars($_POST['password']);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header('Location: index.php?error=1&message=Cette adresse email n\'est pas valide');
            exit();
        }
        //Chiffrage du mdp
        $password = "852zh".sha1($password."y2f4")."5hgd8";

        //Verif de l'email
        $req = $db->prepare('SELECT COUNT(*) AS numberEmail FROM users WHERE email = ?');
        $req->execute(array($email));

        while($validationEmail = $req->fetch()){
            if($validationEmail['numberEmail'] != 1){
                header('Location: index.php?error=1&message=Impossible de vous authentifier correctement.');
                exit();
            }
        }
        //Connexion
        $req = $db->prepare('SELECT * FROM users WHERE email = ?');
        $req->execute(array($email));
        while($user = $req->fetch()){
            if($password == $user['password']){
                $_SESSION['connect']= 1;
                $_SESSION['email'] = $user['email'];

                if(isset($_POST['auto'])){ //si checkbox coché alors elle existe
                    setcookie('auth', $user['secret'], time()+364*24*3600, '/', null, false, true);
                }

                header('Location: index.php?success=1');
                exit();

            }else{
                header('Location: index.php?error=1&message=Impossible de vous authentifier correctement.');
                exit();
            }
        }
    }


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix</title>
    <link rel="stylesheet" type="text/css" href="design/default.css">
	<link rel="icon" type="image/png" href="img/favicon.png">
</head>
<body>
    <?php include('src/header.php'); ?>

    <section>
        <div id="login-body">

            <?php if(isset($_SESSION['connect'])){ ?>

                <h1>Bonjour !</h1>
                <?php if(isset($_GET['success'])){
                        echo'<div class="alert success"> Vous êtes désormais connecté ! </div>';
                    }
                ?>
                <p> Qu'allez vous regarder aujourd'hui ?</p>
                <small><a href="logOut.php">Déconnexion.</a></small>

           <?php } else { ?>

                <h1>S'identifier</h1>

                <?php 

                    if(isset($_GET['error'])){
                        
                        if(isset($_GET['message'])){
                            echo '<div class="alert error"> '. htmlspecialchars($_GET['message']). "</div>";
                        }
                    }  
                ?>

                <form method="post" action = "index.php" >
                    <input type="email" name="email" placeholder="Votre adresse email" required />
                    <input type="password" name="password" placeholder="Mot de passe" required />
                    <button type="submit">S'identifier</button>
                    <label id="option"><input type="checkbox" name="auto" checked />Se souvenir de moi </label>
                </form>

                <p class="grey">Première visite sur Netflix ? <a href="inscription.php">Inscrivez-vous</a></p>
            <?php } ?>
        </div>
    </section>

    <?php include('src/footer.php'); ?>
</body>
</html>