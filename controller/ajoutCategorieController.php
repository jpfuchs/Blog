<?php

    testConnexion();

	

	//var_dump($Allauteurs);
	
	//var_dump($ALLauteurs);


	$sql = "SELECT * FROM categorie";
	$requete = $connexion->prepare($sql);

	
	$success = $requete->execute();
	// Recuperation des resultats dans une variable
	$Allcategories= $requete->fetchAll(PDO::FETCH_ASSOC);

	$erreurs = [];

	//var_dump($Allcategories);

	//var_dump($_FILES);



	if (!empty($_POST))
	{

		if ((empty($_POST['inputNom']) == TRUE) || trim($_POST['inputNom']) == ''  )
		{
		// array_push($erreurs,"Vous devez entrer un Nom");
		// autre syntaxe 
			$erreurs['inputNom'] = "Saisir le nom de la categorie";
		}


		if ((empty($_POST['inputDescription']) == TRUE) || trim($_POST['inputDescription']) == ''  )
		{
		// array_push($erreurs,"Vous devez entrer un Nom");
		// autre syntaxe 
			$erreurs['inputDescription'] = "Saisir la description de la categorie";
		}

	
		if (empty($erreurs))
		{
			$sql = "INSERT INTO categorie(nom,description)
					VALUES (:nom,:description)";
			
			//var_dump($sql);	
			//var_dump($_POST);				

			$requete = $connexion->prepare($sql);

			// le bindvalue est utilisé pour convertir le string reçu en INTEGER

			$requete->bindValue(":nom",($_POST["inputNom"]),PDO::PARAM_STR);
			$requete->bindValue(":description",($_POST["inputDescription"]),PDO::PARAM_STR);
		
			$successAddCategorie = $requete->execute();

			//var_dump($successAddArticle);
		}
	
	}