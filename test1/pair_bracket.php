<?php

if (empty($argv[1])) {
    echo "too few argument";
    return -1;
}elseif (empty($argv[2])){
    echo "too few argument";
    return -1;
}elseif (!empty($argv[3])){
    echo "too much argument";
    return -1;
}

$data = $argv[1];
$index = $argv[2];


findPair($data, $index);

function findPair(string $data, int $index){

    $stringLen = strlen($data);

    if($stringLen <= $index){
        echo "too few length string";
        return -1;
    }

    if($data[$index] != "(") {
        echo "not a bracket";
        return -1;
    }

    $stack = array();
    for ($i = $index; $i<$stringLen;$i++) {
        if($data[$i] == "(")
            $stack[] = $i;

        elseif($data[$i] == ")") {
            array_pop($stack);
            if(empty($stack)) {
                echo "index : ".$i;
                return -1;
            }
        }

    }

    echo "brackets pair not found";
    return -1;

}
