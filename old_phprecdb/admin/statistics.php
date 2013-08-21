<?php


class ContentPage extends ContentPageSmarty {

    public function getPageTemplateFileName() {
        return "statistics.tpl";
    }

    public function execute($smarty,$linky) {
        error_reporting(E_ALL | E_STRICT);
        $dirIter = new RecursiveDirectoryIterator('../screenshots');
        $recursiveIterator = new RecursiveIteratorIterator($dirIter,
                RecursiveIteratorIterator::SELF_FIRST,
                RecursiveIteratorIterator::CATCH_GET_CHILD);

        $files= 0;
        $size= 0;

        foreach($recursiveIterator as $element) {
            switch($element->getType()) {
                case 'file':
                    $files++;
                    $size += $element->getSize();
                    break;
            }
        }

        $sizeInMb=$size/1024/1024;

        $smarty->assign('size', $sizeInMb);
        $smarty->assign('screenshotCount', $files);

    }

}
?>


