<?php

Yii::import('zii.widgets.grid.CGridView');

class CPrdSort extends CSort {

    public function getOrderBy($criteria = null) {
        $orderBy = parent::getOrderBy($criteria);

        if (CPrdGridViewCore::parseFirstOrderCol($orderBy) == 'Artist') {
            $orderBy = $orderBy . ", misc,VideoType DESC,AudioType DESC,Date";
        }
        return $orderBy;
    }

}

abstract class CAbstractPrdGridView extends CGridView {

    protected abstract function doCreateDataColumn($text);

    protected function createDataColumn($text) {
        if (!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/', $text, $matches))
            throw new CException(Yii::t('zii', 'The column must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'));
        //// hijacking
        $column = $this->doCreateDataColumn($text);
        /// {OLD CODE START}
        //$column=new CDataColumn($this);
        /// {OLD CODE END}

        $column->name = $matches[1];
        if (isset($matches[3]) && $matches[3] !== '')
            $column->type = $matches[3];
        if (isset($matches[5]))
            $column->header = $matches[5];
        return $column;
    }

    protected abstract function doRenderTableHeader();

    public function renderTableHeader() {
        if (!$this->hideHeader) {
            echo "<thead>\n";

            if ($this->filterPosition === self::FILTER_POS_HEADER)
                $this->renderFilter();

            //// hijacking
            $this->doRenderTableHeader();
            /// {OLD CODE START}
//            echo "<tr>\n";
//            foreach ($this->columns as $column)
//                $column->renderHeaderCell();
//            echo "</tr>\n";
            /// {OLD CODE END}

            if ($this->filterPosition === self::FILTER_POS_BODY)
                $this->renderFilter();

            echo "</thead>\n";
        }
        else if ($this->filter !== null && ($this->filterPosition === self::FILTER_POS_HEADER || $this->filterPosition === self::FILTER_POS_BODY)) {
            echo "<thead>\n";
            $this->renderFilter();
            echo "</thead>\n";
        }
    }

    protected abstract function doRenderDataCells($row);

    protected abstract function doRenderTableRow($row);

    public function renderTableRow($row) {

        //// hijacking
        $this->doRenderTableRow($row);

        if ($this->rowCssClassExpression !== null) {
            $data = $this->dataProvider->data[$row];
            $class = $this->evaluateExpression($this->rowCssClassExpression, array('row' => $row, 'data' => $data));
        } else if (is_array($this->rowCssClass) && ($n = count($this->rowCssClass)) > 0)
            $class = $this->rowCssClass[$row % $n];
        else
            $class = '';

        echo empty($class) ? '<tr>' : '<tr class="' . $class . '">';

        //// hijacking
        $this->doRenderDataCells($row);
        /// {OLD CODE START}
        // foreach ($this->columns as $column)
        //     $column->renderDataCell($row);
        /// {OLD CODE END}

        echo "</tr>\n";
    }

}

class CPrdGridViewCore extends CAbstractPrdGridView {

    private $mainColumn = Cols::ARTIST;
    private $orderBy = "";
    private $ancestorEntry = '_NO_DATA_';
    private $ancestorVAType = -2; //-1 not posible becasue this is the value for UNDEFINED, -2 means = not set
    private $ancestorYear = -1;
    private $ancestorCreateDate = -1;
    private $tableBreakCols = array(Cols::ARTIST);
    private $colCount;
    private $mergeRowCols = array(Cols::DATE, Cols::ARTIST, Cols::LOCATION);
    private $artistId = -1;

    public function init() {
        $sorti = new CPrdSort();
        $sorti->attributes = $this->dataProvider->sort->attributes;
        $sorti->defaultOrder = $this->dataProvider->sort->defaultOrder;
        $sorti->route = $this->dataProvider->sort->route;
        $sorti->params = $this->dataProvider->sort->params;
        $sorti->modelClass = $this->dataProvider->sort->modelClass;
        $this->dataProvider->sort = $sorti;

        //publish all assets from components / PrdGridView 
        if ($this->baseScriptUrl === null)
            $this->baseScriptUrl = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets');

        //register css from PrdGridView
        if ($this->cssFile !== false) {
            if ($this->cssFile === null)
                $this->cssFile = $this->baseScriptUrl . '/styles.css';
            Yii::app()->getClientScript()->registerCssFile($this->cssFile);
        }

        parent::init();
    }

