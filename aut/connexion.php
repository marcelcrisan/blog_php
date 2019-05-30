<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

require_once 'init.php';

require_once '../header.php';

if( !empty($_POST) ){
    if(isset($_POST['pseudo']) AND isset($_POST['password'])){
        $pseudo = $_POST['pseudo'] ;
        $pseudo = htmlspecialchars($pseudo) ;

        $motDePasse = $_POST['password'] ;
        $motDePasse = htmlspecialchars($motDePasse) ;
            if(($pseudo == 'marconi') AND ($motDePasse == 'admin')){
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['password'] = $motDePasse;
                
                header('Location: billets.php');
           

            }else{
                echo '<font color="red">Erreur connexion  !</font>'; 
            }

    }
}

echo '
    <form action="" method="post">
    <fieldset>
        <legend>Bienvenue, saisies le formulaire</legend>
        <label for="pseudo">Votre pseudo :</label>
        <input type="text" name="pseudo" id="pseudo">
        <label for="password">Votre mot de passe :</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Valider">
    </fieldset>
    </form>
';

require_once '../footer.php';

?>