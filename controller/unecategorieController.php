<?php



	$sql = "SELECT * FROM article WHERE id_categorie = :identifiant";
	$requete = $connexion->prepare($sql);

	$requete->bindvalue(":identifiant", $_GET["id"], PDO::PARAM_INT);
	$success = $requete->execute();
	// Recuperation des resultats dans une variable
	$unecategorie = $requete->fetchAll(PDO::FETCH_ASSOC);

	//var_dump($unecategorie);