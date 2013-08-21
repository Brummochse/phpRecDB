<?php
define("TEXTENABLED", "watermark_textEnabled");
define("TEXT", "watermark_text");
define("FONTSIZE", "watermark_fontSize");
define("TEXTBORDER", "watermark_textBorder");
define("ALIGN", "watermark_align");
define("VALIGN", "watermark_valign");
define("FONTSTYLE", "watermark_fontStyle");
define("RED", "watermark_red");
define("GREEN", "watermark_green");
define("BLUE", "watermark_blue");
define("THUMBNAIL", "watermark_thumbnail");
define("RESIZETHUMBNAIL", "watermark_resizeThumbnail");

define("ALIGN_LEFT", "left");
define("ALIGN_CENTER", "center");
define("ALIGN_RIGHT", "right");
define("VALIGN_TOP", "top");
define("VALIGN_MIDDLE", "middle");
define("VALIGN_BOTTOM", "bottom");

function imagestringbox(& $image, $fontsize, $fontfile, $border, $align, $valign, $text, $color) {

	$imagewidth = imagesx($image);
	$imageheight = imagesy($image);

	$size = imagettfbbox($fontsize, 0, $fontfile, $text);
	$left = - $size[0];
	$top = - $size[7];
	$right = $size[2];
	$bottom = $size[1];

	// Vertical Align
	switch ($valign) {
		case 'top' : // Top
			$y = $top + $border;
			break;
		case 'middle' : // Middle
			$y = $top + (($imageheight - $bottom) / 2);
			break;
		case 'bottom' : // Bottom
			$y = $imageheight - $bottom - $border;
			break;
		default :
			return false;
	}

	// Horizontal Align
	switch ($align) {
		case 'left' : // Left
			$x = $left + $border;
			break;
		case 'center' : // Center
			$x = $left + (($imagewidth - $right) / 2);
			break;
		case 'right' : // Right
			$x = $imagewidth - $right - $border;
			break;
		default :
			return false;
	}

	imagettftext($image, $fontsize, 0, $x, $y, $color, $fontfile, $text);
	return true;
}

function watermarkWithGif(& $image,$watermarkGif,$border, $align, $valign) {
	$watermark = @ imagecreatefromgif($watermarkGif);
	$imagewidth = imagesx($image);
	$imageheight = imagesy($image);
	$watermarkwidth = imagesx($watermark);
	$watermarkheight = imagesy($watermark);
	
	// Vertical Align
	switch ($valign) {
		case VALIGN_TOP : // Top
			$y = $border;
			break;
		case VALIGN_MIDDLE : // Middle
			$y = ($imageheight - $watermarkheight) / 2;
			break;
		case VALIGN_BOTTOM : // Bottom
			$y = $imageheight - $watermarkheight - $border;
			break;
		default :
			return false;
	}

	// Horizontal Align
	switch ($align) {
		case ALIGN_LEFT : // Left
			$x = $border;
			break;
		case ALIGN_CENTER : // Center
			$x = ($imagewidth - $watermarkwidth) / 2;
			break;
		case ALIGN_RIGHT : // Right
			$x = $imagewidth - $watermarkwidth - $border;
			break;
		default :
			return false;
	}
	imagecopy($image, $watermark, $x, $y, 0, 0, $watermarkwidth, $watermarkheight);
}

?>
