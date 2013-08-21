<?php
include_once Constants::getFunctionsFolder() . 'function.getRelativePathTo.php';
include_once Constants::getClassFolder() . 'StateMsgHandler.php';
include_once Constants::getClassFolder() . 'DbEtreeImporter.php';

class ContentPage extends ContentPageSmarty {

    private $uploadFileName='csvfile';
    private $fileMaxSize=10485760; //10MB
    private $standardSteps=50;

    public function getPageTemplateFileName() {
        return "dbEtreeImport.tpl";
    }

    public function execute($smarty,$linky) {
        $smarty->assign("relativeTemplatesPath", getRelativePathTo(Constants::getTemplateFolder()));
        $smarty->assign('uploadFileName',$this->uploadFileName);
        $smarty->assign('recordsPerStep',$this->standardSteps);

        $msgHandler=StateMsgHandler::getInstance();

        if (isset ($_POST['nextRow']) ) {
            $nextRow=$_POST['nextRow'];
            $mediasVideo=$_POST['mediaVideo'];
            $mediasAudio=$_POST['mediaAudio'];
            $recordsPerStep=$_POST['recordsPerStep'];

            $dbEtreeImporter=new DbEtreeImporter(Constants::getCsvImportPath());
            $dbEtreeImporter->setMediasAudio($mediasAudio);
            $dbEtreeImporter->setMediasVideo($mediasVideo);

            $videoOrAudio=null;
            if (isset ($_POST['videooraudio']) ) {
                $videoOrAudio=$_POST['videooraudio'];
                if ($videoOrAudio=='video') {
                    $videoOrAudio=VIDEO;
                } else {
                    $videoOrAudio=AUDIO;
                }
            }

            if ($dbEtreeImporter->parseCsvFile($nextRow,$recordsPerStep,true,$videoOrAudio)==false) {
                $recordinfo=$dbEtreeImporter->getLastRecordInfo();
                $smarty->assign('recordinfo',$recordinfo);
            }

            $smarty->assign('log',$dbEtreeImporter->getLog());

            $recordCount=$dbEtreeImporter->getCsvRecordsCount();
            $alreadyAdded=$dbEtreeImporter->getLastAddedRecordNumber();

            if ($alreadyAdded<$recordCount) {

                $smarty->assign('recordsPerStep',$recordsPerStep);
                $smarty->assign('mediaVideo',$dbEtreeImporter->getMediasVideo());
                $smarty->assign('mediaAudio',$dbEtreeImporter->getMediasAudio());
                $smarty->assign('recordsCount',$recordCount);
                $smarty->assign('nextRow',$alreadyAdded);
            } else {
                $this->deleteCsvTempFile();
                $msgHandler-> addStateMsg('cvs file imported finished.');
            }
        } else {
            
            if (isset($_FILES[$this->uploadFileName])) {
                $csvFile=$_FILES[$this->uploadFileName];
                $fileSize=$csvFile['size'];

                if($fileSize<$this->fileMaxSize && $fileSize>0) {
                    $this->deleteCsvTempFile();

                    move_uploaded_file($csvFile['tmp_name'], Constants::getCsvImportPath());
                    $msgHandler-> addStateMsg('csv file uploaded');

                    $dbEtreeImporter=new DbEtreeImporter(Constants::getCsvImportPath());
                    $smarty->assign('mediaVideo',$dbEtreeImporter->getMediasVideo());
                    $smarty->assign('mediaAudio',$dbEtreeImporter->getMediasAudio());
                    $smarty->assign('recordsCount',$dbEtreeImporter->getCsvRecordsCount());
                    $smarty->assign('nextRow',0);
                }
                else {
                    $msgHandler-> addStateMsg('error uploading csv import file');
                }
            }
        }

    }

    private function deleteCsvTempFile() {
        if (file_exists(Constants::getCsvImportPath())) {
            unlink(Constants::getCsvImportPath());
        }
    }

}
?>


