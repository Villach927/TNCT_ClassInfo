<?php

function parseContents(array $contents){
	$parsedContents = [];
	foreach ($contents as $class) {
		$class = trim($class);
		if($class !== "") $parsedContents[] = $class;
	}
	return $parsedContents;
}