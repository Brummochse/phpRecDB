<?php

interface UpdateAspectHandler
{
    public function process(Record $record, string $value);
}

class RecordEndpoint extends RestEndpoint
{

    private array $updateHandlers = [];

    public function __construct()
    {
        $this->updateHandlers['length']=$this->createLengthHandler();
        $this->updateHandlers['aspectRatio']=$this->createAspectRatioHandler();
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
                'artist' => $artist
            ];
            return $result;
        }
        return [];
    }

    public function list(): array
    {

        $aspectRatio = Aspectratio::model()->findAllByAttributes(array('label' => '16:9'));
        $jsonData = '{"length":"700","snapshots":{"file1.png":"test1","datei.jpg":"blabla"}}';


//        $person = json_decode($jsonData, RecordRestModel::class);

        $res = print_r($aspectRatio, true);
//
        return ["ergebnis" => [$res]];
        return [];
    }


    public function create(): array
    {
        $content = file_get_contents("php://input");
        $file = "create.txt";
        $this->writeFileToRoot($file, $content);
        return [1 => 2];
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
                        $handler->process($recordModel,$data[$aspectName]);
                    } catch (InvalidArgumentException $e) {
                        $returnArray[$aspectName] = $e->getMessage();
                    }

                }
            }
            $recordModel->save();


            $returnArray["status"] = "success";
        } else {
            $returnArray["status"] = "record not found";
        }
        return $returnArray;
    }


    public function writeFileToRoot(string $file, string $content)
    {
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/' . $file, "wb");
        fwrite($fp, $content);
        fclose($fp);
    }




}