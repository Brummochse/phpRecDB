<?php


class ImportController extends AdminController
{

    private const ALLOWED_COUNTIRES=['Argentina','Australia','Austria','Belgium','Brazil','Bulgaria','Canada','Chile','Croatia','Czech Republic',
        'Denmark','Finland','France','Germany','Greece','Hungary','Iceland','India','Ireland','Israel','Italy','Japan'
        ,'Kazakhstan','Korea','Malaysia','Mexico','Netherlands','New Zealand','Norway','Peru','Poland','Portugal','Puerto Rico',
        'Romania','Russia','Scotland','Serbia','Slovakia','Slovenia','South Korea','Spain','Sweden',
        'Switzerland','Thailand','Turkey','UK','USA','Ukraine'];

    public function actionParse()
    {
        $this->parseXmlFile();
    }

    public function parseXmlFile(): void
    {
        $doc = new DOMDocument;

        $doc->preserveWhiteSpace = false;

        $doc->load(Yii::app()->getBasePath() . '/../../../source/source.xml');

        $xpath = new DOMXPath($doc);


        $query = "/table/tbody/tr[@class='artistcell']/td/span[@class='artist']";

        $entries = $xpath->query($query);

        $records = [];

        $currentShow = null;
        foreach ($entries as $entry) {

            /** @var DOMNode $entry */
            $currentArtist = $this->getArtistModel(trim($entry->nodeValue));

            $artistNode = $entry->parentNode->parentNode;
            $nodeJumper = $artistNode;
            $rowSpanWalkerCount = 0;
            while ($nodeJumper->nextSibling != null && $nodeJumper->nextSibling->attributes->getNamedItem("class")->textContent != 'artistcell') {
                $nodeJumper = $nodeJumper->nextSibling;

                $rowSpanAttr = $nodeJumper->childNodes->item(0)->attributes->getNamedItem("rowspan");
                if ($rowSpanAttr != null) {
                    $rowSpanWalkerCount = (int)$rowSpanAttr->textContent;
                }

                $currentRecord = new Record();
                $records[] = $currentRecord;

                if ($rowSpanAttr != null || ($rowSpanWalkerCount == 0)) {
                    $date = trim($nodeJumper->childNodes->item(0)->textContent);
                    $locationStr = $nodeJumper->childNodes->item(1)->textContent;
                    $currentShow = $this->getConcertModel($currentArtist, $date, $locationStr);

                    $currentRecord->sumlength = $this->parseLengthStr($nodeJumper->childNodes->item(2)->textContent);
                    $currentRecord->quality = $this->parseQualityStr($nodeJumper->childNodes->item(3)->textContent);
                    $rectypeStr = $nodeJumper->childNodes->item(4)->textContent;

                    $mixedStr = $nodeJumper->childNodes->item(5)->textContent;

                    $currentRecord->sourcenotes = $nodeJumper->childNodes->item(6)->textContent;

                } else {
                    $currentRecord->sumlength = $this->parseLengthStr($nodeJumper->childNodes->item(0)->textContent);
                    $currentRecord->quality = $this->parseQualityStr($nodeJumper->childNodes->item(1)->textContent);
                    $rectypeStr = $nodeJumper->childNodes->item(2)->textContent;
                    $mixedStr = $nodeJumper->childNodes->item(3)->textContent;
                    $currentRecord->sourcenotes = $nodeJumper->childNodes->item(4)->textContent;
                }

                $rectype = $this->findRectype($rectypeStr);
                $currentRecord->rectype = $rectype;
                $currentRecord->rectypes_id = $this->getModelId($rectype);

                $medium = $this->findMediumFromMixedStr($mixedStr);
                $currentRecord->medium =$medium;
                $currentRecord->media_id =$this->getModelId($medium);

                $source = $this->findSourceFromMixedStr($mixedStr);
                $currentRecord->source = $source;
                $currentRecord->sources_id = $this->getModelId($source);

                $currentRecord->concert = $currentShow;
                $currentRecord->concerts_id = $this->getModelId($currentShow);

                $video = new Video();
                $video->record=$currentRecord;
                $currentRecord->save();
                $id = $this->getModelId($currentRecord);
                $video->recordings_id= $id;

                $videoformat = $this->findVideoformatFromMixedStr($mixedStr);
                $video->videoformat = $videoformat;
                $video->videoformat_id = $this->getModelId($videoformat);

                $video->save();


                if ($rowSpanWalkerCount > 0) {
                    $rowSpanWalkerCount--;
                }
            }
        }

        foreach ($records as $record) {
            $label = $record->video->videoformat->label;
            echo $record->concert->artist->name . '  ' . $record->concert . '   ' . $record . '  ' . $label . '<br><br>';

        }
    }



    private function findRectype(string $rectypeStr, int $bootlegtype = VA::VIDEO): ?Rectype
    {
        $rectypes = Rectype::model()->findAll();
        $filtered_rectypes = array_filter($rectypes, static fn(Rectype $rt): bool => $rt->shortname == $rectypeStr and $rt->bootlegtypes_id == $bootlegtype);
        if (count($filtered_rectypes) === 1) {
            return reset($filtered_rectypes);
        }
        return null;

    }

