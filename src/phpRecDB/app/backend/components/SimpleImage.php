<?php
/*

  The PHP SimpleImage class - v2
  
    By Cory LaViska for A Beautiful Site, LLC. (http://www.abeautifulsite.net/)
  
  License:
  
    This software is dual-licensed under the GNU General Public License and 
    the MIT License and is copyright A Beautiful Site, LLC.
	
*/

class SimpleImage {
	
	private $image, $filename, $original_info, $width, $height;
	
	function __construct($filename = null) {
		if( $filename ) $this->load($filename);
	}
	
	function __destruct() {
		if( $this->image ) imagedestroy($this->image);
	}
	
	//
	// Load an image
	//
	//	$filename - the image to be loaded (required)
	//
	public function load($filename) {
		
		// Require GD library
		if( !extension_loaded('gd') ) throw new Exception('Required extension GD is not loaded.');
		
		$this->filename = $filename;
		
		$info = getimagesize($this->filename);
		
		switch( $info['mime'] ) {
			
			case 'image/gif':
				$this->image = imagecreatefromgif($this->filename);
				break;
				
			case 'image/jpeg':
				$this->image = imagecreatefromjpeg($this->filename);
				break;
					
			case 'image/png':
				$this->image = imagecreatefrompng($this->filename);
				break;
				
                        //phpRecDB begin
                        case 'image/x-ms-bmp':
                            $this->image = $this->imagecreatefrombmp($this->filename);
                            break;
                        //phpRecDB end
                            
			default:
				throw new Exception('Invalid image: ' . $this->filename);
				break;
				
		}
		
		$this->original_info = array(
			'width' => $info[0],
			'height' => $info[1],
			'orientation' => $this->get_orientation(),
			'exif' => function_exists('exif_read_data') ? $this->exif = @exif_read_data($this->filename) : null,
			'format' => preg_replace('/^image\//', '', $info['mime']),
			'mime' => $info['mime']
		);
		
		$this->width = $info[0];
		$this->height = $info[1];
		
		imagesavealpha($this->image, true);
		imagealphablending($this->image, true);
                           
		return $this;
		
	}
        
