<?php

//var_dump($_POST);

if ( !empty($_POST) == true )   
{
		$erreurs = array();
			

		if (array_key_exists("inputEmail", $_POST) == true)
		{	
			// on peut mettre aussi comme test:  if (empty($_POST["nom"] )
			if (trim($_POST["inputEmail"]) == '')
			{	
				$messageErreur = "Vous devez entrer un login ! ";
				array_push($erreurs, $messageErreur);  // on peut mettre aussi: $erreurs["nom"]= "blabla"
			}
		}

		if (array_key_exists("inputPassword", $_POST) == true)
		{

			/*if (trim($_POST["inputPassword"]) == '' ) 
			{
				$messageErreur = "Vous devez entrer un password! ";
				array_push($erreurs, $messageErreur);
			}*/

		}	

 		var_dump($erreurs);

		// Tableau erreur non vide
		if (!empty ($erreurs))
		{
			//var_dump($erreurs);
		}
		else
		{
			//die("vous etes connecté");
		
			$sql = "SELECT * FROM utilisateur WHERE login = :identifiant and password = :idpassword";
			$requete = $connexion->prepare($sql);

			$requete->bindvalue(":identifiant", $_POST["inputEmail"], PDO::PARAM_STR);
			$requete->bindvalue(":idpassword", sha1($_POST["inputPassword"]) , PDO::PARAM_STR);
			$success = $requete->execute();
	
			// Recuperation des resultats dans une variable
			$utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

			if (!empty ($utilisateur))
			{
				//die("connexion");

				$_SESSION["utilisateur"]["login"] = $_POST["inputEmail"];
				$_SESSION["utilisateur"]["password"] = sha1($_POST["inputPassword"]);
				header('Location: index.php?page=statistiques');
				die();

			}
			else
			{	
				//echo "test";
				$messageErreur = "l'utilisateur n'existe pas! ";
				array_push($erreurs, $messageErreur);

				var_dump($erreurs);
			}
		
		}

}

		
