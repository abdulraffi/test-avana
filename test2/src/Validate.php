<?php


namespace Ruppey\ExcelValidate;

use PhpOffice\PhpSpreadsheet\IOFactory;

class Validate
{
    const no_rule = null;
    const rule_missing_value = '*';
    const rule_should_not_space = '#';

    const no_error = null;
    const error_missing_value = "Missing value in ";
    const error_not_space = " should not contain any space";

    private $rowExcel;
    private $highestRow;
    private $rules = array();
    private $results = array();
    private $columnName = array();

    public function __construct($path)
    {
        $excel = IOFactory::load($path)->getActiveSheet();
        $this->rowExcel = $excel->toArray();
        $this->highestRow = $excel->getHighestRow();
        $this->convertToRule();
        $this->checkValidate();
    }


    private function getRowByIndex($index){

        return $this->rowExcel[$index];
    }

    private function convertToRule(){

        foreach ($this->getRowByIndex(0) as $item){
            if(strpos($item,self::rule_missing_value) !== false) {
                $this->rules[] = self::rule_missing_value;
                $this->columnName[] = str_replace(self::rule_missing_value, '', $item);
            }elseif(strpos($item,self::rule_should_not_space) !== false){
                $this->rules[] = self::rule_should_not_space;
                $this->columnName[] = str_replace(self::rule_should_not_space, '', $item);
            }else {
                $this->rules[] = self::no_rule;
                $this->columnName[] = $item;
            }
        }

        return $this->rules;

    }

    private function checkValidate(){

        for ($i = 1; $i < $this->highestRow; $i++){
            $row = $this->getRowByIndex($i);
            $result = '';
            for ($j = 0; $j < count($this->rules); $j++){
                $rule = $this->rules[$j];
                if ($rule == self::rule_missing_value and empty($row[$j]))
                    $result = $result.self::error_missing_value.$this->columnName[$j].', ';

                if ($rule == self::rule_should_not_space and strpos($row[$j], " ") !== false)
                    $result = $result.$this->columnName[$j].self::error_not_space.', ';
            }

            $this->results[$i+1] = $result; // +1 for real row in file excel

        }

    }

    public function getResult(){
        echo "Row" . " | " . "Error" . "\n";
        foreach ($this->results as $key => $value) {
            if(!empty($value))
                echo $key ." | ". $value . "\n";
        }

    }

}