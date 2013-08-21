<?php

class Joins {
    
    const RIGHT_OUTER = 'RIGHT OUTER JOIN';
    const LEFT_OUTER = 'LEFT OUTER JOIN';
    const LEFT = 'LEFT JOIN';
    const INNER = 'INNER JOIN';
}

class QueryBuilderAdapter {

    const SELECT = 'select';
    const FROM_ = 'from';
    const JOIN = 'join';

    private $selects = array();
    private $froms = array();
    private $joins = array(); //tableName => joinSyntax
    
    private $joinSpecs = null;
    private $defaultJoins = array();

    function __construct() {
        $this->defaultJoins[CActiveRecord::BELONGS_TO] = Joins::LEFT_OUTER;
        $this->defaultJoins[CActiveRecord::HAS_MANY] = Joins::LEFT_OUTER;
        $this->defaultJoins[CActiveRecord::HAS_ONE] = Joins::LEFT;
    }

    public function buildQueryString($sourceModelName, $cols, $joinSpecsIn = null) {
        $this->resolveQueryElements($sourceModelName, $cols,$joinSpecsIn);

        $select = self::SELECT . " " . implode(",", $this->selects);
        $from = self::FROM_ . " " . implode(",", $this->froms);
        $join = implode(" ", $this->joins);

        // echo $select . "<br>" . $from . "<br>" . $join;
        return $select . " " . $from . " " . $join;
    }

    public function buildQueryParts($sourceModelName, $cols, $joinSpecsIn = null) {
        $this->resolveQueryElements($sourceModelName, $cols,$joinSpecsIn);

        $parts = array(
            self::SELECT => implode(",", $this->selects),
            self::FROM_ => implode(",", $this->froms),
            self::JOIN => implode(" ", $this->joins),
        );

        return $parts;
    }

    private function resolveQueryElements($sourceModelName, $cols, $joinSpecsIn) {

        if ($joinSpecsIn==null) {
            $this->joinSpecs=array();
        } else {
            $this->joinSpecs=$joinSpecsIn;
        }
        
        $sourceModel = CActiveRecord::model($sourceModelName);
        $sourceTableName = $sourceModel->tableName();

        //FROM
        $this->addFrom($sourceTableName);

        foreach ($cols as $relationPath => $attributes) {

            $currentPathModel = $sourceModel;
            $attributeTablePrefix = $sourceTableName;

            if (strlen($relationPath) > 0) {
                $relationParts = explode(".", $relationPath);

                foreach ($relationParts as $relationName) {

                    $relations = $currentPathModel->relations();
                    $relation = $relations[$relationName];

                    $relationType = $relation[0];
                    $modelName = $relation[1];
                    $foreignKey = $relation[2];
                    $ancestorTableName = $currentPathModel->tableName();

                    $currentPathModel = CActiveRecord::model($modelName);
                    $currentTableName = $currentPathModel->tableName();

                    //JOIN
                    if (!array_key_exists($currentTableName, $this->joins)) {

                        if (array_key_exists($relationName,$this->joinSpecs)) {
                            $joinType=$this->joinSpecs[$relationName];
                        } else {
                            $joinType=$this->defaultJoins[$relationType];
                        }
                        
                        $joinSyntax = '';
                        if ($relationType == CActiveRecord::BELONGS_TO) {
                            $joinSyntax = $joinType.' ' . $currentTableName . " ON " . $currentTableName . ".id = " . $ancestorTableName . "." . $foreignKey;
                        } else if ($relationType == CActiveRecord::HAS_MANY) {
                            $joinSyntax = $joinType.' ' . $currentTableName . " ON " . $ancestorTableName . ".id = " . $currentTableName . "." . $foreignKey;
                        } else if ($relationType == CActiveRecord::HAS_ONE) {
                            $joinSyntax = $joinType.' ' . $currentTableName . " ON " . $ancestorTableName . ".id = " . $currentTableName . "." . $foreignKey;
                        }

                        if (strlen($joinSyntax) > 0) {
                            $this->joins[$currentTableName] = $joinSyntax;
                        }
                    }
                    $attributeTablePrefix = $currentTableName;
                }
            }

            //SELECT
            $this->processSelects($attributeTablePrefix, $attributes);
        }
    }

    private function processSelects($attributeTablePrefix, $attributes) {
        if (strlen($attributeTablePrefix) > 0) {
            $attributeTablePrefix = $attributeTablePrefix . ".";
        }
        if (is_array($attributes)) {
            //more attributes from this table
            foreach ($attributes as $attribute) {
                $this->addSelect($attributeTablePrefix . $attribute);
            }
        } else {
            //only one attribute from this table
            $this->addSelect($attributeTablePrefix . $attributes);
        }
    }

    private function addSelect($selectPhrase) {
        //add if not already has
        if (!in_array($selectPhrase, $this->selects)) {
            $this->selects[] = $selectPhrase;
        }
    }

    private function addFrom($fromPhrase) {
        //add if not already has
        if (!in_array($fromPhrase, $this->froms)) {
            $this->froms[] = $fromPhrase;
        }
    }

}

?>