    public function run() {
        if (Yii::app()->settingsManager->getPropertyValue(Settings::LIST_CACHING) == true) {
            $contentStr = $this->dataProvider->getSort()->getOrderBy();
            foreach ($this->dataProvider->data as $row) {
                foreach ($row as $col) {
                    $contentStr.=$col;
                }
            }
            $contentHash = hash("md5", $contentStr);

            if ($this->beginCache($contentHash)) {
                parent::run();
                $this->endCache();
            }
        } else {
           parent::run(); 
        }
    }

    /**
     * checks if the record in the row before belongs to the same concert
     * 
     * @param type $row the current checked row
     * @return boolean
     */
    private function hasSameConcertPredecessor($row) {
        $data = $this->dataProvider->data;
        if (isset($data[$row]["id"]) && isset($data[$row]['VideoType'])) {
            if (isset($data[$row - 1]["id"]) && isset($data[$row - 1]["VideoType"])) {
                return $data[$row]["id"] == $data[$row - 1]["id"] && $data[$row]["VideoType"] == $data[$row - 1]["VideoType"] && ($this->orderBy != 'Date (created)' || substr($data[$row]["created"], 0, 10) == substr($data[$row - 1]["created"], 0, 10));
            }
        }
        return false;
    }

    /**
     *
     * @param type $row
     * @return int 
     */
    private function countConcertSuccessors($row) {
        $successors = 0;

        $data = $this->dataProvider->data;
        if (isset($data[$row]["id"]) && isset($data[$row]['VideoType'])) {

            while (isset($data[$row + $successors + 1]["id"]) && isset($data[$row + $successors + 1]["VideoType"]) && $data[$row + $successors + 1]["id"] == $data[$row]["id"] && $data[$row + $successors + 1]["VideoType"] == $data[$row]["VideoType"] && ($this->orderBy != 'Date (created)' || substr($data[$row + $successors + 1]["created"], 0, 10) == substr($data[$row]["created"], 0, 10)))
                $successors++;
        }
        return $successors;
    }

    /**
     *
     * @param type $row
     * @param type $colName
     * @return int 
     *        -1 = no merge
     *        0 = merge, without start
     *        > 1 = new rowspan starts = count of rowspan
     */
    public function getRowMergeInfoForCol($row, $colName) {
        if (in_array($colName, $this->mergeRowCols)) {

            $successors = $this->countConcertSuccessors($row);

            if ($this->hasSameConcertPredecessor($row)) {
                return 0;
            } else if ($successors > 0) {
                return $successors;
            }
        }
        return -1;
    }

    protected function doCreateDataColumn($text) {
        return new CPrdDataColumn($this);
    }

    private function isOrderedColumn($column) {
        return $column instanceof CDataColumn && $this->orderBy == $column->name;
    }

    protected function doRenderTableHeader() {
        $this->orderBy = CPrdGridViewCore::evaluateOrderBy($this->dataProvider);
        $this->colCount = count($this->columns);
        $this->artistId = ParamHelper::decodeArtistIdParam();

        //generates a extra header row for the main-col-header
        if ($this->orderBy == $this->mainColumn) {
            foreach ($this->columns as $column) {
                if ($this->isOrderedColumn($column)) {
                    echo "<tr>";
                    $colSpan = $this->colCount - 1 /* - 2 */; //- 2 = info link col and tradestatus col
                    echo '<th colspan="' . $colSpan . '" >';
                    echo $column->renderHeaderCellContent();
                    echo "</th>";

                    echo "</tr>";
                }
            }
        }


        echo "<tr>\n";
        for ($i = 0; $i < $this->colCount /* - 2 */; $i++) { //- 2 = info link col and tradestatus col
            if (!($this->orderBy == $this->mainColumn && $this->isOrderedColumn($this->columns[$i]))) {
                $this->columns[$i]->renderHeaderCell();
            }
        }
        echo "</tr>\n";
    }

    protected function doRenderDataCells($row) {
        foreach ($this->columns as $column) {
            if (!($this->orderBy == $this->mainColumn && $this->isOrderedColumn($column))) { //do not render main-col-header, because it was alreay rendered as a extra row before
                $column->renderDataCell($row);
            }
        }
    }

