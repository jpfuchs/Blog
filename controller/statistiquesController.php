<?php 


 // var_dump($_SESSION);



    testConnexion();


    $sql = "SELECT  count(*) as nb FROM article";
    $requete = $connexion->prepare($sql);

    //$requete->bindvalue(":identifiant", $_GET["id"], PDO::PARAM_INT);
    $success = $requete->execute();
    // Recuperation des resultats dans une variable
    //$nbarticles = $requete->fetchColumn();
    //echo $nbarticles;
    // ou requete equivalente quand on ramene un seul nombre
	$nbarticles = $requete->fetch(PDO::FETCH_ASSOC);
    //var_dump($nbarticles);


    $sql = "SELECT  count(*) as nb FROM categorie";
    $requete = $connexion->prepare($sql);

    //$requete->bindvalue(":identifiant", $_GET["id"], PDO::PARAM_INT);
    $success = $requete->execute();
    // Recuperation des resultats dans une variable
    //$nbarticles = $requete->fetchColumn();
    //echo $nbarticles;
    // ou requete equivalente quand on ramene un seul nombre
    $nbcategories = $requete->fetch(PDO::FETCH_ASSOC);



//Meilleur article (note)
$sql="SELECT article.id,titre,MAX(note) as note FROM article 
      INNER JOIN commentaire ON commentaire.id_article=article.id 
      GROUP BY article.id,titre ORDER BY note,titre DESC LIMIT 1";


   $requete = $connexion->prepare($sql);

    //$requete->bindvalue(":identifiant", $_GET["id"], PDO::PARAM_INT);
    $success = $requete->execute();
    // Recuperation des resultats dans une variable
    //$nbarticles = $requete->fetchColumn();
    //echo $nbarticles;
    // ou requete equivalente quand on ramene un seul nombre
    
    $goodArt = $requete -> fetch(PDO::FETCH_ASSOC); 

//var_dump($goodArt);

$var1   =  $goodArt['titre']; 
$var2=  $goodArt['note']; 


//Meilleur categorie(meilleur moyenne des notes)
$sql="SELECT article.id,categorie.nom,AVG(note) as noteMoyenne FROM article 
      INNER JOIN commentaire ON commentaire.id_article=article.id
      INNER JOIN categorie ON categorie.id=article.id_categorie 
      ORDER BY noteMoyenne DESC,nom LIMIT 1";

$requete = $connexion->prepare($sql);    
$requete->execute(); 

$goodCategorie = $requete -> fetch(PDO::FETCH_ASSOC); 

$var3       =  $goodCategorie['nom']; 
$var4   =  $goodCategorie['noteMoyenne']; 




//article/categorie
$sql="SELECT categorie.nom,count(*) as nbreArticles FROM article 
      INNER JOIN categorie ON categorie.id=article.id_categorie 
      GROUP BY categorie.nom
      ORDER BY nbreArticles DESC";

/*
$sql="SELECT categorie.nom,count(*) as nbreArticles FROM article,categorie 
      WHERE categorie.id=article.id_categorie 
      GROUP BY categorie.nom ORDER BY nbreArticles DESC";
*/


$requete = $connexion->prepare($sql);    
$requete->execute(); 

$nbreArticlesCategorie = $requete -> fetchAll(PDO::FETCH_ASSOC); 



