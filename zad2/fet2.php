<?php
$_POST = json_decode(file_get_contents("php://input"),true);


    $test = false;
    $test1 = false;

    function RandomNumbers($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }

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
        global $arrayMod;

        if ($v === 1) {
            return false;
        }
        for ($i=0; $i<$p; $i++){
            $val = $arrayRandom[$i];
            if(potegowanieModulo($val, $v-1, $v) !=1){
                return false;
            }
        }
        return true;
    }

    function euoler($p, $q){
        $results = ($p-1) * ($q-1);
        return $results;
    }

    function modul($p, $q){
        return $p*$q;
    }

    function nwd($a, $b){
        while($b != 0){
            $c = $a % $b;
            $a = $b;
            $b = $c;
        }
        return $a;
    }



    while($test == false){
        $randomNum = rand(10, 100000);
        $arrayRandom = RandomNumbers(2, $randomNum-2, 96);
        $test = doFermet($randomNum, 10);
        $liczbaPierwsza = $randomNum;
    }

    while($test1 == false){
        $randomNum = rand(10, 100000);
        $arrayRandom = RandomNumbers(2, $randomNum-2, 96);
        $test1 = doFermet($randomNum, 10);
        $liczbaPierwsza1 = $randomNum;
    }

    $eulerVal = euoler($liczbaPierwsza, $liczbaPierwsza1);

    $ii = rand(3, 1000);
    do{
        $ii++;
        $nwdVal = nwd($ii, $eulerVal);
    }while($nwdVal !== 1);

    $valE = $ii;


//    function searchD($e, $mod){
//        $x = $mod;
//        $d = ($x * $e) % $mod;
//        while($d !== 1){
//            $x--;
//            $d = ($x * $e) % $mod;
//        }
//        return $x;
//    }
    function modInverse($a, $m)
    {
        $m0 = $m;
        $y = 0;
        $x = 1;

        if ($m == 1)
            return 0;

        while ($a > 1)
        {
            $q = (int) ($a / $m);
            $t = $m;
            $m = $a % $m;
            $a = $t;
            $t = $y;

            // Update y and x
            $y = $x - $q * $y;
            $x = $t;
        }

        // Make x positive
        if ($x < 0)
            $x += $m0;

        return $x;
    }








    $myObj["num1"] = $liczbaPierwsza;
    $myObj["num2"] = $liczbaPierwsza1;
    $myObj["euler"] = $eulerVal;
    $myObj["modul"] = modul($liczbaPierwsza, $liczbaPierwsza1);
    $myObj["valE"] = $valE;
    $myObj["valD"] = modInverse($valE, $eulerVal);


    header('Content-Type: application/json');
    echo json_encode($myObj);
?>