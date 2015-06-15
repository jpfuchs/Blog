<?php


	function getLittleDescription($texte, $nbchar = 200)
	{

		return (strlen($texte) > $nbchar ? substr(substr($texte,0,$nbchar),0,strrpos(substr($texte,0,$nbchar)," "))."..." : $texte);
	}

	

	$sql="SELECT count(*) as nb FROM article";
	$requete = $connexion->prepare($sql);
	$success = $requete->execute(); // On s'arrete ici si requete INSERT/UPDATE/DELETE

	
	// Recuperation des resultats dans une variable
	$Articles = $requete->fetch(PDO::FETCH_ASSOC);
	//$tousLesEtudiants = $requete->fetchColumn();

	//var_dump($Articles);

	$nbPage= ceil($Articles["nb"]/3);

   //echo $nbPage;


if (array_key_exists("nombre", $_GET))
	{
				
		//var_dump($_GET);

	
	/*$dsn = "mysql: host=localhost;dbname=blogtroiswa;charset=utf8";
	$login="root";
	$motDePasse = "troiswa";
	$connexion = new PDO($dsn, $login, $motDePasse);

	//Afiichage des erreurs
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);*/

	//$sql="SELECT *  FROM article";

	$sql = "SELECT article.id, titre, description, auteur.nom AS auteur, date_ajout, image
	FROM  `article` 
	INNER JOIN auteur ON auteur.id = article.id_auteur  LIMIT :startLimit,:endLimit";

	$total=3;
	$nbVar = intval(3 * ($_GET["nombre"]-1));

	$requete = $connexion->prepare($sql);

	$requete->bindvalue(":startLimit", $nbVar, PDO::PARAM_INT);
	$requete->bindvalue(":endLimit", $total, PDO::PARAM_INT);


	
	$success = $requete->execute(); // On s'arrete ici si requete INSERT/UPDATE/DELETE

	
	// Si requete select :

	// FetchAll-> plusieurs resultats
	// Fetch -> 1 seul resultat
	// FetchColumn() -> retourne le resultat directement

	//$requete->bindValue(":nombre",intval($_GET["nombre"]),PDO::PARAM_INT);

	// Recuperation des resultats dans une variable
	$tousLesArticles = $requete->fetchAll(PDO::FETCH_ASSOC);
	//var_dump($tousLesArticles);


	}

	//echo $nbPage;