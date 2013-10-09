<?php

return array(
    'screenshotsPath' => $phpRecDbPath . DIRECTORY_SEPARATOR . 'screenshots',
    'thumbnailWidth' => 250,
    'fontFolder' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'fonts',
    'signatureFont' => 'LiberationSans-Regular.ttf',
    'signatureFontBold' => 'LiberationSans-Bold.ttf',
    
    'watermarkTestScreenshot' => 'watermarkTestScreenshot.png',
    'watermarkTestThumbnail' => 'watermarkTestThumbnail.png',
   
    'miscPath' => $phpRecDbPath . DIRECTORY_SEPARATOR . 'misc',
    'miscUrl' => $phpRecDbUrl .(empty($phpRecDbUrl)?'':'/'). 'misc',
   
    'emptyScreenshot' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'emptyScreenshot.png',
);