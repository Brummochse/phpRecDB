<?php

interface UpdateAspectHandler
{
    public function process(Record $record, string $value);
}

class RecordEndpoint extends RestEndpoint
{

    private $updateHandlers = [];

    public function __construct()
    {
        $this->updateHandlers['length']=$this->createLengthHandler();
        $this->updateHandlers['aspectRatio']=$this->createAspectRatioHandler();
        $this->updateHandlers['width']=$this->createWidthHandler();
        $this->updateHandlers['height']=$this->createHeightHandler();
        $this->updateHandlers['size']=$this->createSizeHandler();
        $this->updateHandlers['screenshot']=$this->createScreenshotHandler();
        $this->updateHandlers['type']=$this->createTypeHandler();
        $this->updateHandlers['mediaCount']=$this->createMediaCountHandler();
        $this->updateHandlers['menu']=$this->createMenuHandler();
        $this->updateHandlers['chapters']=$this->createChaptersHandler();
        $this->updateHandlers['frameRate']=$this->createFramerateHandler();
        $this->updateHandlers['format']=$this->createFormatHandler();
        $this->updateHandlers['codec']=$this->createCodecHandler();
    }

    private function createCodecHandler(): UpdateAspectHandler
    {
        return new class() implements UpdateAspectHandler{
            public function process(Record $record, string $value)
            {
                $record->codec=$value;
            }
        };
    }

    private function createChaptersHandler(): UpdateAspectHandler
    {
        return new class() implements UpdateAspectHandler{
            public function process(Record $record, string $value)
            {
                $record->video->chapters=(int)$value;
                $record->video->save();
            }
        };
    }

    private function createFormatHandler(): UpdateAspectHandler
    {
        return new class() implements UpdateAspectHandler{
            public function process(Record $record, string $value)
            {
                $videoformats = Videoformat::model()->findAllByAttributes(array('label' => $value));
                if (count($videoformats)>0) {
                    $record->video->videoformat_id=$videoformats[0]->id;
                    $record->video->save();
                } else {
                    throw new InvalidArgumentException ("video format ".$value." does not exist.");
                }
            }
        };
    }

    private function createFramerateHandler(): UpdateAspectHandler
    {
        return new class() implements UpdateAspectHandler{
            public function process(Record $record, string $value)
            {
                $record->video->framerate=(float)$value;
                $record->video->save();
            }
        };
    }

    private function createMenuHandler(): UpdateAspectHandler
    {
        return new class() implements UpdateAspectHandler{
            public function process(Record $record, string $value)
            {
                $record->video->menu=(int)$value;
                $record->video->save();
            }
        };
    }

    private function createMediaCountHandler(): UpdateAspectHandler
    {
        return new class() implements UpdateAspectHandler{
            public function process(Record $record, string $value)
            {

                $record->summedia=(int)$value;
            }
        };
    }

    private function createTypeHandler(): UpdateAspectHandler
    {
        return new class() implements UpdateAspectHandler{
            public function process(Record $record, string $value)
            {
                $mediaTypes = Helper::findAllBySomeAttributes(Medium::model(), array(
                    'shortname' => $value,
                    'label' => $value)
                );

                if (count($mediaTypes)>0) {
                    $record->media_id=$mediaTypes[0]->id;
                } else {
                    throw new InvalidArgumentException ("media type ".$value." (shortname) does not exist.");
                }
            }
        };
    }

    private function createScreenshotHandler(): UpdateAspectHandler
    {
        return new class() implements UpdateAspectHandler {

            public function process(Record $record, string $value)
            {
               //write to tempfile and create a "fake" CUploadedFile
                $fSetup = tmpfile();
                fwrite($fSetup,base64_decode($value));
                fseek($fSetup,0);

                $metaDatas = stream_get_meta_data($fSetup);
                $tmpFilename = $metaDatas['uri'];
                $filesize = filesize($tmpFilename);
                $error=0;//=OK

                $CUploadedFile = new CUploadedFile(basename($tmpFilename).'.jpg',$tmpFilename,'image/jpeg',$filesize,$error);

                /** @var ScreenshotManager $screenshotManager */
                $screenshotManager = Yii::app()->screenshotManager;
                $screenshotManager->processUploadedScreenshots([$CUploadedFile], $record->id);
            }
        };
    }

    private function createSizeHandler(): UpdateAspectHandler
    {
        return new class() implements UpdateAspectHandler{
            public function process(Record $record, string $value)
            {
                $sizeInBytes=(int)$value;
                $sizeInKB=$sizeInBytes/1024;
                $sizeInMB=$sizeInKB/1024;
                $record->size=(int)$sizeInMB;
            }
        };
    }
    private function createWidthHandler(): UpdateAspectHandler
    {
        return new class() implements UpdateAspectHandler{
            public function process(Record $record, string $value)
            {
                $record->video->width=(int)$value;
                $record->video->save();

            }
        };
    }
    private function createHeightHandler(): UpdateAspectHandler
    {
        return new class() implements UpdateAspectHandler{
            public function process(Record $record, string $value)
            {
                $record->video->height=(int)$value;
                $record->video->save();

            }
        };
    }

    private function createAspectRatioHandler(): UpdateAspectHandler
    {
        return new class() implements UpdateAspectHandler{
            public function process(Record $record, string $value)
            {
                $aspectRatios = Aspectratio::model()->findAllByAttributes(array('label' => $value));
                if (count($aspectRatios)>0) {
                    $record->video->aspectratio_id=$aspectRatios[0]->id;
                    $record->video->save();
                } else {
                    throw new InvalidArgumentException ("aspect ratio ".$value." does not exist.");
                }
            }
        };
    }

    private function createLengthHandler(): UpdateAspectHandler
    {
        return new class() implements UpdateAspectHandler{
            public function process(Record $record, string $value)
            {
                $ms = (int)$value;
                $minutes = floor($ms / 60000);
                $seconds = floor(($ms % 60000) / 1000);
                $lengthFormatted = $minutes . '.' . $seconds;
                $record->sumlength = $lengthFormatted;
            }
        };
    }

    public function getName(): string
    {
        return 'records';
    }

    public function view(): array
    {
        $recordId = (int)$_GET['id'];

        /** @var Record $recordModel */
        $recordModel = Record::model()->findByPk($recordId);

        if ($recordModel != null) {
            /** @var Concert $concertModel */
            $concertModel = $recordModel->concert;

            $recordStr = $recordModel->__toString();
            $concertStr = $concertModel->__toString();
            $artist = $concertModel->artist->name;

            $result = [
                "recordDescription" => $recordStr,
                'concertDescription' => $concertStr,
                'artist' => $artist,
                'semioticSystem' => $recordModel->getSemioticSystem(),
            ];
            return $result;
        }
        return [];
    }


    public function update(): array
    {
        $recordId = (int)$_GET['id'];

        /** @var Record $recordModel */
        $recordModel = Record::model()->findByPk($recordId);

        $returnArray=[];

        if ($recordModel != null) {

            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            /** @var UpdateAspectHandler $handler */
            foreach ($this->updateHandlers as $aspectName => $handler) {
                if (isset($data[$aspectName])) {
                    try {
                        if (strlen($data[$aspectName])>0) {
                            $handler->process($recordModel, $data[$aspectName]);
                        }
                    } catch (InvalidArgumentException $e) {
                        $returnArray[$aspectName] = $e->getMessage();
                    }

                }
            }
            $recordModel->save();
        } else {
            $returnArray["error"] = "record not found";
        }
        return $returnArray;
    }

}