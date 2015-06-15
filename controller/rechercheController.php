<?php

function getLittleDescription($texte, $nbchar = 200)
	{

		return (strlen($texte) > $nbchar ? substr(substr($texte,0,$nbchar),0,strrpos(substr($texte,0,$nbchar)," "))."..." : $texte);
	}

$sql = "SELECT * FROM article WHERE description like  :mot  or titre  like  :mot ";


	$requete = $connexion->prepare($sql);

	$requete->bindValue(":mot",'%'.$_GET["word"].'%', PDO::PARAM_STR);
	

	$success = $requete->execute();
	// Recuperation des resultats dans une variable
	$articlerechercher = $requete->fetchAll(PDO::FETCH_ASSOC);
	
	//var_dump($articlerechercher);


	//echo "test";


	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
	{
		/* special ajax here */
		//die("fin ajax");

		//echo "test1";

		$listesLi="";

		 foreach ($articlerechercher as $key => $value) 
		 {



		 	$listesLi .= "<li><a href='index.php?page=article&id=".$value['id']."'>".$value["titre"]."</a></li>";
		 }

		// var_dump($listesLi);

		// die("fin ajax");


		// json_encode -> transforme le format json en chaine de caractere

		// depuis php on envoie des info en json qui seront interpretes dans le javascript
		die(json_encode([

				//re"message"=>"top",
				"listes"=>$listesLi

			]));

	}