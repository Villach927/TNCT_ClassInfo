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
			if(strpos($class, "日")  && strpos($class, "月") !== false){
				$date = new DateTime(date("Y") . "-" . str_replace("月", "-", substr(substr($class, 0, strpos($class, " ")), 0, strpos($class, "日"))));
				$info = substr($class, strpos($class, " "));
				$analysisedContents[] = ["date" => $date->format("U"), "info" => trim($info), "type" => $i];
			}
		}
	}

	return $analysisedContents;
}