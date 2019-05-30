<?php
$results_per_page = 5; // number of results per page
// 2- Connexion à la BDD :
try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', '',
                         array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

?>