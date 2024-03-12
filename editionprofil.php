<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=contacts', 'root', '');

if (isset($_SESSION['id'])) 
 {
    $requser = $bdd->prepare("SELECT * FROM formulaire WHERE id = ?");
    $requser->execute(array($_SESSION['id']));
    $user = $requser->fetch();
    if (isset($_POST['newnom']) AND !empty($_POST['newnom']) AND $_POST['newnom'] != $user['nom']) 
    {
        $newnom = htmlspecialchars($_POST['newnom']);
        $insertnom = $bdd->prepare("UPDATE formulaire SET nom = ? WHERE id = ?");
        $insertnom->execute(array($newnom, $_SESSION['id']));
        header("Location: profil.php?id=".$_SESSION['id']);
    }
    if (isset($_POST['newprenom']) AND !empty($_POST['newprenom']) AND $_POST['newprenom'] != $user['prenom']) 
    {
        $newprenom = htmlspecialchars($_POST['newprenom']);
        $insertprenom = $bdd->prepare("UPDATE formulaire SET prenom = ? WHERE id = ?");
        $insertprenom->execute(array($newprenom, $_SESSION['id']));
        header("Location: profil.php?id=".$_SESSION['id']);
    }

    if (isset($_POST['newemail']) AND !empty($_POST['newemail']) AND $_POST['newemail'] != $user['email']) 
    {
        $newemail = htmlspecialchars($_POST['newemail']);
        if (filter_var($newemail, FILTER_VALIDATE_EMAIL)) 
        {
            $reqmail = $bdd->prepare("SELECT * FROM formulaire WHERE email= ?");
            $reqmail->execute(array($email));
            $mailexist = $reqmail->rowcount();
            if ($mailexist === 0) 
            {
               
                $insertmail = $bdd->prepare("UPDATE formulaire SET email = ? WHERE id = ?");
                $insertmail->execute(array($newemail, $_SESSION['id']));
                header("Location: profil.php?id=".$_SESSION['id']);

            }
            else {
                echo " Cette Adresse mail a deja ete utilisee !";
            }
        }
        else 
        {
            echo "Votre Adresse mail n'est pas valide !";    
        }
    }
    if (isset($_POST['newmotdepasse1']) AND !empty($_POST['newmotdepasse1']) AND isset($_POST['newmotdepasse2']) AND !empty($_POST['newmotdepasse2'])) 
    {
        $mdp = $_POST['newmotdepasse1'];
        $mdp2 =$_POST['newmotdepasse2'];

        if ($mdp == $mdp2){
            $insertmdp= $bdd->prepare("UPDATE formulaire SET motdepasse = ? WHERE id = ?");
            $insertmdp->execute(array($mdp, $_SESSION['id']));
            header("Location: profil.php?id=".$_SESSION['id']);
        }
        else {
           echo "Vos deux mots de passes ne sont pas identiques !";
        }
    
    }
    if (isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
        $taillemax= 3097152;
        $extensionsvalides = array('jpg', 'jpeg', 'gif', 'png');
        if ($_FILES['avatar']['size'] <=$taillemax) {
            $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
            if (in_array($extensionUpload, $extensionsvalides)) {
                $chemin = "../membres/avatar/".$_SESSION['id'].".".$extensionUpload;
                $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                if ($resultat) {
                    $updateavatar = $bdd->prepare('UPDATE formulaire SET avatars = :avatar WHERE id = :id');
                    $updateavatar->execute(array(
                        'avatar' => $_SESSION['id'].".".$extensionUpload, 'id' => $_SESSION['id']));  
                    header("Location: profil.php?id=".$_SESSION['id']);
                }
                else {
                   echo "Erreur de deplacement !";
                }
            }
            else {
                echo "Votre photos de profil doit etre au format jpg, jpeg, gif ou png ";
            }
        }
        else {
            echo "Votre photos de profil ne doit pas depasser 3 MO !";
        }
    }
    if (isset($_POST['clark'])) {
        header("Location: profil.php?id=".$_SESSION['id']);
        
    }
   
?>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>tuto php</title>
        <link rel="stylesheet" href="message">
    </head>
    <body>
        <div align="center">
            <h2>Edition de mon Profil</h2>
            <div align="left">
                <form method="POST" action="" enctype="multipart/form-data">
                    <label>Nom:</label>
                    <input type="text" name="newnom" placeholder="Votre nom" value="<?php echo $user['nom']; ?>"/><br /><br />
                    <label>Prenom:</label>
                    <input type="text" name="newprenom" placeholder="Votre prenom" value="<?php echo $user['prenom']; ?>"/><br /><br />
                    <label>Mail :</label>
                    <input type="email" name="newemail" placeholder="Mail"  value="<?php echo $user['email']; ?>" /><br /><br />
                    <label>Mot de passe :</label>
                    <input type="password" name="newmotdepasse1" placeholder="Mot de passe"><br /><br />
                    <label>Confirmation de mot de passe :</label>
                    <input type="password" name="newmotdepasse2" placeholder="Confirmation du mot de passe"><br /><br />
                    <label>Avatar :</label>
                    <input type="file" name="avatar" /> <br /><br /> 
                    <input type="submit" value="Mettre a jour mon profil !" name="clark">
                    <input type="submit" name="clark" value="Annuler !!">
                </form>
               
            </div>
            
        </div> 
    </body>
</html>
<?php
}
else {
    header("Location: autentification.php");
}
?>

