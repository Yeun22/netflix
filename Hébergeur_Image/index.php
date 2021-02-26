<?php

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){

        if($_FILES['image']['size'] <= 3000000 ){

            $informationImage = pathinfo($_FILES['image']['name']);
            $extensionImage =$informationImage['extension'];
            $extensionArray = array('jpg','gif','png','jpeg');

            if(in_array($extensionImage, $extensionArray)){
                $urlImage  = 'Upload/'.time().rand().'.'.$extensionImage;
                move_uploaded_file($_FILES['image']['tmp_name'],$urlImage );
                $messValide= "Votre image est prise en compte ! " ;
            } else{
                $urlImage = $messValide = " Votre Image est trop grande  ou l'extension est incompatible!";
            }

        }
        else{
            $urlImage = $messValide = " Votre Image est trop grande  ou l'extension est incompatible!";
        }
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hébergeur d'Image</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header style="text-align: center;">
        <h1> Bienvenue sur l'Hébergeur d'Image fonctionnant en PHP</h1>
        <div>
            <h3>Comment cela marche ? </h3>
            <p>Vous Choisissez une image sur votre ordinateur (max de 3mo) puis vous cliquer sur envoyer. Ensuite votre image s'affichera en dessous du formulaire.</p>
        </div>
    </header>

    <hr style="width:90%;" />

    <section id="envoiImage">
    
        <form  method="post" action="index.php" enctype="multipart/form-data">
            <input type="file" name="image" required /> <br>
            <button type ="submit"> Envoyer </button> <br> <br/>
            <?php

                if ($_SERVER['REQUEST_METHOD']=="POST"){
                    echo $messValide ;
                }

            ?>
        </form>

    </section>

    <hr style="width:90%;" />

    <section id="affichageImage"> 

        <?php 
        
        if ($_SERVER['REQUEST_METHOD']=="POST"){
            echo "<img style='max-width:400px;' src= $urlImage alt='une image chargée' /> <br> <br><br> ";
            echo "Lien de votre image : <a href='$urlImage' target='_blank' > cliquez-ici </a>";
        }  else{
            echo "<h3 style='text-align:center'> Votre image s'affichera ici </h3>";
        };

        ?>
    </section>

    <hr style="width:90%;" />

    <footer style="text-align : center;">
        <h3>© Yeun LE FLOCH - Projet en PHP Formation Ultime</h3>
    </footer>


</body>
</html>

