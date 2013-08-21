<?php

class VA {

    const UNDEFINED = -1;
    const VIDEO_AND_AUDIO = 0;
    const VIDEO = 1;
    const AUDIO = 2;


    private static $strMap = Array(
        self::UNDEFINED => 'UNDEFINED',
        self::VIDEO => 'Video',
        self::AUDIO => 'Audio',
        self::VIDEO_AND_AUDIO => 'Video and Audio'
    );

    public static function vaIdToStr($vaId) {
        if (isset(self::$strMap[$vaId]))
            return self::$strMap[$vaId];

        throw new Exception("unexpected VA value:" . $vaId);
    }

}

?>
