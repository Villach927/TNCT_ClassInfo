<?php

require_once("twitteroauth/autoload.php");
use Abraham\TwitterOAuth\TwitterOAuth;

function getContents(DateTime $date){
	$month = $date->format("Ym");

	$dom = new DOMDocument;
	@$dom->loadHTMLFile("http://www.tsuyama-ct.ac.jp/oshiraseVer4/renraku/renraku" . $month . ".html");
	$xpath = new DOMXPath($dom);
	$entries = [];

	foreach($xpath->query('//div[@id="contents"]') as $node) {
	    return $node->textContent;
	}

}

function connectToTwitter(){
	$token = file(__DIR__ . '/token.txt');

	for($i = 0;$i < count($token);++$i){
		$token[$i] = trim($token[$i]);
	}

	var_dump($token);

	$connection = new TwitterOAuth($token[0], $token[1], $token[2], $token[3]);

	return $connection;
}