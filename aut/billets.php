<?php

session_start();

require_once 'init.php';
require_once '../header.php';

echo '<p> Bonjour <em>' . $_SESSION['pseudo'] . '</em> !</p>' ;

if( !empty($_POST) ){
                    
    if(isset($_POST['titre']) AND isset($_POST['contenu'])){
        $titre = $_POST['titre'] ;
        $titre = htmlspecialchars($titre) ;
        $contenu = $_POST['contenu'] ;
        $contenu = htmlspecialchars($contenu) ;
        $req = $bdd->prepare('INSERT INTO billets(titre, contenu, date_creation, auteur) VALUES(:titre, :contenu, NOW(), :auteur)');
        $req->execute(array(
            'titre' => $titre,
            'contenu' => $contenu,
            'auteur' => $_SESSION['pseudo'],
            ));
            echo '<font color="green">Votre post a été partagé !</font>';
            header('Location: billets.php');
        }else{
            echo '<font color="red">Erreur  !</font>'; 
        }

               
}

echo '
    <form action="" method="post">
    <fieldset>
        <legend>Votre nouvelle histoire</legend>
        <label for="titre">Titre :</label>
        <input type="text" name="titre" id="titre">
        <label for="contenu">Contenu :</label>
        <textarea name="contenu" rows="20" cols="50"></textarea>
        <input type="submit" value="Partager">
    </fieldset>
    </form>
    <br>
    <h2>Déjà partagé :</h2>

';
$blog = $bdd->query('SELECT titre, contenu, auteur, DATE_FORMAT(date_creation, "%d/%m/%Y") AS date_year, DATE_FORMAT(date_creation, "%Hh%imin%ss") AS date_hour FROM billets ORDER BY id DESC');
                                    
            while ($donnees = $blog->fetch()){
                echo '<h1>' . $donnees['titre'] . ' </h1><h6>le ' . $donnees['date_year'] . ' à ' . $donnees['date_hour'] . ' article publié par <em>' . $donnees['auteur'] . '</em></h6> <p>' . $donnees['contenu'] . ' </p>';
        
                                       
                                    
                     }
            $blog->closeCursor();

require_once '../footer.php';

?>