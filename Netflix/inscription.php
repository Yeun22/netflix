<?php
    session_start();
    require('src/log.php');

    if(isset($_SESSION['connect'])){
        header('Location: index.php');
        exit();
    }

    if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_two'])){
        require_once('src/dbconnect.php');
        
        $email          = htmlspecialchars($_POST['email']);
        $password       = htmlspecialchars($_POST['password']);
        $passwordTwo    = htmlspecialchars($_POST['password_two']);


        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //si l'adresse n'est pas valide car !filter
            header('location: inscription.php?error=1&message=Votre adresse n\'est pas valide');
            exit();
        }
        
        
        $req = $db->prepare('SELECT COUNT(*) AS numberEmail FROM users  WHERE email= ?');
        $req->execute(array($email));
        while($emailVerification = $req->fetch()){
            if($emailVerification['numberEmail'] !=0 ){
                header('Location: inscription.php?error=1&message=Cette addresse email est déjà utilisée ! ');
                exit();
            }
        }
        //Création d'un secret
        $secret = sha1($email).time();
        $secret = "gf".sha1($secret).'12';
        
        
        if($password != $passwordTwo){
            header('Location: inscription.php?error=1&message=Les mots de passes ne correspondent pas.');
            exit();
        }else{
            //Oncrypte : 
            $password = "852zh".sha1($password."y2f4")."5hgd8";
        }
        
        $req = $db->prepare('INSERT INTO users (email, password, secret) VALUES ( ?,?,?)');
        $req->execute(array($email, $password, $secret));

        header('Location: inscription.php?success=1');
        exit();
        
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix | Inscription</title>
    <link rel="stylesheet" href="design/default.css"/>
    <link rel="icon" type="image/png" href="img/favicon.png">
</head>
<body>
    <?php include('src/header.php'); ?>

    <section>
        <div id="login-body">
            <h1>S'inscrire</h1>

            <?php 

            if(isset($_GET['error'])){
                
                if(isset($_GET['message'])){
                    echo '<div class="alert error"> '. htmlspecialchars($_GET['message']). "</div>";
                }
            } else if(isset($_GET['success'])){
                echo'<div class="alert success"> Vous êtes désormais inscrit à notre site ! <a href="index.php"> Connectez-Vous </a>.</div>';
            }
        ?>

            <form method="post" action = "inscription.php" >
                <input type="email" name="email" placeholder="Votre adresse email" required />
                <input type="password" name="password" placeholder="Mot de passe" required />
                <input type="password" name="password_two" placeholder="Retaper votre mot de passe" required />

                <button type="submit">S'inscrire</button>
            </form>

            <p class="grey">Déjà sur Netflix ? <a href="index.php">Connectez-vous</a></p>
        </div>
    </section>

    <?php include('src/footer.php'); ?>
</body>
</html>