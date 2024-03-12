<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=contacts', 'root', '');


if (isset($_GET['id']) AND $_GET['id'] > 0) 
 {
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM formulaire WHERE id= ?');
    $requser->setFetchMode(PDO::FETCH_ASSOC);
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
    
?>
    <html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/profil.css?t=<?php echo time(); ?>">
        <title>tuto php</title>
    </head>
    <body>
        <div align="center">
            <h2>Profil de <?php echo $userinfo['nom']; ?></h2>
            <br /><br/>
               <div class="profil">
               <?php
                    if (!empty($userinfo['avatars'])) 
                    {
                    ?>
                        <img src="../membres/avatar/<?php echo $userinfo['avatars']; ?>" height="150">
                    <?php
                     }
                ?>
               </div>
            <br /><br/>
            Nom = <?php echo $userinfo['nom']; ?>
            <br />
             Prenom = <?php echo $userinfo['prenom']; ?>
            <br />
            Mail = <?php echo $userinfo['email']; ?>
            <br />
            
            <?php
                if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
                 {
            ?>
            <div class="liens">
                <button><a type="submit" href="message.php">Evoyez message !!</a></br></button>
                
                <button><a href="editionprofil.php"> Editer mon profil </a></br></button>
             
                <button><a type="submit" href="deconnexion.php">Se deconnecter</a></button>
            </div>
            <?php      
                 }
            ?>
        
        </div> 
    </body>
</html>
<?php
}
?>

