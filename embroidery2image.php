<?php
function embroidery2image($embroidery,$scale_post=1,$scale_pre=false) {
	// Create image
	$im=imagecreatetruecolor(ceil($embroidery->imageWidth*$scale_post),ceil($embroidery->imageHeight*$scale_post));
	imagesavealpha($im,true);
	imagealphablending($im,false);
	$color=imagecolorallocatealpha($im,255,255,255,127);
	imagefill($im,0,0,$color);

	// Draw stitches
	foreach($embroidery->blocks as $block){
		$color=imagecolorallocate($im,$block->color->r,$block->color->g,$block->color->b);
		$x=false;
		foreach($block->stitches as $stitch){
			if($x!==false) imageline($im,
				($x-$embroidery->min->x)*$scale_post,
				($y-$embroidery->min->y)*$scale_post,
				($stitch->x-$embroidery->min->x)*$scale_post,
				($stitch->y-$embroidery->min->y)*$scale_post,
			$color);
			$x=$stitch->x;
			$y=$stitch->y;
		}
	}

	// Scale finished image
	if($scale_pre){
		$im2=imagecreatetruecolor($embroidery->imageWidth*$scale_post*$scale_pre,$embroidery->imageHeight*$scale_post*$scale_pre);
		imagesavealpha($im2,true);
		imagealphablending($im2,false);
		imagecopyresized($im2,$im,0,0,0,0,$embroidery->imageWidth*$scale_post*$scale_pre,$embroidery->imageHeight*$scale_post*$scale_pre,$embroidery->imageWidth*$scale_post,$embroidery->imageHeight*$scale_post);
		imagedestroy($im);
		$im=$im2;
	}

	return($im);
}
?>