        //phpRecDB begin
        private function imagecreatefrombmp($filename) {
            // version 1.00
            if (!($fh = fopen($filename, 'rb'))) {
                trigger_error('imagecreatefrombmp: Can not open ' . $filename, E_USER_WARNING);
                return false;
            }
            // read file header
            $meta = unpack('vtype/Vfilesize/Vreserved/Voffset', fread($fh, 14));
            // check for bitmap
            if ($meta['type'] != 19778) {
                trigger_error('imagecreatefrombmp: ' . $filename . ' is not a bitmap!', E_USER_WARNING);
                return false;
            }
            // read image header
            $meta += unpack('Vheadersize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vcolors/Vimportant', fread($fh, 40));
            // read additional 16bit header
            if ($meta['bits'] == 16) {
                $meta += unpack('VrMask/VgMask/VbMask', fread($fh, 12));
            }
            // set bytes and padding
            $meta['bytes'] = $meta['bits'] / 8;
            $meta['decal'] = 4 - (4 * (($meta['width'] * $meta['bytes'] / 4)- floor($meta['width'] * $meta['bytes'] / 4)));
            if ($meta['decal'] == 4) {
                $meta['decal'] = 0;
            }
            // obtain imagesize
            if ($meta['imagesize'] < 1) {
                $meta['imagesize'] = $meta['filesize'] - $meta['offset'];
                // in rare cases filesize is equal to offset so we need to read physical size
                if ($meta['imagesize'] < 1) {
                    $meta['imagesize'] = @filesize($filename) - $meta['offset'];
                    if ($meta['imagesize'] < 1) {
                        trigger_error('imagecreatefrombmp: Can not obtain filesize of ' . $filename . '!', E_USER_WARNING);
                        return false;
                    }
                }
            }
            // calculate colors
            $meta['colors'] = !$meta['colors'] ? pow(2, $meta['bits']) : $meta['colors'];
            // read color palette
            $palette = array();
            if ($meta['bits'] < 16) {
                $palette = unpack('l' . $meta['colors'], fread($fh, $meta['colors'] * 4));
                // in rare cases the color value is signed
                if ($palette[1] < 0) {
                    foreach ($palette as $i => $color) {
                        $palette[$i] = $color + 16777216;
                    }
                }
            }
            // create gd image
            $im = imagecreatetruecolor($meta['width'], $meta['height']);
            $data = fread($fh, $meta['imagesize']);
            $p = 0;
            $vide = chr(0);
            $y = $meta['height'] - 1;
            $error = 'imagecreatefrombmp: ' . $filename . ' has not enough data!';
            // loop through the image data beginning with the lower left corner
            while ($y >= 0) {
                $x = 0;
                while ($x < $meta['width']) {
                    switch ($meta['bits']) {
                        case 32:
                        case 24:
                            if (!($part = substr($data, $p, 3))) {
                                trigger_error($error, E_USER_WARNING);
                                return $im;
                            }
                            $color = unpack('V', $part . $vide);
                            break;
                        case 16:
                            if (!($part = substr($data, $p, 2))) {
                                trigger_error($error, E_USER_WARNING);
                                return $im;
                            }
                            $color = unpack('v', $part);
                            $color[1] = (($color[1] & 0xf800) >> 8) * 65536 + (($color[1] & 0x07e0) >> 3) * 256 + (($color[1] & 0x001f) << 3);
                            break;
                        case 8:
                            $color = unpack('n', $vide . substr($data, $p, 1));
                            $color[1] = $palette[ $color[1] + 1 ];
                            break;
                        case 4:
                            $color = unpack('n', $vide . substr($data, floor($p), 1));
                            $color[1] = ($p * 2) % 2 == 0 ? $color[1] >> 4 : $color[1] & 0x0F;
                            $color[1] = $palette[ $color[1] + 1 ];
                            break;
                        case 1:
                            $color = unpack('n', $vide . substr($data, floor($p), 1));
                            switch (($p * 8) % 8) {
                                case 0:
                                    $color[1] = $color[1] >> 7;
                                    break;
                                case 1:
                                    $color[1] = ($color[1] & 0x40) >> 6;
                                    break;
                                case 2:
                                    $color[1] = ($color[1] & 0x20) >> 5;
                                    break;
                                case 3:
                                    $color[1] = ($color[1] & 0x10) >> 4;
                                    break;
                                case 4:
                                    $color[1] = ($color[1] & 0x8) >> 3;
                                    break;
                                case 5:
                                    $color[1] = ($color[1] & 0x4) >> 2;
                                    break;
                                case 6:
                                    $color[1] = ($color[1] & 0x2) >> 1;
                                    break;
                                case 7:
                                    $color[1] = ($color[1] & 0x1);
                                    break;
                            }
                            $color[1] = $palette[ $color[1] + 1 ];
                            break;
                        default:
                            trigger_error('imagecreatefrombmp: ' . $filename . ' has ' . $meta['bits'] . ' bits and this is not supported!', E_USER_WARNING);
                            return false;
                    }
                    imagesetpixel($im, $x, $y, $color[1]);
                    $x++;
                    $p += $meta['bytes'];
                }
                $y--;
                $p += $meta['decal'];
            }
            fclose($fh);
            return $im;
        }
        //phpRecDB end
    
	//
	// Save an image
	//
	//		$filename - the filename to save to (defaults to original file)
	//		$quality - 0-9 for PNG, 0-100 for JPEG
	//
	//	Notes:
	//
	//		The resulting format will be determined by the file extension.
	//
	public function save($filename = null, $quality = null) {
		if( !$filename ) $filename = $this->filename;
		
		// Determine format via file extension (fall back to original format)
		$format = $this->file_ext($filename);
		if( !$format ) $format = $this->original_info['format'];
                            
		// Determine output format
		switch( strtolower($format) ) {
			
			case 'gif':
				$result = imagegif($this->image, $filename);
				break;
			
			case 'jpg':
			case 'jpeg':
				if( $quality === null ) $quality = 85;
				$quality = $this->keep_within($quality, 0, 100);
				$result = imagejpeg($this->image, $filename, $quality);
				break;
			
			case 'png':
				if( $quality === null ) $quality = 9;
				$quality = $this->keep_within($quality, 0, 9);
				$result = imagepng($this->image, $filename, $quality);
				break;
			
                        //phpRecDB begin
                        case 'bmp':
				$result = $this->imagebmp($this->image, $filename);
				break;
                        //phpRecDB end
                                
			default:
				throw new Exception('Unsupported format'." ".strtolower($format));
			
		}
		
		if( !$result ) throw new Exception('Unable to save image: ' . $filename);
		
		return $this;
		
	}
	
