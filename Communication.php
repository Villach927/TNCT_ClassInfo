<?php

function getContent(DateTime $date){
	$dom = new DOMDocument;
	@$dom->loadHTMLFile("http://www.tsuyama-ct.ac.jp/oshiraseVer4/renraku/renraku" . ".html");
	$xpath = new DOMXPath($dom);
	$entries = [];

	foreach ($xpath->query('//div[@id="contents"]') as $node) {
	    
	}
}