    protected function doRenderTableRow($row) {
        ////////////////////////////////////////////////////
        // order by splitter row
        if (isset($this->dataProvider->data[$row][$this->orderBy])) {
            $orderEntry = $this->dataProvider->data[$row][$this->orderBy];
            if ($this->orderBy == "Artist" && $this->dataProvider->data[$row]['misc'] == true) {
                $orderEntry = $orderEntry . " [misc]";
            }
        } else {
            $orderEntry = '';
        }
        if ($this->ancestorEntry != $orderEntry && in_array($this->orderBy, $this->tableBreakCols)) {
            $counter = 0;

            while (array_key_exists($row + $counter, $this->dataProvider->data)) {
                $tempEntry = $this->dataProvider->data[$row + $counter][$this->orderBy];

                if ($this->orderBy == "Artist" && $this->dataProvider->data[$row + $counter]['misc'] == true) {
                    $tempEntry = $tempEntry . " [misc]";
                }

                if ($tempEntry != $orderEntry) {
                    break;
                }
                $counter++;
            }

            if ($orderEntry == '') { //empty entry
                $orderLabel = 'UNLABELED';
            } else {
                $orderLabel = $orderEntry;

                //adding link for artist
                if ($this->orderBy == $this->mainColumn) {
                    $artistId = $this->dataProvider->data[$row]['ArtistId'];
                    $artistListUrl = ParamHelper::createArtistListUrl($artistId);
                    $orderLabel = CHtml::link($orderLabel, $artistListUrl);
                }
            }

            echo "<tr>";
            echo '<td colspan="' . ($this->colCount - 1) . '" ><div class="splittext">' . $orderLabel . ' [' . $counter . ' records]</div></td>';
            echo "</tr>";

            $this->ancestorVAType = -2; //reset VideoOrAudio memory
        }
        $this->ancestorEntry = $orderEntry;

        ////////////////////////////////////////////////////
        // date added splitter row
        if ($this->orderBy == 'Date (created)' && isset($this->dataProvider->data[$row]['created'])) {
            $createDate = $this->dataProvider->data[$row]['created'];
            $createDate = substr($createDate, 0, 10);
            if ($createDate != $this->ancestorCreateDate) {
                echo "<tr>";
                echo '<td colspan="' . ($this->colCount - 1) . '" ><div class="splittext">' . $createDate . '</div></td>';
                echo "</tr>";

                $this->ancestorVAType = -2;
            }
            $this->ancestorCreateDate = $createDate;
        }

        ////////////////////////////////////////////////////
        // VideoOrAudio row
        $curVideoType = $this->dataProvider->data[$row]['VideoType'];
        $curAudioType = $this->dataProvider->data[$row]['AudioType'];

        $curVaType = VA::UNDEFINED;
        if ($curVideoType == 1)
            $curVaType = VA::VIDEO;
        if ($curAudioType == 1)
            $curVaType = VA::AUDIO;

        if ($curVaType != $this->ancestorVAType) {

            echo "<tr>";
            echo '<td colspan="' . ($this->colCount - 1) . '" ><div class="videoaudio">' . VA::vaIdToStr($curVaType) . '</div></td>';
            echo "</tr>";

            $this->ancestorVAType = $curVaType;

            $this->ancestorYear = -1;
        }

        ////////////////////////////////////////////////////
        // year splitter row
        if ($this->orderBy == $this->mainColumn && $this->artistId != NULL && $this->artistId > 0) {
            $date = $this->dataProvider->data[$row]['Date'];
            $year = substr($date, 0, 4);
            if ($year != $this->ancestorYear) {
                echo "<tr>";
                echo '<td colspan="' . ($this->colCount - 1) . '" ><div class="splittext">' . $year . '</div></td>';
                echo "</tr>";
            }
            $this->ancestorYear = $year;
        }
    }

    // static helpers

    public static function evaluateOrderBy($dataProvider) {
        $orderBy = $dataProvider->getSort()->getOrderBy();

        return CPrdGridViewCore::parseFirstOrderCol($orderBy);
    }

    public static function parseFirstOrderCol($orderByStr) {
        //cut string if ordering for multiple arguments
        $sperator = ',';
        $pos = strpos($orderByStr, $sperator);
        if ($pos > 0) {
            $orderByStr = substr($orderByStr, 0, $pos);
        }
        $orderByStr = trim($orderByStr);

        if (($pos = strpos(strtoupper($orderByStr), ' DESC')) > 0) {
            $orderByStr = substr($orderByStr, 0, $pos);
        }
        if (($pos = strpos(strtoupper($orderByStr), ' ASC')) > 0) {
            $orderByStr = substr($orderByStr, 0, $pos);
        }
        return $orderByStr;
    }

}

?>
