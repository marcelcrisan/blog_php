<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();
require_once 'aut/init.php';

require_once 'header.php';
?>
<!--  
    <form action="connexion.php">
            <input type="submit" value="Connexion">
        </form>
-->
<?php

if(isset($_GET["page"])){
    $page = $_GET["page"];
}else{
    $page = 1;
};
$results_per_page = 5; // number of results per page
$start_from = (($page-1) * $results_per_page);

echo '<h1>Mon super blog !</h1>
        <p>Derniers billets du blog :</p>';
$blog = $bdd->query('SELECT id, title, content, author, DATE_FORMAT(creation_date, "%d/%m/%Y") AS date_year, DATE_FORMAT(creation_date, "%Hh%imin%ss") AS date_hour FROM posts ORDER BY id DESC LIMIT '.$start_from.','.$results_per_page.'');
                                    
            while ($donnees = $blog->fetch()){
                echo '<h2>' . $donnees['title'] . ' </h2><h6>le ' . $donnees['date_year'] . ' à ' . $donnees['date_hour'] . ' article publié par <em>' . $donnees['author'] . '</em></h6> <p>' . $donnees['content'] . 
                        ' </p> <a href="commentaires.php?id=' . $donnees['id'] . ';" alt="Laissez un commentaire" title="Laissez un commentaire"><em>Commentaires</em></a> ';
                        //$_SESSION['id_billet'] = $donnees['id'];
                         //?id=' . $donnees['id'] . ';         
                         //echo $_SESSION['id_billet'];       
                     }
            $blog->closeCursor();
$result = $bdd->query('SELECT COUNT(id) AS total FROM posts');
$row = $result->fetch();
$total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
for ($i=1; $i<=$total_pages; $i++) {// print links for all pages
    echo "<div><a href='index.php?page=".$i."'>".$i."</a></div>";
}

require_once 'footer.php';
?>
