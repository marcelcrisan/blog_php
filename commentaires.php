<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();
require_once 'aut/init.php';

require_once 'header.php';

echo '<h1>Mon super blog !</h1>
        <a href="index.php" alt="retour a la liste des billets" title="Accueil blog">Retour à la liste des billets</a>';
        $id_billet = $_GET['id'];
        $id_billet = htmlspecialchars($id_billet);  

      
        //$id_billet = $_SESSION['id_billet'];
       // echo $id_billet;

        $id_req = $bdd->query("SELECT MAX(id) AS last_id FROM billets");
        $id_max = $id_req->fetch();
        //echo $id_max['last_id'];           
        $id_req->closeCursor();
        if(($id_billet < ($id_max['last_id']+1) ) AND ($id_billet > 0)){


                $blog = $bdd->prepare("SELECT id, titre, contenu, auteur, DATE_FORMAT(date_creation, '%d/%m/%Y') AS date_year, DATE_FORMAT(date_creation, '%Hh%imin%ss') AS date_hour FROM billets WHERE id = $id_billet");
                            $blog->execute();                       
                            while ($donnees = $blog->fetch()){
                                echo '<h2>' . $donnees['titre'] . ' </h2><h6>le ' . $donnees['date_year'] . ' à ' . $donnees['date_hour'] . ' article publié par <em>' . $donnees['auteur'] . '</em></h6> <p>' . $donnees['contenu'] . 
                                        ' </p> <h3>Commentaires</h3>';
                        
                                       
                                        
                      
                                       // echo $id_billet;                
                                    }
                            $blog->closeCursor();
                            
            if( !empty($_POST) ){
                
                
                    
                if(isset($_POST['auteur']) AND isset($_POST['commentaire'])){
                    $auteur = $_POST['auteur'] ; 
                    $auteur = htmlspecialchars($auteur) ;
                    $commentaire = $_POST['commentaire'] ;
                    $commentaire = htmlspecialchars($commentaire) ;
                  
                    // Insertion du commentaire à l'aide d'une requête préparée
                    //$req = $bdd->prepare('INSERT INTO commentaires (id, id_billet, auteur, commentaire, date_commentaire) VALUES(NULL, ?, ?, ?, NOW())');
                    //$req->execute(array($id_billet, $auteur , $commentaire));

                    // Redirection du visiteur vers la page du commentaires
                    //header('Location: commentaires.php');
/*
                    echo $id_billet;
                    echo $auteur;
                    echo $commentaire; */

                    $billet_id = (int)$id_billet;
                   // Insertion du commentaire à l'aide d'une requête préparée

                  $req = $bdd->prepare("INSERT INTO commentaires (id, id_billet, auteur, commentaire, date_commentaire) VALUES (NULL, $billet_id, '$auteur', '$commentaire', NOW() )");

 /*                  
                    $req->bindParam(':id_billet', $donnees['id']);
                    $req->bindParam(':auteur', $auteur);
                    $req->bindParam(':commentaire', $comm);  */
                  $req->execute(); 
  /*

                    $req->execute(array(
                       'id_billet' => $donnees['id'],
                        'auteur' => $auteur,
                        'commentaire' => $_POST['commentaire'],
                        ));*/
                        //echo '<font color="green">Votre commentaire a été partagé ! Merci !</font>';
                        
                        // Redirection du visiteur vers la page d'accueil
                     //header('Location: index.php');
                     //sleep(2);

                     echo "<script>alert('Votre commentaire a été partagé ! Merci !');</script>";
                    echo "<script>document.location.href='index.php'</script>";
                    }else{
                        echo '<font color="red">Erreur  !</font>'; 
                    }
            
                           
            }
        }else{
            echo '<font color="red">Erreur  !</font>'; 
        }
       
            echo '
                <form action="" method="post">
                <fieldset>
                    <legend>Votre commentaire :</legend>
                    <label for="auteur">Votre pseudo :</label>
                    <input type="text" name="auteur" id="auteur">
                    <label for="commentaire">Commentaire :</label>
                    <textarea name="commentaire" id="commentaire" rows="10" cols="30"></textarea>
                    <input type="submit" value="Publier">
                </fieldset>
                </form>
                <br>
                <h2>Autres commentaires :</h2>
            
            ';
            $comm = $bdd->query("SELECT id_billet, auteur, commentaire, DATE_FORMAT(date_commentaire, '%d/%m/%Y') AS date_year, DATE_FORMAT(date_commentaire, '%Hh%imin%ss') AS date_hour FROM commentaires WHERE id_billet = $id_billet ORDER BY id DESC");
                                                
                        while ($donnees1 = $comm->fetch()){
                            echo '<p><strong>' . $donnees1['auteur'] . '</strong>  le ' . $donnees1['date_year'] . ' à ' . $donnees1['date_hour'] . '</p> <p>' . $donnees1['commentaire'] . ' </p>';
                    
                                                   
                                                
                                 }
                        $comm->closeCursor(); 
require_once 'footer.php';
?>