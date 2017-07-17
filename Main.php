<?php

require_once("Communication.php");
require_once("Analysis.php");
require_once("DB.php");

$date = new DateTime();

$contents = explode("\n", getContents($date));

$classes = parseContents($contents);

$pdo = prepareDB();

$recordedClasses = getClassRecords($pdo);
$notRecordedClasses = [];

//DBから取得した記録済みのデータとWebサイトから取得したデータを比較し，新規更新分のみを取り出す
//array_diffすると怒られるのでクソザコforeachくんで
foreach($classes as $class){
	$f = 0;
	foreach ($recordedClasses as $rclass) {
		if($class == $rclass){
			$f = 1;
			break;
		}
	}
	if($f === 0){
		$notRecordedClasses[] = $class;
	}
}

//新規更新分をDBに記録する
foreach ($notRecordedClasses as $nrclass) {
	inputClassRecord($pdo, $nrclass["date"], $nrclass["info"], $nrclass["type"], 0);
}


//実行時の日付に応じてつぶやく
//授業変更，補講，休講，教室変更の情報追加時，および1日前

$connection = connectToTwitter();