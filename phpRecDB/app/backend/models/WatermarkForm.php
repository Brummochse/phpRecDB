<?php

class WatermarkForm extends SettingsDbModel {

    public $enable = 0;
    public $text = '© phpRecDB';
    public $fontSize = 20;
    public $border = 0;
    public $align = 'center';
    public $valign = 'middle';
    public $fontStyle;
    public $color = '#00ff00';
    public $watermarkThumbnail = 0;
    public $resizeOnThumbnail = 0;
    
    public static $ALIGN_ENUM = array('center', 'left', 'right');
    public static $VALIGN_ENUM = array('middle', 'top', 'bottom');
    
    protected function givePropertiesDbMap() {
        return array(
            'enable' => Settings::WATERMARK_ENABLED,
            'text' => Settings::WATERMARK_TEXT,
            'fontSize' => Settings::WATERMARK_FONTSIZE,
            'border' => Settings::WATERMARK_BORDER,
            'align' => Settings::WATERMARK_ALIGN,
            'valign' => Settings::WATERMARK_VALIGN,
            'fontStyle' => Settings::WATERMARK_FONTSTYLE,
            'color' => Settings::WATERMARK_COLOR,
            'watermarkThumbnail' => Settings::WATERMARK_THUMBNAIL,
            'resizeOnThumbnail' => Settings::WATERMARK_THUMBNAIL_RESIZE,
        );
    }

    public function rules() {
        return array(
            array('text,enable,fontSize,border,align,valign,fontStyle,color,watermarkThumbnail,resizeOnThumbnail', 'required'),
            array('enable,watermarkThumbnail,resizeOnThumbnail', 'boolean'),
            array('text', 'length', 'max' => 255),
            array('color', 'length', 'is' => 7),
            array('border', 'numerical', 'integerOnly' => true),
            array('fontSize', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => 999),
        );
    }

    /**
     * SimpleImage lib accepts following positions:
     * 	 'center', 'top', 'left', 'bottom', 'right', 'top left', 'top right', 'bottom left', 'bottom right'
     */
    public function getSimpleImagePosition() {
        if (in_array($this->align, self::$ALIGN_ENUM) && in_array($this->valign, self::$VALIGN_ENUM)) {
            if ($this->valign == 'middle') {
                return $this->align; //'center','left','right'
            } else if ($this->align == 'center') {
                return $this->valign;  //'top','bottom'
            } else {
                return $this->valign . ' ' . $this->align; //'top left', 'top right', 'bottom left', 'bottom right'
            }
        }
    }

    public function calcSimpleImageXOffset() {
        if ($this->align == 'right') {
            return -$this->border;
        }
        return $this->border;
    }

    public function calcSimpleImageYOffset() {
        if ($this->valign == 'bottom') {
            return -$this->border;
        }
        return $this->border;
    }
}
?>
