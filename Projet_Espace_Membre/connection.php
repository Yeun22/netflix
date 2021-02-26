<?php
    session_start();

                            //CONNEXION
    if(isset($_SESSION['connect'])){
        header('location: index.php');
        exit();
    }

    require_once('src/connectBase.php');

    if(!empty($_POST['email']) && !empty($_POST['password'])){
        $email        =   $_POST['email'];
        $password     =   $_POST['password'];
        //Cryptage du password
        $password     = "vz35".sha1($password.f1d56)."z5f";

        $req = $db->prepare('SELECT * FROM users WHERE email = ?');
        $req->execute(array($email));
        while($user = $req->fetch()){
            if($password == $user['password']){
                $_SESSION['connect']= 1;
                $_SESSION['pseudo'] = $user['pseudo'];

                //Vérifie si y'a la connexion auto : 
                if(isset($_POST['connect'])){
                    setcookie("log",$user['secret'],time()+365*24*3600,'/',null,false,true);
                }

                header('Location: connection.php?success=1');
                exit();
            }
        }
        header('Location: connection.php?error=1');
        exit();
    }


?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel ="stylesheet" href="design/default.css">
        <title>Projet Espace Membre | CONNEXION</title>
    </head>
    <body>
        <header>
            <h1>Connexion</h1>
        </header>
        <div class="container">

            <p id="info"> Bienvenue sur ce site ! Pas encore de compte ? <a href="index.php">Inscrivez-Vous</a> </p>
            
            <?php 
                if(isset($_GET['error'])){
                    echo '<p id="error"> Mot de passe ou Email incorrect ! </p>';
                    
            }else if(isset($_GET['success'])){
                echo '<p id="success"> Vous êtes maintenant connectés ! ! </p>';
            }
            
             ?>

            <div id="form">
                <form action="connection.php" method="post">
                    <table>
                        <tr>
                            <td>Email :</td>
                            <td> <input name="email" type ="email" placeholder="exemple@mail.com" required/></td>
                        </tr>
                        <tr>
                            <td>Mot de Passe :</td>
                            <td> <input name="password" type ="password" autocomplete="off" placeholder="ex *********" required /></td>
                        </tr>
                    </table>
                    <p id="connexionAuto"><label ><input type="checkbox" name="connect" checked /> Connexion Automatique </label></p>
                    <div id="button">
                        <button>Se Connecter </button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>