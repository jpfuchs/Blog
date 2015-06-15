<?php

   

	$sql = "SELECT * FROM categorie";
	$requete = $connexion->prepare($sql);

	//$requete->bindvalue(":identifiant", $_GET["id"], PDO::PARAM_INT);
	$success = $requete->execute();
	// Recuperation des resultats dans une variable
	$categories = $requete->fetchAll(PDO::FETCH_ASSOC);

	//var_dump($categories);

