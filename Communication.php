<?php

function getContents(DateTime $date){
	$month = $date->format("Ym");

	$dom = new DOMDocument;
	@$dom->loadHTMLFile("http://www.tsuyama-ct.ac.jp/oshiraseVer4/renraku/renraku" . $month . ".html");
	$xpath = new DOMXPath($dom);
	$entries = [];

	foreach ($xpath->query('//div[@id="contents"]') as $node) {
	    return $node->textContent;
	}

}