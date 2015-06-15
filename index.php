<?php

include "config/config.php";

$currentPage="accueil";

//var_dump($_GET);

if (array_key_exists("page", $_GET))
{
	$currentPage = $_GET["page"];	
}

if ("logout" == $currentPage )
{
	session_destroy();
	header("Location:index.php?page=login");
	die();
}

include "controller/".$currentPage."Controller.php";


include "vue/".$currentPage."Vue.phtml";