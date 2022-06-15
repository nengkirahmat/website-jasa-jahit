<?php
session_start();
date_default_timezone_set('asia/jakarta');
	try {
		$con=new PDO("mysql:host=localhost; dbname=jahit", "root", "" );
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		$e->getMessage();
	}
?>