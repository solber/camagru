<?php
try
{
	$DB_DSN = "mysql:host=localhost";
	$DB_USER = 'root';
	$DB_PASSWORD = '';
	$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);

	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}