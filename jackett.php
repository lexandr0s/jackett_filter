<?php
	$rss = $_GET[rss];
	$cat = $_GET[cat];
	$q = $_GET[q];
	$max_size=$_GET[max_size];
	$url = "${rss}&t=search&cat=${cat}&q=${q}";
	$xml = simplexml_load_file("${url}");
	
	$items = $xml->simpleXML->xpath('/rss/channel/item');
	
	
		foreach ($items as $item) {
			$size=0;
			$size=$item->size;
		
			if (!empty($item->size)) {
				$size=round($item->size / 1024 / 1024, 0);
			}
			else $size=0;
			if (!empty($max_size)) {
				if ( $size > $max_size ){
					$node = dom_import_simplexml($item);
					$node->parentNode->removeChild($node);
				}
			}
			$gbmb="Mb";
			if ($size > 1000){
				$size=round($size / 1024, 2);
				$gbmb="Gb";
			}
			$item->title = "$item->title ($size $gbmb)";
		}
	 
	$newxml = $xml->asXML();
	echo(header('content-type: text/xml'));
	echo $newxml;
	
	
?>