        //phpRecDB begin
        private function imagebmp($im, $filename = '', $bit = 24, $compression = 0) {
              // version 1.00
              if (!in_array($bit, array(1, 4, 8, 16, 24, 32))) {
                  $bit = 24;
              } else if ($bit == 32) {
                  $bit = 24;
              }
              $bits = pow(2, $bit);
              imagetruecolortopalette($im, true, $bits);
              $width = imagesx($im);
              $height = imagesy($im);
              $colors_num = imagecolorstotal($im);
              $rgb_quad = '';
              if ($bit <= 8) {
                  for ($i = 0; $i < $colors_num; $i++) {
                      $colors = imagecolorsforindex($im, $i);
                      $rgb_quad .= chr($colors['blue']) . chr($colors['green']) . chr($colors['red']) . "\0";
                  }
                  $bmp_data = '';
                  if ($compression == 0 || $bit < 8) {
                      $compression = 0;
                      $extra = '';
                      $padding = 4 - ceil($width / (8 / $bit)) % 4;
                      if ($padding % 4 != 0) {
                          $extra = str_repeat("\0", $padding);
                      }
                      for ($j = $height - 1; $j >= 0; $j--) {
                          $i = 0;
                          while ($i < $width) {
                              $bin = 0;
                              $limit = $width - $i < 8 / $bit ? (8 / $bit - $width + $i) * $bit : 0;
                              for ($k = 8 - $bit; $k >= $limit; $k -= $bit) {
                                  $index = imagecolorat($im, $i, $j);
                                  $bin |= $index << $k;
                                  $i++;
                              }
                              $bmp_data .= chr($bin);
                          }
                          $bmp_data .= $extra;
                      }
                  }
                  // RLE8
                  else if ($compression == 1 && $bit == 8) {
                      for ($j = $height - 1; $j >= 0; $j--) {
                          $last_index = "\0";
                          $same_num = 0;
                          for ($i = 0; $i <= $width; $i++) {
                              $index = imagecolorat($im, $i, $j);
                              if ($index !== $last_index || $same_num > 255) {
                                  if ($same_num != 0) {
                                      $bmp_data .= chr($same_num) . chr($last_index);
                                  }
                                  $last_index = $index;
                                  $same_num = 1;
                              } else {
                                  $same_num++;
                              }
                          }
                          $bmp_data .= "\0\0";
                      }
                      $bmp_data .= "\0\1";
                  }
                  $size_quad = strlen($rgb_quad);
                  $size_data = strlen($bmp_data);
              } else {
                  $extra = '';
                  $padding = 4 - ($width * ($bit / 8)) % 4;
                  if ($padding % 4 != 0) {
                      $extra = str_repeat("\0", $padding);
                  }
                  $bmp_data = '';
                  for ($j = $height - 1; $j >= 0; $j--) {
                      for ($i = 0; $i < $width; $i++) {
                          $index = imagecolorat($im, $i, $j);
                          $colors = imagecolorsforindex($im, $index);
                          if ($bit == 16) {
                              $bin = 0 << $bit;
                              $bin |= ($colors['red'] >> 3) << 10;
                              $bin |= ($colors['green'] >> 3) << 5;
                              $bin |= $colors['blue'] >> 3;
                              $bmp_data .= pack("v", $bin);
                          } else {
                              $bmp_data .= pack("c*", $colors['blue'], $colors['green'], $colors['red']);
                          }
                      }
                      $bmp_data .= $extra;
                  }
                  $size_quad = 0;
                  $size_data = strlen($bmp_data);
                  $colors_num = 0;
              }
              $file_header = 'BM' . pack('V3', 54 + $size_quad + $size_data, 0, 54 + $size_quad);
              $info_header = pack('V3v2V*', 0x28, $width, $height, 1, $bit, $compression, $size_data, 0, 0, $colors_num, 0);
              if ($filename != '') {
                  $fp = fopen($filename, 'wb');
                  fwrite($fp, $file_header . $info_header . $rgb_quad . $bmp_data);
                  fclose($fp);
                  return true;
              }
              echo $file_header . $info_header . $rgb_quad . $bmp_data;
              return true;
        }
        //phpRecDB end
    
