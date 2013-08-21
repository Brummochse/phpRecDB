<?php

class CPrdDataColumn extends CDataColumn {

    public function renderHeaderCellContent() {
        parent::renderHeaderCellContent();
    }

    public function renderDataCell($row) {

        $rowMergeInfo = $this->grid->getRowMergeInfoForCol($row, $this->name);

        if ($rowMergeInfo == -1) { //no merge
            parent::renderDataCell($row);
        } else if ($rowMergeInfo == 0) { //  0 = merge, without start
            //do nothing
        } else { //$rowMergeInfo > 1 , new rowspan starts
            $rowSpan = $rowMergeInfo; //count of merging rows

            $data = $this->grid->dataProvider->data[$row];
            $options = $this->htmlOptions;
//            if ($this->cssClassExpression !== null) {
//                $class = $this->evaluateExpression($this->cssClassExpression, array('row' => $row, 'data' => $data));
//                if (isset($options['class']))
//                    $options['class'].=' ' . $class;
//                else
//                    $options['class'] = $class;
//            }
            $options['rowspan'] = $rowSpan + 1;
            echo CHtml::openTag('td', $options);
            $this->renderDataCellContent($row, $data);
            echo CHtml::closeTag('td');
        }
    }

}

?>
