<?php

require_once("Communication.php");
require_once("Analysis.php");
require_once("DB.php");

$date = new DateTime();

$contents = explode("\n", getContents($date));

$classes = parseContents($contents);

var_dump($classes);

$pdo = prepareDB();