	//
	// Get info about the original image
	//
	//	Returns
	//
	//	array(
	//		width => 320,
	//		height => 200,
	//		orientation => ['portrait', 'landscape', 'square'],
	//		exif => array(...),
	//		mime => ['image/jpeg', 'image/gif', 'image/png'],
	//		format => ['jpeg', 'gif', 'png']
	//	)
	//
	public function get_original_info() {
		return $this->original_info;
	}
	
	//
	// Get the current width
	//
	public function get_width() {
		return imagesx($this->image);
	}
	
	//
	// Get the current height
	//
	public function get_height() {
		return imagesy($this->image);
	}
	
	//
	// Get the current orientation ('portrait', 'landscape', or 'square')
	//
	public function get_orientation() {
		
		if( imagesx($this->image) > imagesy($this->image) ) return 'landscape';
		if( imagesx($this->image) < imagesy($this->image) ) return 'portrait';
		return 'square';
		
	}
	
	//
	// Flip an image horizontally or vertically
	//
	//	$direction - 'x' or 'y'
	//
	public function flip($direction) {
		
		$new = imagecreatetruecolor($this->width, $this->height);
		imagealphablending($new, false);
		imagesavealpha($new, true);
		
		switch( strtolower($direction) ) {
			
			case 'y':
				for( $y = 0; $y < $this->height; $y++ ) imagecopy($new, $this->image, 0, $y, 0, $this->height - $y - 1, $this->width, 1);
				break;
			
			default:
				for( $x = 0; $x < $this->width; $x++ ) imagecopy($new, $this->image, $x, 0, $this->width - $x - 1, 0, 1, $this->height);
				break;
			
		}
		
		$this->image = $new;
		
		return $this;
		
	}
	
	//
	// Rotate an image
	//
	//	$angle - 0 - 360 (required)
	//	$bg_color - hex color for the background
	//
	public function rotate($angle, $bg_color = '#000000') {
		
		$rgb = $this->hex2rgb($bg_color);
		$bg_color = imagecolorallocate($this->image, $rgb['r'], $rgb['g'], $rgb['b']);
		
		$new = imagerotate($this->image, -($this->keep_within($angle, -360, 360)), $bg_color);
		imagesavealpha($new, true);
		imagealphablending($new, true);
		
		$this->width = imagesx($new);
		$this->height = imagesy($new);
		$this->image = $new;
		
		return $this;
		
	}
	
	//
	// Rotates and/or flips an image automatically so the orientation will 
	// be correct (based on exif 'Orientation')
	//
	public function auto_orient() {
		
		// Adjust orientation
		switch( $this->original_info['exif']['Orientation'] ) {
			case 1:
				// Do nothing
				break;
			case 2:
				// Flip horizontal
				$this->flip('x');
				break;
			case 3:
				// Rotate 180 counterclockwise
				$this->rotate(-180);
				break;
			case 4:
				// vertical flip
				$this->flip('y');
				break;
			case 5:
				// Rotate 90 clockwise and flip vertically
				$this->flip('y');
				$this->rotate(90);
				break;
			case 6:
				// Rotate 90 clockwise
				$this->rotate(90);
				break;
			case 7:
				// Rotate 90 clockwise and flip horizontally
				$this->flip('x');
				$this->rotate(90);
				break;
			case 8:
				// Rotate 90 counterclockwise
				$this->rotate(-90);
				break;
		}
		
		return $this;
		
	}
	
