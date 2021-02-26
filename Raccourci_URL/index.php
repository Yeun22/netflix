<?php

//SHORTCUT EXIST ?

    if(isset($_GET['q'])){
        $shortcut = htmlspecialchars($_GET['q']);

        $bdd = new PDO('mysql:host=localhost;dbname=bitly;charset=utf8','root','');

        $req = $bdd->prepare('SELECT COUNT(*) AS x FROM links WHERE shortcut = ?');

        $req->execute(array($shortcut));

            while($result = $req->fetch()){
                if($result['x'] != 1 ){
                    header('Location: ../?error=true&message=Adresse URL non connue');
                }
                exit();
        }

            //REDIRECTION
            $req = $bdd->prepare('SELECT * FROM links WHERE shortcut=?');
            $req->execute(array($shortcut));

            while($result = $req->fetch()){
                header('location: '.$result['url']);
                exit();
}

    }

   

//IS SENDING A FORM
    if(!empty($_POST['url'])){
        $url = $_POST['url'];


        //VERIFICATION URL
        if(!filter_var($url, FILTER_VALIDATE_URL)){ 
            //Not a link
            header('Location: ../?error=true&message=Adresse URL non valide');
            exit();
        }

        //SHORTCUT 

        $shortcut = crypt($url, rand());

        //HAS BEEN ALREADY SEND ?
        
            $bdd = new PDO('mysql:host=localhost; dbname=bitly;charset=utf8','root','');
            $req = $bdd->prepare('SELECT COUNT (*) AS x FROM links WHERE url = ?');
            $req->execute(array($url));

            while($result = $req->fetch()){
                if($result['x'] !=0 ){
                    header('Location: index.php/?error=true&message=Adresse déjà raccourcie');
                    exit();
                }
            }

        //SENDING 
           $req = $bdd->prepare('INSERT INTO links(url, shortcut)  VALUES (?, ?)');

           $req->execute(array($url,$shortcut));

           header('location: ./?short='.$shortcut);
           exit();

    }

        

?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="design/default.css">
        <link rel ="icon" type="img/png" href="pictures/favico.png">
        <title>Raccourcisseur d'URL express | Propulsé par Yeun LE FLOCH</title>
    </head>
    <body>

        <section id="hello">
            <div class="container">
                <header>
                    <img src="pictures/logo.png" id="logo" alt="logo" />
                </header>

                <h1>Une url longue ? Raccourcissez-là !</h1>
                <h2>Largement meilleur et pourtant plus court que les autres</h2>
            
                <form method="post" action="index.php">
                    <input type="url" name="url" placeholder="Collez un lien à raccourcir ici ..." />
                     <input type="submit" value="raccourcir">
                </form>
            
                <?php 
                    if (isset($_GET["error"]) && isset($_GET["message"])){  ?>

                        <div class="center">
                            <div id="result">
                                <?php echo htmlspecialchars($_GET["message"]); ?>
                            </div>
                        </div>


                   <?php }else if(isset($_GET["short"])){ ?>
                    <div class="center">
                            <div id="result">
                               URL RACCOURCIE : https://?q=<?php echo htmlspecialchars($_GET["short"]); ?>
                            </div>
                        </div>
                  <?php } ?>
            
            </div>
        </section>

        <section id="brands">
            <div class="container">

                <h3> Ces marques nous font confiance</h3>

                <img src="pictures/1.png" class="picture" alt="marque1"/>
                <img src="pictures/2.png" class="picture" alt="marque2"/>
                <img src="pictures/3.png" class="picture" alt="marque3"/>
                <img src="pictures/4.png" class="picture" alt="marque4"/>


            </div>
        </section>

        <footer>
            <div class="container">

                <img src="pictures/logo2.png" id="logo" alt="logo" /><br>
                2020 © Bitly <br>
                <a href="#">A Propos</a> - <a href="#"> Contact</a>

            </div>
        </footer>

    </body>
</html>