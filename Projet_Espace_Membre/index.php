<?php 
    session_start();

                            //INSCRIPTION

    require_once('src/connectBase.php');


    if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['passwordConfirm'])){
        //Variables :
        $pseudo       =   $_POST['pseudo'];
        $email        =   $_POST['email'];
        $password     =   $_POST['password'];
        $passConfirm  =   $_POST['passwordConfirm'];

        //Test password ok
        if($password != $passConfirm){
            header('location: index.php?error=1&pass=1'); //requête en get
            exit();
        }

        //Test email existe déjà 
        $req = $db->prepare('SELECT COUNT(*) AS numberEmail FROM users WHERE email = ?');
        $req->execute(array($email));
        while ($email_verification = $req->fetch()){
            if($email_verification['numberEmail'] !=0){
                header('location: index.php?q=error=1&email=1');
                exit();
            }
        }

        //HASH du secret
        $secret = sha1($email).time();
        $secret = sha1($secret).time().time();

        //Cryptage du password
        $password = "vz35".sha1($password.f1d56)."z5f"; 

        //Envoi de la requete 
        $req = $db->prepare('INSERT INTO users (pseudo, email, password, secret) VALUES (?,?,?,?)');
        $req->execute(array($pseudo, $email, $password, $secret));
        header('location: index.php?success=1');
        exit();

    }



?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel ="stylesheet" type="text/css" href="design/default.css">
        <title>Projet Espace Membre | INSCRIPTION</title>
    </head>
    <body>
        <header>
            <h1>Inscription</h1>
        </header>
    
        <div class="container">

        <?php  if(!isset($_SESSION['connect'])){ ?>
            
            <p id="info"> Bienvenue sur ce site ! Pour en voir plus , inscrivez-vous ! vous avez déjà un compte ? <a href="connection.php">Connectez-Vous</a> </p>
            
            <?php 
                if(isset($_GET['error'])){
                    if(isset($_GET['pass'])){
                        echo '<p id="error"> Les mots de passe ne sont pas identiques ! </p>';
                    } else if(isset($_GET['email'])){
                        echo '<p id="error"> Cette Adresse email est déjà utilisée !! </p>';
                    }
            }else if(isset($_GET['success'])){
                echo '<p id="success"> Votre Inscription au site a bien été prise en compte ! </p>';
            }
            
             ?>

            <div id="form">
                <form action="index.php" method="post">
                    <table>
                        <tr>
                            <td>Pseudo :</td>
                            <td> <input name="pseudo" type ="text" placeholder="ex: Hervé " required/></td>
                        </tr>
                        <tr>
                            <td>Email :</td>
                            <td> <input name="email" type ="email" placeholder="exemple@mail.com" required/></td>
                        </tr>
                        <tr>
                            <td>Mot de Passe :</td>
                            <td> <input name="password" type ="password" autocomplete="off" required placeholder="ex *********"/></td>
                        </tr>
                        <tr>
                            <td>Confirmer le Mot de passe :</td>
                            <td> <input name="passwordConfirm" type ="password" autocomplete="off" required placeholder="ex :  *********"/></td>
                        </tr>
                    </table>
                    <div id="button">
                        <button>S'inscrire </button>
                    </div>
                </form>
            </div>
            <?php } else { ?>
                <p id="info"> Bonjour <?= $_SESSION['pseudo'] ?> <br> 
                
                <a href="disconnection.php">Deconnexion</a>
                </p>

           <?php  } ?>
        </div>
    </body>
</html>