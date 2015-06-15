<?php

    testConnexion();

	$sql = "SELECT * FROM auteur";
	$requete = $connexion->prepare($sql);

	
	$success = $requete->execute();
	// Recuperation des resultats dans une variable
	$Allauteurs= $requete->fetchAll(PDO::FETCH_ASSOC);

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

		if ((empty($_POST['inputTitre']) == TRUE) || trim($_POST['inputTitre']) == ''  )
		{
		// array_push($erreurs,"Vous devez entrer un Nom");
		// autre syntaxe 
			$erreurs['inputTitre'] = "Saisir le Titre de l'article";
		}


		if ((empty($_POST['inputDescription']) == TRUE) || trim($_POST['inputDescription']) == ''  )
		{
		// array_push($erreurs,"Vous devez entrer un Nom");
		// autre syntaxe 
			$erreurs['inputDescription'] = "Saisir la description";
		}

		

		if ((empty($_POST['inputDate']) == TRUE) || trim($_POST['inputDate']) == ''  )
		{
		// array_push($erreurs,"Vous devez entrer un Nom");
		// autre syntaxe 
			$erreurs['inputDate'] = "Saisir la date ";
		}

		

		if ((empty($_POST['inputCategorie']) == TRUE) || trim($_POST['inputCategorie']) == ''  )
		{
		// array_push($erreurs,"Vous devez entrer un Nom");
		// autre syntaxe 
			$erreurs['inputCategorie'] = "Inserer une categorie";
		}

		
		if ( empty($_FILES["inputImage"]) || ($_FILES["inputImage"]["error"] != 0) )
		{
			$erreurs['inputImage'] = "Saisir une image";
		}
		else
		{ 
			// autre facon de tester le code ci dessous
			$extensionsValides = ["jpeg","jpg","png"];
			$extensionImage = str_replace("image/", "", $_FILES["inputImage"]["type"]);
		 
		 	if (!in_array($extensionImage,  $extensionsValides))
		 	{
		 		$erreurs['inputImage'] = "Saisir uniquement des formats d'image jpeg, png, gif";
		 	}

			/*if (($_FILES["inputImage"]["type"] == 'image/png') || ($_FILES["inputImage"]["type"] == 'image/jpeg'))
			{
			   $img = getimagesize($_FILES["inputImage"]["tmp_name"]);
			  // var_dump($img);

			   if ( $img["0"] > 200  || $img["1"] > 400)
			   {
			   		$erreurs['inputImage'] = "Saisir uniquement une image plus petite";
			   } 

			}
			else
			{    
			$erreurs['inputImage'] = "Saisir uniquement des formats d'image jpeg, png, gif";
			}*/

   		}
   		
   		$nameImage = uniqid().".".$extensionImage;
   		

   		if (empty($erreurs))
   		{
   			//$successMove = move_uploaded_file($_FILES["inputImage"]["tmp_name"], "vue/images/".$_FILES["inputImage"]["name"]);

   			$successMove = move_uploaded_file($_FILES["inputImage"]["tmp_name"], "vue/images/".$nameImage);
   			

			if ($successMove)
			{
				$sql = "INSERT INTO article(titre,description,date_ajout,image,id_auteur,id_categorie)
				VALUES (:titre,:description,:date_ajout,:image,:id_auteur,:id_categorie)";
			
				//var_dump($sql);	
				//var_dump($_POST);				

				$requete = $connexion->prepare($sql);

				// le bindvalue est utilisé pour convertir le string reçu en INTEGER

				$requete->bindValue(":titre",($_POST["inputTitre"]),PDO::PARAM_STR);
				$requete->bindValue(":description",($_POST["inputDescription"]),PDO::PARAM_STR);
				$requete->bindValue(":date_ajout",($_POST["inputDate"]),PDO::PARAM_STR);
		
				//$requete->bindValue(":image",($_FILES["inputImage"]["name"]),PDO::PARAM_STR);
				$requete->bindValue(":image",$nameImage,PDO::PARAM_STR);


				$requete->bindValue(":id_auteur",intval($_POST["inputAuteur"]),PDO::PARAM_INT);
				$requete->bindValue(":id_categorie",intval($_POST["inputCategorie"]),PDO::PARAM_INT);
		
				$successAddArticle = $requete->execute();

				
			}
			else
			{ 	
				$erreurs['inputImage'] = "Probleme d'upload d'image";
				
			}

		}
}