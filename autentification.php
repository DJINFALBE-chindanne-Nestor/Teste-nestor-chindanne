<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=contacts', 'root', '');

    if (isset($_POST['con'])) {

        $mailconnect = htmlspecialchars($_POST['auth-email']);
        $mdpconnect =$_POST['auth-password'];
        if(!empty($mailconnect) AND !empty($mdpconnect))
        {
            $requser = $bdd->prepare("SELECT * FROM formulaire WHERE email= ? AND motdepasse= ?");
            $requser->execute(array($mailconnect,$mdpconnect));
            $userexist = $requser->rowcount();
            if($userexist == 1)
            {
                $userinfo = $requser->fetch();
                $_SESSION['id'] = $userinfo['id'];
                $_SESSION['nom'] = $userinfo['nom'];
                $_SESSION['mail'] = $userinfo['mail'];
                header("Location: profil.php?id=".$_SESSION['id']);

            }
            else 
            {
                echo  "Mauvais mail ou mot de passe incorrect !";
            }
        }
        else {
            echo "Tous les champs doivent etres completer !";
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Authentification de la page</title>
</head>
<body>
    <form action="" method="POST">
        <label for="auth-email">Email :</label>
        <input type="email" id="auth-email" name="auth-email" required><br>
        <label for="auth-password">Mode de passe:</label>
        <input type="password" id="auth-passwor" name="auth-password" required><br>
        <button type="submit" name="con">Se connecter</button>
       
    </form> 
</body>
</html>