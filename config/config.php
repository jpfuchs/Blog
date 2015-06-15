<?php

	session_start();

	//var_dump($_SESSION);

	//$_SESSION["test"] ="test";

	$dsn = "mysql: host=localhost;dbname=blogtroiswa;charset=utf8";
	$login="root";
	$motDePasse = "";
	$connexion = new PDO($dsn, $login, $motDePasse);

	//Afiichage des erreurs
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	
	function testConnexion()
	{
		 if ( empty($_SESSION["utilisateur"]["login"]) == true ||  empty($_SESSION["utilisateur"]["password"]) == true)
    	{
      		header("Location:index.php?page=login");
      		die();
    	}

	}

	function isConnected()
	{
		if ( empty($_SESSION["utilisateur"]["login"]) == true ||  empty($_SESSION["utilisateur"]["password"]) == true)
    	{
            return false;
    	}

    	return true;

	}