	//
	// Resize an image to the specified dimensions
	//
	//	$width - the width of the resulting image
	//	$height - the height of the resulting image
	//
	public function resize($width, $height) {
		
		$new = imagecreatetruecolor($width, $height);
		//imagealphablending($new, false);
		imagesavealpha($new, true);
		imagecopyresampled($new, $this->image, 0, 0, 0, 0, $width, $height, $this->width, $this->height);
		
		$this->width = $width;
		$this->height = $height;
		$this->image = $new;
		
		return $this;
		
	}
	
	//
	// Fit to width (proportionally resize to specified width)
	//
	public function fit_to_width($width) {
		$aspect_ratio = $this->height / $this->width;
		$height = $width * $aspect_ratio;
		return $this->resize($width, $height);
	}	
	
	//
	// Fit to height (proportionally resize to specified height)
	//
	public function fit_to_height($height) {
		$aspect_ratio = $this->height / $this->width;
		$width = $height / $aspect_ratio;
		return $this->resize($width, $height);
	}	
	
	//
	// Best fit (proportionally resize to fit in specified width/height)
	//
	public function best_fit($max_width, $max_height) {
		
		// If it already fits, there's nothing to do
		if( $this->width <= $max_width && $this->height <= $max_height ) return $this;
		
		// Determine aspect ratio
		$aspect_ratio = $this->height / $this->width;
		
		// Make width fit into new dimensions
		if( $this->width > $max_width ) {
			$width = $max_width;
			$height = $width * $aspect_ratio;
		} else {
			$width = $this->width;
			$height = $this->height;
		}
	   
		// Make height fit into new dimensions
		if( $height > $max_height ) {
			$height = $max_height;
			$width = $height / $aspect_ratio;
		}
		
		return $this->resize($width, $height);
		
	}	
	
	//
	// Crop an image
	//
	//	$x1 - left
	//	$y1 - top
	//	$x2 - right
	//	$y2 - bottom
	//
	public function crop($x1, $y1, $x2, $y2) {
		
		// Determine crop size
		if( $x2 < $x1 ) list($x1, $x2) = array($x2, $x1);
		if( $y2 < $y1 ) list($y1, $y2) = array($y2, $y1);
		$crop_width = $x2 - $x1;
		$crop_height = $y2 - $y1;
		
		$new = imagecreatetruecolor($crop_width, $crop_height);
		imagealphablending($new, false);
		imagesavealpha($new, true);
		imagecopyresampled($new, $this->image, 0, 0, $x1, $y1, $crop_width, $crop_height, $crop_width, $crop_height);
		
		$this->width = $crop_width;
		$this->height = $crop_height;
		$this->image = $new;
		
		return $this;
		
	}	
	
	//
	// Square crop (great for thumbnails)
	//
	//	$size - the size in pixels of the resulting image (width and height are the same) (optional)
	//
	public function square_crop($size = null) {
		
		// Calculate measurements
		if( $this->width > $this->height ) {
			// Landscape
			$x_offset = ($this->width - $this->height) / 2;
			$y_offset = 0;
			$square_size = $this->width - ($x_offset * 2);
		} else {
			// Portrait
			$x_offset = 0;
			$y_offset = ($this->height - $this->width) / 2;
			$square_size = $this->height - ($y_offset * 2);
		}
		
		// Trim to square
		$this->crop($x_offset, $y_offset, $x_offset + $square_size, $y_offset + $square_size);
		
		// Resize
		if( $size ) $this->resize($size, $size);
		
		return $this;
		
	}
	
	//
	// Desaturate (grayscale)
	//
	public function desaturate() {
		imagefilter($this->image, IMG_FILTER_GRAYSCALE);
		return $this;
	}
	
	//
	// Invert
	//
	public function invert() {
		imagefilter($this->image, IMG_FILTER_NEGATE);
		return $this;
	}
	
	//
	// Brightness
	//
	//	$level - darkest = -255, lightest = 255 (required)
	//
	public function brightness($level) {
		imagefilter($this->image, IMG_FILTER_BRIGHTNESS, $this->keep_within($level, -255, 255));
		return $this;
	}
	
	//
	// Contrast
	//
	//	$level - min = -100, max, 100 (required)
	//
	public function contrast($level) {
		imagefilter($this->image, IMG_FILTER_CONTRAST, $this->keep_within($level, -100, 100));
		return $this;
	}
	
