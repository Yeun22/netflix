<?php 
    try{
        $bdd = new PDO ('mysql:host=localhost;dbname=formation_php;charset=utf8','root','');
    } catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }



    //AJOUT UN UTILISATEUR

    //$requete  = $bdd->exec('INSERT INTO users (prenom, nom, series_preferee) VALUES ("Mark","Zuckerberg","hoholanta")') or die(print_r($bdd->errorInfo()));

    //MODIFIER UN USER

    //$requete  = $bdd->exec('UPDATE users SET series_preferee="les feux de l\'amour" WHERE prenom ="Mark"');

    //SUPPRIMER UN USER
    //$requete  = $bdd->exec('DELETE FROM users WHERE prenom ="Mark"');

    //AJOUT DANS UN METIER 
   // $requete  = $bdd->exec('INSERT INTO jobs (id_user,metier) VALUES (1,"Garagiste"),(2,"Danseuse"),(3,"DevWeb"),(4,"PDG")') or die(print_r($bdd->errorInfo()));


    //LIRE DES INFOS : 
   // $requete  = $bdd->query('SELECT prenom, nom, series_preferee, metier FROM users INNER JOIN jobs ON users.id = jobs.id_user');
   $requete  = $bdd->prepare('SELECT prenom, nom, series_preferee, metier FROM users LEFT JOIN jobs ON users.id = jobs.id_user');

    $requete->execute(array());

    echo '<table border> 
                    <tr>
                        <th> Pseudo </th>
                        <th> Nom </th>
                        <th> Série Préférée </th>
                        <th> Mot De Passe </th>

                    </tr>
                ';

    while($donnes= $requete->fetch()){
        echo '
                    <tr>
                        <td>'. $donnes['prenom'] .'</td>
                        <td>'. $donnes['nom'] .'</td>
                        <td>'. $donnes['series_preferee'] .'</td>
                        <td>'.sha1( $donnes['metier']) .'f856'.'</td>
                    </tr>';
                            //Mot de passe crypté 
                            // GRAIN DE SEL (ex: f856)
                            // Mot de passe + grain de sel.
        
    }

    $requete->closeCursor();
    echo '</table>';

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>
</head>
<body>
    


</body>
</html>