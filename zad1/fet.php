<?php
//var_dump(json_decode(file_get_contents("php://input"),true));


    $dataPost = json_decode(file_get_contents("php://input"),true);

    $number = $dataPost["number"];
    $attempts = $dataPost["attempts"];
    $drawMax = $dataPost["drawMax"];
    $drawMin = 2;
    $arrayRandom= [];

    for ($start = 0 ; $start < $attempts; $start++){
        do {
            $randomNumber = rand($drawMin, $drawMax);
        } while (in_array($randomNumber, $arrayRandom));
        $arrayRandom[$start] = $randomNumber;
    }
    $arrayMod = [];

    function potegowanieModulo (  $a,  $x,  $m){
        $q = 1;
        $y = $a;
        while($x > 0) {
            if($x % 2 == 1){
                $q = ($q * $y) % $m;
            }
            $y = ($y * $y) % $m;
            $x = $x / 2;
        }
        return $q % $m;

    }

    function doFermet($v, $p){

        global $arrayRandom;

        if ($v === 1) {
            return false;
        }
        for ($i=0; $i<$p; $i++){
            $val = $arrayRandom[$i]; ;
            if(potegowanieModulo($val, $v-1, $v) !=1){
                return false;

            }
        }
         return true;

    }



    function testMod($x, &$arr){
        global $arrayRandom;
        foreach ($arrayRandom as $value) {
            $xMin = $x-1;
            $test = potegowanieModulo($value, $xMin, $x);
            array_push($arr, $test);
        }
    }



//    var_dump(stdClass);


    $ferVal = doFermet($number, $attempts);
    testMod($number, $arrayMod);
    $myObj["num"] = $number;
    $myObj["test"] = $ferVal;
    $myObj["randomNumber"] = $arrayRandom ;
    $myObj["modForNumber"] = $arrayMod;

header('Content-Type: application/json');
echo json_encode($myObj);

//echo json_encode($data1);
?>
