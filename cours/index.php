
<?php
    if(!empty($_POST['pseudo'])){

        $pseudo = $_POST['pseudo'];

        setcookie("pseudo", $pseudo, time()+365*24*2600);


    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>
</head>
<body>
    
    <h1> Entrer votre pseudo </h1>

    <form method="post" action='index.php'>

        <table>
            <tr>
                <td>Pseudo : </td>
                <td><input type="text" name="pseudo"/></td>
            </tr>
        </table>

        <button type="submit">Se connecter</button>


    </form>

        <?php 
        
            
        
        ?>

</body>
</html>