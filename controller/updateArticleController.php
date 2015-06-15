<?php



	//var_dump($_GET);



	if (array_key_exists("id", $_GET) ==false)
	{
		

		header("Location:index.php");
		die();
	}



	$sql = "SELECT * FROM article WHERE id = :identifiant";
	$requete = $connexion->prepare($sql);

	$requete->bindvalue(":identifiant", $_GET["id"], PDO::PARAM_INT);
	$success = $requete->execute();
	// Recuperation des resultats dans une variable
	$article = $requete->fetch(PDO::FETCH_ASSOC);
	var_dump($article);

	if (empty ($article))
	{
		header("Location:index.php");
		die();
	}

	/*$sql = "SELECT auteur.nom AS nom_auteur FROM  `article` 
			INNER JOIN auteur ON auteur.id = article.id_auteur and article.id= :identifiant";*/


	$sql = "SELECT * FROM  `auteur`";

	$requete = $connexion->prepare($sql);
	$requete->bindvalue(":identifiant", $_GET["id"], PDO::PARAM_INT);
	$success = $requete->execute();
	// Recuperation des resultats dans une variable
	$auteur = $requete->fetchAll(PDO::FETCH_ASSOC);

	//var_dump($auteur);

	if (empty ($auteur))
	{
		header("Location:index.php");
		die();
	}
	


	/*$sql = "SELECT categorie.nom as nom_categorie FROM article 
      INNER JOIN categorie ON categorie.id=article.id_categorie and article.id= :identifiant";*/

      $sql = "SELECT * FROM `categorie`";

	$requete = $connexion->prepare($sql);
	$requete->bindvalue(":identifiant", $_GET["id"], PDO::PARAM_INT);
	$success = $requete->execute();
	// Recuperation des resultats dans une variable
	$categorie = $requete->fetchAll(PDO::FETCH_ASSOC);

	//var_dump($categorie);

	if (empty ($categorie))
	{
		header("Location:index.php");
		die();
	}
	


var_dump($_POST);



$erreurs = [];

if (!empty($_POST))
{
	if ((empty($_POST['inputTitre']) == TRUE) || trim($_POST['inputTitre']) == ''  )
	{
		array_push($erreurs,"Saisir le Titre de l'article");
	}

	if ((empty($_POST['inputDescription']) == TRUE) || trim($_POST['inputDescription']) == ''  )
	{
		array_push($erreurs,"Saisir la description"); 
	}

	if ((empty($_POST['inputDate']) == TRUE) || trim($_POST['inputDate']) == ''  )
	{
		array_push($erreurs,"Saisir la date");
	}

	if ((empty($_POST['inputAuteur']) == TRUE) || trim($_POST['inputAuteur']) == ''  )
	{
		array_push($erreurs,"Inserer un Auteur"); 
	}

	if ((empty($_POST['inputCategorie']) == TRUE) || trim($_POST['inputCategorie']) == ''  )
	{
		array_push($erreurs, "Inserer une categorie");
	}


	var_dump($_FILES);


	//var_dump($erreurs);

	if(!empty($_FILES['inputImage']) && ($_FILES['inputImage']['error'] == 0))  // == 0 c a d 
	{
		
		$extensionsValides = ["jpeg","jpg","png"];
		$extensionImage = str_replace("image/","",$_FILES['inputImage']['type']);	

		if(!in_array($extensionImage, $extensionsValides))
		{
			array_push($erreurs, "Inserer une Image de type jpeg, jpg ou png");
		}	
	}


	var_dump($erreurs);


	if (empty($erreurs) == TRUE)
	{
		$nameImage = $article['image'];	// 1) on sauvegarde l'ancienne image dans la variable	
			
		if(!empty($_FILES['inputImage']) && ($_FILES['inputImage']['error'] == 0)) // 2) une nouvelle image est saisie
		{
			
			// file_exists et unlink et le move_uploaded_file
			// unlink   enleve l'ancienne image du repertoire

			//$nameImage  = $_FILES['inputImage']['name'];

			$nameImage = uniqid().".".$extensionImage;	
			
			$successMove = move_uploaded_file($_FILES['inputImage']['tmp_name'],"vue/images/".$nameImage);
			
			if($successMove == false)
			{
				array_push($erreurs, "probleme de fichier");
			}
			
			//$nameImage = uniqid().".".$extensionImage;	
		}


		var_dump($erreurs);
		if (empty($erreurs) == TRUE)
		{

		// UPDATE
			$sql ="UPDATE article SET titre=:titre,description=:description,date_ajout=:date_ajout,image=:image,
	            					id_auteur=:id_auteur,id_categorie=:id_categorie WHERE id=:idArticle";
			
			$requete = $connexion->prepare($sql);


			$requete->bindValue(":idArticle",intval($article["id"]),PDO::PARAM_INT);
			$requete->bindValue(":titre",($_POST["inputTitre"]),PDO::PARAM_STR);
			$requete->bindValue(":description",($_POST["inputDescription"]),PDO::PARAM_STR);
			$requete->bindValue(":date_ajout",($_POST["inputDate"]),PDO::PARAM_STR);
			
			$requete->bindValue(":image",$nameImage,PDO::PARAM_STR);
			
			$requete->bindValue(":id_auteur",intval($_POST["inputAuteur"]),PDO::PARAM_INT);
			$requete->bindValue(":id_categorie",intval($_POST["inputCategorie"]),PDO::PARAM_INT);
			
			$successUpdateArticle = $requete->execute();

			var_dump($successUpdateArticle);


			if($successUpdateArticle)		// le UPDATE de la table s'est bien passé donc
			{								// on enleve l'acienne image du repertoire d'images
				
				$successRemove = unlink("vue/images/".$article['image']);
			}	

			var_dump($successRemove);

		}


	}


}