	//
	// Colorize (requires PHP 5.2.5+)
	//
	//	$color - any valid hex color (required)
	//	$opacity - 0 - 1 (required)
	//
	public function colorize($color, $opacity) {
		$rgb = $this->hex2rgb($color);
		$alpha = $this->keep_within(127 - (127 * $opacity), 0, 127);
		imagefilter($this->image, IMG_FILTER_COLORIZE, $this->keep_within($rgb['r'], 0, 255), $this->keep_within($rgb['g'], 0, 255), $this->keep_within($rgb['b'], 0, 255), $alpha);
		return $this;
	}
	
	//
	// Edge Detect
	//
	public function edges() {
		imagefilter($this->image, IMG_FILTER_EDGEDETECT);
		return $this;
	}
	
	//
	// Emboss
	//
	public function emboss() {
		imagefilter($this->image, IMG_FILTER_EMBOSS);
		return $this;
	}
	
	//
	// Mean Remove
	//
	public function mean_remove() {
		imagefilter($this->image, IMG_FILTER_MEAN_REMOVAL);
		return $this;
	}
	
	//
	// Blur
	//
	//	$type - 'selective' or 'gaussian' (default = selective)
	//	$passes - the number of times to apply the filter
	//
	public function blur($type = 'selective', $passes = 1) {
		
		switch( strtolower($type) ) {
			case 'gaussian':
				$type = IMG_FILTER_GAUSSIAN_BLUR;
				break;
			default:
				$type = IMG_FILTER_SELECTIVE_BLUR;
				break;
		}
		
		for( $i = 0; $i < $passes; $i++ ) imagefilter($this->image, $type);
		
		return $this;
		
	}
	
	//
	// Sketch
	//
	public function sketch() {
		imagefilter($this->image, IMG_FILTER_MEAN_REMOVAL);
		return $this;
	}
	
	//
	// Smooth
	//
	//	$level - min = -10, max = 10
	//
	public function smooth($level) {
		imagefilter($this->image, IMG_FILTER_SMOOTH, $this->keep_within($level, -10, 10));
		return $this;
	}
	
	//
	// Pixelate (requires PHP 5.3+)
	//
	//	$block_size - the size in pixels of each resulting block (default = 10)
	//
	public function pixelate($block_size = 10) {
		imagefilter($this->image, IMG_FILTER_PIXELATE, $block_size, true);
		return $this;
	}
	
	//
	// Sepia
	//
	public function sepia() {
		imagefilter($this->image, IMG_FILTER_GRAYSCALE);
		imagefilter($this->image, IMG_FILTER_COLORIZE, 100, 50, 0);
		return $this;
	}
	
	//
	// Overlay (overlay an image on top of another; works with 24-big PNG alpha-transparency)
	//
	//	$overlay_file - the image to use as a overlay (required)
	//	$position - 'center', 'top', 'left', 'bottom', 'right', 'top left', 
	//				'top right', 'bottom left', 'bottom right'
	//	$opacity - overlay opacity (0 - 1)
	//	$x_offset - horizontal offset in pixels
	//	$y_offset - vertical offset in pixels
	//
	public function overlay($overlay_file, $position = 'center', $opacity = 1, $x_offset = 0, $y_offset = 0) {
		
		// Load overlay image
		$overlay = new SimpleImage($overlay_file);
		
		// Convert opacity
		$opacity = $opacity * 100;
		
		// Determine position
		switch( strtolower($position) ) {
			
			case 'top left':
				$x = 0 + $x_offset;
				$y = 0 + $y_offset;
				break;
			
			case 'top right':
				$x = $this->width - $overlay->width + $x_offset;
				$y = 0 + $y_offset;
				break;
			
			case 'top':
				$x = ($this->width / 2) - ($overlay->width / 2) + $x_offset;
				$y = 0 + $y_offset;
				break;
			
			case 'bottom left':
				$x = 0 + $x_offset;
				$y = $this->height - $overlay->height + $y_offset;
				break;
			
			case 'bottom right':
				$x = $this->width - $overlay->width + $x_offset;
				$y = $this->height - $overlay->height + $y_offset;
				break;
			
			case 'bottom':
				$x = ($this->width / 2) - ($overlay->width / 2) + $x_offset;
				$y = $this->height - $overlay->height + $y_offset;
				break;
			
			case 'left':
				$x = 0 + $x_offset;
				$y = ($this->height / 2) - ($overlay->height / 2) + $y_offset;
				break;
			
			case 'right':
				$x = $this->width - $overlay->width + $x_offset;
				$y = ($this->height / 2) - ($overlay->height / 2) + $y_offset;
				break;
			
			case 'center':
			default:
				$x = ($this->width / 2) - ($overlay->width / 2) + $x_offset;
				$y = ($this->height / 2) - ($overlay->height / 2) + $y_offset;
				break;
			
		}
		
		$this->imagecopymerge_alpha($this->image, $overlay->image, $x, $y, 0, 0, $overlay->width, $overlay->height, $opacity);  
		
		return $this;
		
	}		
	
