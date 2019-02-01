<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['wwwUrl']; ?>/css/font-awesome.min.css" />
<div class="wantlist">
<?php

class Want {
    public $artist;
    public $date;
    public $location;
    public $comment;
    public $pictureFolder;
    public $pictures = array();
    public $youtube;
}

function convertToUtf8($innerHtml) {
    $innerHtml= mb_convert_encoding($innerHtml, 'UTF-8',mb_detect_encoding($innerHtml, 'UTF-8, ISO-8859-1', true));
    return '<td>'.($innerHtml).'</td>';
}

function parseWantsFromCSV() {
    $wants = array();
    $file_handle = fopen( dirname(__FILE__). DIRECTORY_SEPARATOR."wants.csv", "r");
    $i=0;
    while (!feof($file_handle)) {

        $parts = fgetcsv($file_handle,0,",");
        if (count($parts)>=3) {
            $want = new Want();
            $want->artist = $parts[0];
            $want->date = $parts[1];
            $want->location = $parts[2];
            $want->comment = $parts[3];

            $want->pictureFolder = $parts[4];
            if (!empty($want->pictureFolder)) {
                $allFiles = scandir(dirname(__FILE__). "/screens/".$want->pictureFolder); //Ordner "files" auslesen
                 foreach ($allFiles as $file) {
                    if ($file != "." && $file != "..") {
                         $want->pictures[]=$file;
                    }
                };
            }
            $want->youtube = $parts[5];

            $wants[]=$want;
        }
        if ($i++>60) break;
    }
    fclose($file_handle);
    
    return $wants;
}

$wants=parseWantsFromCSV();

$accordionData=array();
$counter=0;
foreach ($wants as $want) {
    $recStr= '<b>'.convertToUtf8($want->artist).'</b> '.convertToUtf8($want->date).' '.convertToUtf8($want->location);
    $detailContentStr=  nl2br($want->comment);

    foreach ($want->pictures as $picture) {
        $publishedPictureLink=Yii::app()->getAssetManager()->publish(dirname(__FILE__). "/screens/".$want->pictureFolder.'/'.$picture);
        $detailContentStr.= '<br>'. CHtml::link($picture, $publishedPictureLink,array("rel" => "group".$counter, "class"=>"screenshot"));
    }

    if (!empty($want->youtube)) {
        $detailContentStr.= '<br>'. CHtml::link("youtube", $want->youtube);


    }

    $accordionData[$recStr]=$detailContentStr;

    $counter++;
}

$this->widget('zii.widgets.jui.CJuiAccordion', array(
    'themeUrl' => Yii::app()->getThemeManager()->getBaseUrl(),
    'theme' => Yii::app()->getTheme()->name . "/css",
    'panels'=>$accordionData,
    'options'=>array(
        'collapsible'=>true,
        'active'=>false,
    ),
    'htmlOptions'=>array(
       // 'style'=>'width:500px;'
    ),
));

$this->widget('application.extensions.fancybox.AlFancybox', array('targetDOM' => '.screenshot'));

?>
</div>
