<?php

date_default_timezone_set('Asia/Tokyo');

require_once("Communication.php");
require_once("Analysis.php");
require_once("DB.php");

$types = ["授業変更", "補講", "休講", "教室変更"];

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
		$rclass = ["date" => $rclass["date"], "info" => $rclass["info"], "type" => $rclass["type"]];
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
	$res = inputClassRecord($pdo, $nrclass["date"], $nrclass["info"], $nrclass["type"], 0);
}


//実行時の日付に応じてつぶやく
//授業変更，補講，休講，教室変更の情報追加時，および1日前
$connection = connectToTwitter();

foreach ($notRecordedClasses as $class) {
	$date = new DateTime();
	$date->setTimeStamp($class["date"]);
	$strDate = $date->format("m月d日");
	$message = strval("新規追加情報：\n" . "【" . $types[$class["type"]]) . "】" . $strDate . "\n" . $class["info"];
	$res = $connection->post("statuses/update", ["status" => $message]);
}

//ごちゃごちゃしてる……
foreach ($recordedClasses as $class) {
	$cdate = new DateTime();
	$cdate->setTimeStamp($class["date"]);
	if (intval($class["count"]) === 0 && intval($class["date"]) - intval(date("U")) < 172800 && intval($class["date"]) - intval(date("U")) > 0){
		$strDate = $cdate->format("m月d日");
		$message = strval("【" . $types[$class["type"]]) . "】" . $strDate . "\n" . $class["info"];
		$res = $connection->post("statuses/update", ["status" => $message]);
		updateClassRecord($pdo, $class["id"]);
	}
}