	// 
	// Text (adds text to an image)
	//
	//	$text - the text to add (required)
	//	$font_file - the font to use (required)
	//	$font_size - font size in points
	//	$color - font color in hex
	//	$position - 'center', 'top', 'left', 'bottom', 'right', 'top left', 
	//				'top right', 'bottom left', 'bottom right'
	//	$x_offset - horizontal offset in pixels
	//	$y_offset - vertical offset in pixels
	//
	public function text($text, $font_file, $font_size = '12', $color = '#000000', $position = 'center', $x_offset = 0, $y_offset = 0) {
		
		// todo - this method could be improved to support the text angle
		$angle = 0;
		$rgb = $this->hex2rgb($color);
		$color = imagecolorallocate($this->image, $rgb['r'], $rgb['g'], $rgb['b']);
		
		// Determine textbox size
		$box = imagettfbbox($font_size, $angle, $font_file, $text);
		if( !$box ) throw new Exception('Unable to load font: ' . $font_file);
		$box_width = abs($box[6] - $box[2]);
		$box_height = abs($box[7] - $box[1]);
		
		// Determine position
		switch( strtolower($position) ) {
			
			case 'top left':
				$x = 0 + $x_offset;
				$y = 0 + $y_offset + $box_height;
				break;
			
			case 'top right':
				$x = $this->width - $box_width + $x_offset;
				$y = 0 + $y_offset + $box_height;
				break;
			
			case 'top':
				$x = ($this->width / 2) - ($box_width / 2) + $x_offset;
				$y = 0 + $y_offset + $box_height;
				break;
			
			case 'bottom left':
				$x = 0 + $x_offset; 
				$y = $this->height - $box_height + $y_offset + $box_height;
				break;
			
			case 'bottom right':
				$x = $this->width - $box_width + $x_offset;
				$y = $this->height - $box_height + $y_offset + $box_height;
				break;
			
			case 'bottom':
				$x = ($this->width / 2) - ($box_width / 2) + $x_offset;
				$y = $this->height - $box_height + $y_offset + $box_height;
				break;
			
			case 'left':
				$x = 0 + $x_offset;
				$y = ($this->height / 2) - (($box_height / 2) - $box_height) + $y_offset;
				break;
			
			case 'right';
				$x = $this->width - $box_width + $x_offset;
				$y = ($this->height / 2) - (($box_height / 2) - $box_height) + $y_offset;
				break;
			
			case 'center':
			default:
				$x = ($this->width / 2) - ($box_width / 2) + $x_offset;
				$y = ($this->height / 2) - (($box_height / 2) - $box_height) + $y_offset;
				break;
			
		}
		
		imagettftext($this->image, $font_size, $angle, $x, $y, $color, $font_file, $text);
		
		return $this;
		
	}

