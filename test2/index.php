<?php

use Ruppey\ExcelValidate\Validate;

require_once realpath("vendor/autoload.php");

$result = new Validate("Type_A.xlsx");
$result->getResult();
