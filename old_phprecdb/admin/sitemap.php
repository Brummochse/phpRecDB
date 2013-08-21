<?php
include_once dirname(__FILE__) . "/../constants.php";
include_once (Constants :: getFunctionsFolder() . 'function.createListMenuPoints.php');

$sites = array (
        'Add Record' => 'addRecordingWizard.php',
        'Manage All Records' => 'AdminList.php',
        'Manage All Videos' => 'AdminListVideo.php',
        'Manage All Audios' => 'AdminListAudio.php',

        'aspectratio' => 'cruds/aspectratio.php',
        'media' => 'cruds/media.php',
        'rectypes' => 'cruds/rectypes.php',
        'sources' => 'cruds/sources.php',
        'tradestatus' => 'cruds/tradestatus.php',
        'videoformat' => 'cruds/videoformat.php',

        'User Management' => 'user/adminuser.php',
        'Lists' => 'cruds/lists.php',
        'Signature Creator' => 'signature.php',
        'Statistics' => 'statistics.php',

        'Add Concert' => 'addConcert.php',
        'edit Concert' => 'editConcert.php',
        'edit Record' => 'editRecord.php',
        'delete Record' => 'deleteRecord.php',
        'screenshots' => 'screenshots.php',
        'youtube' => 'youtube.php',

        'Append Recording' => 'appendRecording.php',

        'Watermark' => 'watermark.php',
        'Compression' => 'screenCompr.php',

        'db.etree' => 'dbEtreeImport.php'

);


$menuStructure = array (
        'Records' => array (
                'Add Record',
                'Manage All Records',
                'Manage All Videos',
                'Manage All Audios',
                'Manage Lists' => createListMenuPoints($sites)
        ),
        'Configuration' => array (
                'User Management',
                'Lists',
                'Signature Creator',
                'Statistics',
                'Screenshots' => array (
                        'Watermark',
                        'Compression'
                ) ,
                'List Presets' => array (
                        'aspectratio',
                        'media',
                        'rectypes',
                        'sources',
                        'tradestatus',
                        'videoformat'
                ),
                'Import from' => array (
                        'db.etree'
                )
        )
);
?>

