<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=contacts', 'root', '');

if (isset($_POST['for'])) {
    //recuperation des donnees du formulaire 
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $motdepasse1 = $_POST['motdepasse1'];
    $motdepasse2 = $_POST['motdepasse2'];
    if ($motdepaase1 == $motdepaase2) {        
    

        //insertion des donnees dans la base de donnees
        $req = $bdd->prepare('INSERT INTO formulaire (nom, prenom, email,  motdepasse) VALUES (?, ?, ?, ?)');
        $req->execute(array($nom, $prenom, $email, $motdepasse1));
            echo  " bien eregistre";
        //redirection vers la page confirmation
        header("Location:autentification.php");
    }else{
        echo "Mot de passe differents";
    }    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Inscription</title>
   
</head>
<body>
    <form  action="" method="POST">
        <label for="name">Nom :</label>
        <input type="text" id="name" name="nom" required><br><br>
        <label for="prenom">Prenom :</label>
        <input type="text" id="prenom" name="prenom" required><br><br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Mode de passe :</label>
        <input type="password" id="password" name="motdepasse1" required><br><br>
        <label for="confirm-password">Confirmation de mode passe:</label>
        <input type="password" id="confirm-password" name="motdepasse2" required><br><br>
        <button type="submit" name="for">Enregistre maintenant</button><br><br>
        <a href="page d'authentification.html">Aller a la page d'authentification</a>
    </form>
    
</body>
</html>
