<?php

/**
 * This is the model class for table "recordings".
 *
 * The followings are the available columns in table 'recordings':
 * @property int $id
 * @property int $size
 * @property int $concerts_id
 * @property int $visible
 * @property string $sourceidentification
 * @property int rectypes_id
 * @property int $sources_id
 * @property int $media_id
 * @property float $sumlength
 * @property string $summedia
 * @property int $quality
 * @property string $setlist
 * @property string $notes
 * @property string $lastmodified
 * @property string $created
 * @property string $sourcenotes
 * @property string $taper
 * @property string $transferer
 * @property int $tradestatus_id
 * @property string $hiddennotes
 * @property string $userdefined1
 * @property string $userdefined2
 * @property string $codec
 *
 * The followings are the available model relations:
 * @property Screenshot[] $screenshots
 * @property Youtube[] $youtubes
 * @property Audio $audio
 * @property Concert $concert
 * @property Source $source
 * @property Rectype $rectype
 * @property Medium $medium
 * @property Tradestatus $tradestatus
 * @property Sublist[] $sublists
 * @property Sublistassignment[] $sublistassignments
 * @property Video $video
 * @property Youtube[] $youtubesamples
 */
class Record extends CActiveRecord {
    
    /**
     * Returns the static model of the specified AR class.
     * @return Record the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'recordings';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('concerts_id', 'required'),
            array('visible, rectypes_id,  summedia, quality, size', 'numerical', 'integerOnly' => true),
            array('sumlength', 'numerical', 'integerOnly' => false),
            array('concerts_id, sources_id, media_id, tradestatus_id', 'length', 'max' => 10),
            array('sourceidentification, taper, transferer, userdefined1, userdefined2', 'length', 'max' => 255),
            array('setlist, notes, lastmodified, created, sourcenotes, hiddennotes, codec', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, concerts_id, visible, sourceidentification, rectypes_id, sources_id, media_id, sumlength, summedia, quality, setlist, notes, lastmodified, created, sourcenotes, taper, transferer, tradestatus_id, hiddennotes, codec, userdefined1, userdefined2', 'safe', 'on' => 'search'),
        );
    }

    public function getSemioticSystem() : string {
        if ($this->video!=null) {
            return VA::vaIdToStr(VA::VIDEO);
        }
        if ($this->audio!=null) {
            return VA::vaIdToStr(VA::AUDIO);
        }
        return VA::vaIdToStr(VA::UNDEFINED);
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'audio' => array(self::HAS_ONE, 'Audio', 'recordings_id'),
            'concert' => array(self::BELONGS_TO, 'Concert', 'concerts_id'),
            'source' => array(self::BELONGS_TO, 'Source', 'sources_id'),
            'rectype' => array(self::BELONGS_TO, 'Rectype', 'rectypes_id'),
            'medium' => array(self::BELONGS_TO, 'Medium', 'media_id'),
            'tradestatus' => array(self::BELONGS_TO, 'Tradestatus', 'tradestatus_id'),
            'sublists' => array(self::MANY_MANY, 'Sublist', 'sublists(recordings_id, lists_id)'),
            'video' => array(self::HAS_ONE, 'Video', 'recordings_id'),
            'youtubes' => array(self::HAS_MANY, 'Youtube', 'recordings_id'),
            'sublistassignments' => array(self::HAS_MANY, 'Sublistassignment', 'recordings_id'),
            'screenshots' => array(self::HAS_MANY, 'Screenshot', 'video_recordings_id'),
            'recordvisit' => array(self::HAS_ONE,'Recordvisit','record_id')
         );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'hiddennotes'=>'Hidden Notes',
            'codec'=>'Codec',
            'userdefined1'=>Yii::app()->settingsManager->getPropertyValue(Settings::USER_DEFINED1_LABEL),
            'userdefined2'=>Yii::app()->settingsManager->getPropertyValue(Settings::USER_DEFINED2_LABEL),
            'id' => 'ID',
            'concerts_id' => 'Concerts',
            'visible' => 'Visible',
            'sourceidentification' => 'Source Identification',
            'rectypes_id' => 'Record Type',
            'sources_id' => 'Source',
            'media_id' => 'Media',
            'sumlength' => 'Length (min.sec)',
            'summedia' => 'count of Media',
            'quality' => 'Quality',
            'setlist' => 'Setlist',
            'notes' => 'Notes',
            'lastmodified' => 'Lastmodified',
            'created' => 'Created',
            'sourcenotes' => 'Sourcenotes',
            'taper' => 'Taper',
            'transferer' => 'Transferer',
            'tradestatus_id' => 'Trade Status',
            'size' => 'File Size (in MB)',
        );
    }

     /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('concerts_id', $this->concerts_id, true);
        $criteria->compare('visible', $this->visible);
        $criteria->compare('sourceidentification', $this->sourceidentification, true);
        $criteria->compare('rectypes_id', $this->rectypes_id);
        $criteria->compare('sources_id', $this->sources_id, true);
        $criteria->compare('media_id', $this->media_id, true);
        $criteria->compare('sumlength', $this->sumlength, true);
        $criteria->compare('summedia', $this->summedia, true);
        $criteria->compare('quality', $this->quality, true);
        $criteria->compare('setlist', $this->setlist, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('lastmodified', $this->lastmodified, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('sourcenotes', $this->sourcenotes, true);
        $criteria->compare('taper', $this->taper, true);
        $criteria->compare('size', $this->size);
        $criteria->compare('transferer', $this->transferer, true);
        $criteria->compare('tradestatus_id', $this->tradestatus_id, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }
    
    public function __toString() {
        $visible = $this->visible;
        $quality = $this->quality;
        $sourceIdentification = $this->sourceidentification;
        $rectype = $this->rectype != null ? $this->rectype->shortname : "";
        $source = $this->source != null ? $this->source->shortname : "";
        $media = $this->medium != null ? $this->medium->shortname : "";
        $length = $this->sumlength;
        $summedia = $this->summedia;

        $sublists = array();
        foreach ($this->sublists as $sublist) {
            $sublists[] = $sublist->label;
        }

        return Record::generateString($length, $quality, $rectype, $media, $summedia, $source, $sourceIdentification, $visible, $sublists);
    }

    public static function generateString(float $length = null, $quality = null, $rectype = null, $media = null, $summedia = null, $source = null, $sourceIdentification = null, $visible = null, $sublists = array()) {
        $outStr = "";
        if (!empty($length))
            $outStr.=$length . "min";
        if (!empty($quality))
            $outStr.=' ' . $quality . '/10';
        if (!empty($rectype))
            $outStr.=' ' . $rectype;
        if (!empty($media)) {
            if (!empty($summedia))
                $outStr.=' ' . $summedia . 'x';
            $outStr.=' ' . $media;
            if (!empty($summedia) && $summedia > 1)
                $outStr.='s';
        }
        if (!empty($source))
            $outStr.=' (' . $source . ')';
        if (!empty($sourceIdentification))
            $outStr.=' ' . $sourceIdentification;
        if (count($sublists) > 0) {
            $outStr.='______(SUBLISTS: ___' . implode('___ , ___', $sublists) . '___)';
        }

        return $outStr;
    }

    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'lastmodified',
            )
        );
    }

    /**
     * deletes a record and cascades the deletion
     */
    public function delete() {

        foreach ($this->screenshots as $screenshot) {
            $screenshot->delete();
        }
        foreach ($this->youtubes as $youtube) {
            $youtube->delete();
        }

        if ($this->video != NULL) {
            $this->video->delete();
        } else if ($this->audio != NULL) {
            $this->audio->delete();
        } else {
            //should never happen
            throw new Exception("Record | delete : record has no video and no audio");
        }

        parent::delete();
    }

    public function assignRecordToSublist($recordId, $sublistId) {
        $existingAssignment = Sublistassignment::model()->findByAttributes(array('lists_id' => $sublistId, 'recordings_id' => $recordId));

        if ($existingAssignment == NULL) { //assignment does not exist
            $sublistAssignment = new Sublistassignment();
            $sublistAssignment->lists_id = $sublistId;
            $sublistAssignment->recordings_id = $recordId;
            return $sublistAssignment->save();
        }
        return false;
    }

}