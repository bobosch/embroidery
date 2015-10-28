<?php
require_once('embroidery2image.php');
require_once('embroidery2svg.php');

function imageEmbroidery($embroidery,$base=false,$scale_post=1,$scale_pre=false) {
	$im=embroidery2image($embroidery,$scale_post,$scale_pre);
	if($base){
		// Save png
		imagepng($im,$base.'.png');	
		// Optimize png
		exec('optipng '.escapeshellcmd($base.'.png'));
		// Save svg
		$svg=embroidery2svg($embroidery,$scale_post);
		file_put_contents($base.'.svg',$svg);
	}else{
		// Output image
		header('Content-type: image/png');
		imagepng($im);
	}
	imagedestroy($im);
}

function getEmbroideryInformation($embroidery){
	$info=array(
		'width'=>$embroidery->imageWidth,
		'height'=>$embroidery->imageHeight,
		'stitches'=>0,
		'colors_pes'=>array(),
	);
	foreach($embroidery->blocks as $block){
		$info['stitches']+=$block->stitchesTotal;
		$info['colors_pes'][]=$block->colorIndex;
	}
	return($info);
}
?>
