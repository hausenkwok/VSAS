<?php 

	//config
	date_default_timezone_set('UTC');

	$dsn = 'mysql:dbname=chige;host=127.0.0.1';
	$user = 'root';
	$password = '123456';
	try
	{
		$dblink = new PDO($dsn, $user, $password);
	}
	catch (PDOException $e)
	{
		echo 'Connection failed: ' . $e->getMessage();
	}
?>