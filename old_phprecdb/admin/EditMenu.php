<?php

class EditMenu {

    private static function createLinkArray() {
        $linkinfos=array('screenshotsEditorLink'=>'screenshots',
                'concertEditLink'=>'edit Concert',
                'editRecordLink'=>'edit Record',
                'youtubeEditorLink'=>'youtube');
        return $linkinfos;
    }

    public static function addEditMenuLinksToSmarty($smarty,$linky,$recordingId) {
        $selectedPage=$linky->decryptName();

        foreach (self::createLinkArray() as $smartyName => $pageName) {
            if ($pageName!=$selectedPage) {
                $smarty->assign($smartyName, $linky->encryptName($pageName, array (
                        'id' => $recordingId
                )));
            }
        }

        $isVideo = Helper::recordingIsVideo($recordingId);
        if ($isVideo) {
            $smarty->assign('videoOrAudio', 'video');
        }else {
            $smarty->assign('videoOrAudio', 'audio');
        }

//        $smarty->assign('screenshotsEditorLink', $linky->encryptName('screenshots', array (
//                'id' => $recordingId
//        )));
//        $smarty->assign('concertEditLink', $linky->encryptName('edit Concert', array (
//                'id' => $recordingId
//        )));
//        $smarty->assign('editRecordLink', $linky->encryptName('edit Record', array (
//                'id' => $recordingId
//        )));
//        $smarty->assign('youtubeEditorLink', $linky->encryptName('youtube', array (
//                'id' => $recordingId
//        )));
    }
}
?>
