<?php

function parseContents(array $contents){
	$analysisedContents = [];
	$borders = ["授業変更", "補講", "休講", "教室変更"];
	$i = -1;
	foreach($contents as $class) {
		$class = trim($class);
		if(in_array($class, $borders)){
			++$i;
		}else if($i >= 0 && $class !== ""){
			$analysisedContents[$i][] = $class;
		}
	}

	return $analysisedContents;
}