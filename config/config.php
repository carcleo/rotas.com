<?php	

	declare(strict_types=1);

	session_start();
	
	error_reporting(E_ALL);
	
	ini_set('display_errors', '1');	

	date_default_timezone_set('America/Sao_Paulo');
	
	require_once(dirname(__DIR__) . '/vendor/autoload.php');	
	
	$extensaoFile = pathinfo($_SERVER["REQUEST_URI"], PATHINFO_EXTENSION);
	$extensoes = ['php', 'html', 'htm', 'js', 'css','jpg', 'jpge', 'png'];
	
	if ( in_array ($extensaoFile, $extensoes) ) {
		route("error.404");
	}