	//
	// Outputs image without saving
	//
	public function output($format = null, $quality = null) {
		
		switch( strtolower($format) ) {
			
			case 'gif':
				$mimetype = 'image/gif';
				break;
			
			case 'jpeg':
			case 'jpg':
				$mimetype = 'image/jpeg';
				break;
			
			case 'png':
				$mimetype = 'image/png';
				break;
			
			default:
				$info = getimagesize($this->filename);
				$mimetype = $info['mime'];
				break;
		}
		
		// Output the image
		header('Content-Type: ' . $mimetype);
		
		switch( $mimetype ) {
			
			case 'image/gif':
				imagegif($this->image);
				break;
			
			case 'image/jpeg':
				if( $quality === null ) $quality = 85;
				$quality = $this->keep_within($quality, 0, 100);
				imagejpeg($this->image, null, $quality);
				break;
			
			case 'image/png':
				if( $quality === null ) $quality = 9;
				$quality = $this->keep_within($quality, 0, 9);
				imagepng($this->image, null, $quality);
				break;
			
			default:
				throw new Exception('Unsupported image format: ' . $this->filename);
				break;
		}
		
		// Since no more output can be sent, call the destuctor to free up memory
		$this->__destruct();
		
	}
	
	// Same as PHP's imagecopymerge() function, except preserves alpha-transparency in 24-bit PNGs
	// Courtest of: http://www.php.net/manual/en/function.imagecopymerge.php#88456
	private function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct ) { 
		$pct /= 100;
		// Get image width and height
		$w = imagesx($src_im);
		$h = imagesy($src_im);
		// Turn alpha blending off
		imagealphablending($src_im, false);
		// Find the most opaque pixel in the image (the one with the smallest alpha value)
		$minalpha = 127;
		for( $x = 0; $x < $w; $x++ ) {
			for( $y = 0; $y < $h; $y++ ) {
				$alpha = (imagecolorat( $src_im, $x, $y ) >> 24) & 0xFF;
				if( $alpha < $minalpha ) {
					$minalpha = $alpha;
				}
			}
		}
		// Loop through image pixels and modify alpha for each
		for( $x = 0; $x < $w; $x++ ) {
			for( $y = 0; $y < $h; $y++ ) {
				// Get current alpha value (represents the TANSPARENCY!)
				$colorxy = imagecolorat($src_im, $x, $y);
				$alpha = ($colorxy >> 24) & 0xFF;
				// Calculate new alpha
				if( $minalpha !== 127 ) {
					$alpha = 127 + 127 * $pct * ($alpha - 127) / (127 - $minalpha);
				} else {
					$alpha += 127 * $pct;
				}
				// Get the color index with new alpha
				$alphacolorxy = imagecolorallocatealpha($src_im, ($colorxy >> 16) & 0xFF, ($colorxy >> 8) & 0xFF, $colorxy & 0xFF, $alpha);
				// Set pixel with the new color + opacity
				if( !imagesetpixel($src_im, $x, $y, $alphacolorxy) ) return false;
			}
		}
		imagesavealpha($dst_im, true);
		imagealphablending($dst_im, true);
		imagesavealpha($src_im, true);
		imagealphablending($src_im, true);
		imagecopy($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h);
	} 
	
	//
	// Ensures $value is always within $min and $max range.
	// If lower, $min is returned. If higher, $max is returned.
	//
	private function keep_within($value, $min, $max) {
		if( $value < $min ) return $min;
		if( $value > $max ) return $max;
		return $value;
	}
	
	//
	// Returns the file extension of the specified file
	//
	private function file_ext($filename) {
		
		if( !preg_match('/\./', $filename) ) return '';
		
		return preg_replace('/^.*\./', '', $filename);
		
	}
	
	//
	// Converts a hex color value to its RGB equivalent
	//
	private function hex2rgb($hex_color) {
		
		if( $hex_color[0] == '#' ) $hex_color = substr($hex_color, 1);
		if( strlen($hex_color) == 6 ) {
			list($r, $g, $b) = array(
				$hex_color[0] . $hex_color[1],
				$hex_color[2] . $hex_color[3],
				$hex_color[4] . $hex_color[5]
			);
		} elseif( strlen($hex_color) == 3 ) {
			list($r, $g, $b) = array(
				$hex_color[0] . $hex_color[0],
				$hex_color[1] . $hex_color[1],
				$hex_color[2] . $hex_color[2]
			);
		} else {
			return false;
		}
		
	    return array(
			'r' => hexdec($r),
			'g' => hexdec($g),
			'b' => hexdec($b)
		);
		
	}
	
}