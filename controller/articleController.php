<?php


	function getLittleDescription($texte, $nbchar = 200)
	{

		return (strlen($texte) > $nbchar ? substr(substr($texte,0,$nbchar),0,strrpos(substr($texte,0,$nbchar)," "))."..." : $texte);
	}



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
	//var_dump($article);

	if (empty ($article))
	{
		header("Location:index.php");
		die();
	}

	//var_dump($_POST);


	// Informations du formulaire soumises
	if ( !empty($_POST) == true )   
	{
		$erreurs = array();
			

		if (array_key_exists("nom", $_POST) == true)
		{	
			// on peut mettre aussi comme test:  if (empty($_POST["nom"] )
			if (trim($_POST["nom"]) == '')
			{	
				$messageErreur = "Vous devez entrer un nom ! ";
				array_push($erreurs, $messageErreur);  // on peut mettre aussi: $erreurs["nom"]= "blabla"
			}
		}

		if (array_key_exists("note", $_POST) == true)
		{

			if (($_POST["note"] < 0) or ($_POST["note"] > 5 or trim($_POST["note"]) == '' )) 
			{
				$messageErreur = "Vous devez entrer une note compris entre 0 et 5 ! ";
				array_push($erreurs, $messageErreur);
			}

		}	

		if (array_key_exists("zone-area", $_POST) == true)
		{
			if (trim($_POST["zone-area"]) == '') 
			{
				$messageErreur = "Vous devez saisir un commentaire ! ";
				array_push($erreurs, $messageErreur);
			}
		}

		

		// Tableau erreur non vide
		if (empty ($erreurs))
		{
			//Insertion en base

			//$myDate = date("Y-m-d");;

			//echo $myDate;

			$sql = "INSERT INTO `commentaire`(`utilisateur`, `contenu`, `note`, `date_commentaire`, `id_article`) 
			VALUES (:identifiantUtilisateur,:identifiantContenu,:identifiantNote, now(),:identifiantArticle)";

			$requete = $connexion->prepare($sql);

			
			$requete->bindvalue(":identifiantUtilisateur", $_POST["nom"] , PDO::PARAM_STR);
			$requete->bindvalue(":identifiantContenu", $_POST["zone-area"] , PDO::PARAM_STR);
			$requete->bindvalue(":identifiantArticle", $_POST["idEtudiant"] , PDO::PARAM_INT);
			$requete->bindvalue(":identifiantNote", intval($_POST["note"]) , PDO::PARAM_INT);

			$successAddCommentaire  = $requete->execute();

			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			/* special ajax here */
				
				/*die(
					"Votre commentaire a bien été ajouté"
					);*/

				$date=date('y-m-d h:i:s');

				die(json_encode( [
									"message" => "votre commentaire a bien été ajouté",
									"commentaire"=> "<div class='media'>
                       							 	<a class='pull-left' href='#'>
                        							</a>
                       								<div class='media-body'>
                           					 			<h4 class='media-heading'>".$_POST['nom'].
                               						 		"<br/><small>".$date.
                                							"<br/></small>
                           						 		</h4>
                            							<div class='jpf' data-score='".$_POST['note']."'></div>
                          									<p>".$_POST['zone-area']."</p>
                        								</div>
                  							  		</div>
                  							  	</div>"]));
				

				}



		}
		else
		{
			//Affichage des erreurs dans la vue article
			//var_dump($erreurs);
		}

	}




	/*$dsn = "mysql: host=localhost;dbname=blogtroiswa;charset=utf8";
	$login="root";
	$motDePasse = "troiswa";
	$connexion = new PDO($dsn, $login, $motDePasse);

	//Afiichage des erreurs
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);*/

	//$sql="SELECT *  FROM article";


	// Requete affichage article
	$currentArticle = $_GET["id"];

	$sql = "SELECT article.id, titre, description, auteur.nom AS auteur, date_ajout, image
	FROM  `article` 
	INNER JOIN auteur ON auteur.id = article.id_auteur and article.id =:article";


	$requete = $connexion->prepare($sql);


	$requete->bindvalue(":article", intval($currentArticle), PDO::PARAM_INT);
	
	$success = $requete->execute(); // On s'arrete ici si requete INSERT/UPDATE/DELETE

	
	// Si requete select :

	// FetchAll-> plusieurs resultats
	// Fetch -> 1 seul resultat
	// FetchColumn() -> retourne le resultat directement

	//$requete->bindValue(":nombre",intval($_GET["nombre"]),PDO::PARAM_INT);

	// Recuperation des resultats dans une variable
	
	$unArticle = $requete->fetch(PDO::FETCH_ASSOC);
	//var_dump($unArticle);


	// Requete affichage commentaire

	$currentArticle = $_GET["id"];

	//var_dump($currentArticle);
	$sql = "SELECT utilisateur, contenu, note, date_commentaire FROM `commentaire` where id_article = :article";

	

	$requete = $connexion->prepare($sql);


	$requete->bindvalue(":article", intval($currentArticle), PDO::PARAM_INT);
	
	$success= $requete->execute(); // On s'arrete ici si requete INSERT/UPDATE/DELETE


	$touslescommentaires = $requete->fetchAll(PDO::FETCH_ASSOC);

	//var_dump($touslescommentaires);

