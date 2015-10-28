<?php
function embroidery2svg($embroidery,$scale=1){
	// header('Content-Type: image/svg+xml');
	$xml=new SimpleXMLElement('<svg />');
	$xml->addAttribute('xmlns','http://www.w3.org/2000/svg');
	$xml->addAttribute('xmlns:xlink','http://www.w3.org/1999/xlink');
	$xml->addAttribute('xmlns:ev','http://www.w3.org/2001/xml-events');
	$xml->addAttribute('version','1.1');
	$xml->addAttribute('baseProfile','full');
	$xml->addAttribute('width',$embroidery->imageWidth*$scale);
	$xml->addAttribute('height',$embroidery->imageHeight*$scale);

	foreach($embroidery->blocks as $block){
		$line=$xml->addChild('path');
		$line->addAttribute('stroke',rgb2html($block->color->r,$block->color->g,$block->color->b));
		$line->addAttribute('fill','none');
		$points='';
		foreach($block->stitches as $stitch){
			$points.=($points ? ' L ' : 'M ').(($stitch->x-$embroidery->min->x)*$scale).' '.(($stitch->y-$embroidery->min->y)*$scale);
		}
		$line->addAttribute('d',$points);
	}

	return($xml->asXML());
}

function rgb2html($r,$g,$b){
	return('#'.substr('0'.dechex($r),-2).substr('0'.dechex($g),-2).substr('0'.dechex($b),-2));
}
?>
