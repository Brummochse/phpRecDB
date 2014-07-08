<?php

return array(
    'screenshotsUrl' => $phpRecDbUrl .(empty($phpRecDbUrl)?'':'/'). 'screenshots',
    'version' => '1.1',
    'wwwUrl' => $phpRecDbUrl .(empty($phpRecDbUrl)?'':'/') . 'app/www',
    'artistMenuMaxChunkSize'=>20
);