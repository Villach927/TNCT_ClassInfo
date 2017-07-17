<?php

function prepareDB(){
	try {
	    $pdo = new PDO('sqlite:Classes.db');

	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	    /*Type
			1……授業変更
			2……補講
			3……休講
			4……教室変更
	    */
	    $pdo->exec("CREATE TABLE IF NOT EXISTS classes(
	        id INTEGER PRIMARY KEY AUTOINCREMENT,
	        date TEXT,
	        info TEXT UNIQUE,
	        type INTEGER,
	        count INTEGER
	    )");

	} catch (Exception $e) {
	    echo $e->getMessage() . PHP_EOL;
	}

	return $pdo;
}

function inputClassRecord(PDO $pdo, $date, $info, $type, $count){
	$statement = $pdo->prepare("INSERT INTO classes (date, info, type, count) VALUES (?, ?, ?, ?)");

	$statement->bindValue(1, $date);
	$statement->bindValue(2, $info);
	$statement->bindValue(3, $type);
	$statement->bindValue(4, $count);

	$statement->execute();

	return $statement->fetch();
}

function getClassRecords(PDO $pdo){
	$statement = $pdo->prepare("SELECT date, info, type FROM classes");
	$statement->execute();

	return $statement->fetchAll();
}