    private function parseQualityStr(string $qualityStr): ?int
    {
        $qualityStr=trim($qualityStr);

        if (is_numeric($qualityStr)) {
            return (int)$qualityStr;
        }

        $strpos = strpos($qualityStr, '/');
        $quality = substr($qualityStr, 0, $strpos);
        if (is_numeric($quality)) {
            return (int)$quality;
        }
        return null;
    }

    private function parseLengthStr(string $lengthStr): ?float
    {
        $lengthStr=trim($lengthStr);
        if (strlen($lengthStr) === 0) {
            return null;
        }
        $strpos = strpos($lengthStr, ' ');
        $length = (float)substr($lengthStr, 0, $strpos);
        return $length;
    }


    private function getModelId(?CActiveRecord $model) :?int {
        if ($model !== null) {
            return $model->id;
        }
        return null;
    }

    private function findMediumFromMixedStr(string $mixedStr, int $bootlegtype = VA::VIDEO): ?Medium
    {
        $mediums = Medium::model()->findAll();
        $parts = explode(' ', $mixedStr);
        foreach ($parts as $part) {
            $part = trim($part);

            $filtered_mediums = array_filter($mediums, static fn(Medium $medium): bool => $medium->shortname == $part && $medium->bootlegtypes_id == $bootlegtype);

            if (count($filtered_mediums) === 1) {
                return reset($filtered_mediums);
            }

        }
        return null;
    }

    private function findSourceFromMixedStr(string $mixedStr, int $bootlegtype = VA::VIDEO): ?Source
    {
        $sources = Source::model()->findAll();
        $parts = explode(' ', $mixedStr);
        foreach ($parts as $part) {
            $part = trim($part);

            $filtered_sources = array_filter($sources, static fn(Source $source): bool => '(' . $source->shortname . ')' == $part and $source->bootlegtypes_id == $bootlegtype);
            if (count($filtered_sources) === 1) {
                return reset($filtered_sources);
            }

        }
        return null;
    }

    private function findVideoformatFromMixedStr(string $mixedStr): ?Videoformat
    {
        $formats = Videoformat::model()->findAll();
        $parts = explode(' ', $mixedStr);
        foreach ($parts as $part) {
            $part = trim($part);

            $filtered_formats = array_filter($formats, static fn(Videoformat $format): bool => $format->label == $part);
            if (count($filtered_formats) === 1) {
                return reset($filtered_formats);
            }

        }
        return null;
    }



    private function getConcertModel(Artist $currentArtist, string $date, string $locationStr): Concert
    {
        $newShow = new Concert();
        $newShow->artist = $currentArtist;
        $newShow->artists_id = $this->getModelId($currentArtist);
        $newShow->date = $date;

        $countryStr = $this->parseCountryFromLocationStr($locationStr);
        if ($countryStr!==null) {
            $country = $this->getCountryModel($countryStr);
            $newShow->country = $country;
            $newShow->countrys_id = $this->getModelId($country);

            $city = $this->getCityModel($locationStr, $country);
            $newShow->city= $city;
            $newShow->citys_id= $this->getModelId($city);

            $newShow->supplement = $this->parseSupplement($locationStr, $country);

        } else {
            $newShow->supplement = $locationStr;
        }

        $newShow->save();
        return $newShow;
    }

    private function parseSupplement(string $locationStr, Country $country) : string
    {
        $strpos = strripos($locationStr, ', '.$country->name);
        $supplementsStr = trim(substr($locationStr, $strpos + strlen($country->name)+2));

        if (strpos($supplementsStr,'-')===0) {
            $supplementsStr = trim(substr($supplementsStr, 1));
        }
        return $supplementsStr;
    }

    private function getCityModel(string $locationStr, Country $country) : ?City
    {
        $strpos = strripos($locationStr, ', '.$country->name);
        $cityStr = trim(substr($locationStr, 0,$strpos));

        $city = City::model()->findByAttributes(['name' => $cityStr, 'countrys_id' => $country->id]);

        if ($city!==null) {
            return $city;
        }
        $newCity = new City();
        $newCity->name =$cityStr;
        $newCity->country=$country;
        $newCity->countrys_id=$country->id;
        $newCity->save();

        return $newCity;
    }

    private function getArtistModel(string $artistStr) : Artist {
        $artist = Artist::model()->findByAttributes(['name' => $artistStr]);

        if ($artist!==null) {
            return $artist;
        }
        $newArtist = new Artist();
        $newArtist->name =$artistStr;
        $newArtist->save();

        return $newArtist;
    }

    private function getCountryModel(string $countryStr) : Country {
        $country = Country::model()->findByAttributes(['name' => $countryStr]);

        if ($country!==null) {
            return $country;
        }
        $newCountry = new Country();
        $newCountry->name =$countryStr;
        $newCountry->save();

        return $newCountry;
    }
    
    private function parseCountryFromLocationStr(string $locationStr): ?string
    {
        $strpos = strripos($locationStr, ',');
        $substr = substr($locationStr, $strpos + 1);

        $misc_splitter_pos = strpos($substr, '-');
        if ($misc_splitter_pos > 0) {
            $substr = substr($substr, 0, $misc_splitter_pos);
        }

        $countryStr = trim($substr);

        foreach (self::ALLOWED_COUNTIRES as $allowed_country) {
            if (Helper::startsWith($countryStr, $allowed_country)) {
                return $allowed_country;
            }
        }
        return null;
    }





}