<?php

require_once("Communication.php");
require_once("Analysis.php");
require_once("DB.php");

$date = new DateTime();

$contents = explode("\n", getContents($date));

$classes = parseContents($contents);

var_dump($classes);

$pdo = prepareDB();

for($i = 0;$i < count($classes);++$i){
	foreach ($classes[$i] as $class) {
		inputClassRecord($pdo, $class["date"], $class["info"], $i, 0);
	}
}

$connection = connectToTwitter();
