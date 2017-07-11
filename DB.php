<?php

function prepareDB(){
	try {
	    $pdo = new PDO('sqlite:classes.db');

	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	    $pdo->exec("CREATE TABLE IF NOT EXISTS classes(
	        id INTEGER PRIMARY KEY AUTOINCREMENT,
	        date TEXT,
	        info TEXT
	    )");
	} catch (Exception $e) {
	    echo $e->getMessage() . PHP_EOL;
	}

	return $pdo;
}