<?php
    $_POST = json_decode(file_get_contents("php://input"),true);


    function getFile($a){
        $filename = $a;
        $handle = fopen($filename, "r");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        return $contents;
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



    $publicKey = getFile("../key/public.key");
    $arrPublic = explode("\n", $publicKey);
    $text = getFile("../textFiles/text.txt");

    $arrayAscii = unpack("C*", $text);
    $arrayAsciiConvert = [];
    $arrayAsciiFinal = [];
    $codeTextArray = [];



    foreach ($arrayAscii as $key => $value){
        if($value < 100){
            $arrayAsciiConvert[$key] = '0'.$value;
        }
        else{
            $arrayAsciiConvert[$key] = (string) $value;
        }
    }

    if(count($arrayAsciiConvert) % 2){
        array_push($arrayAsciiConvert, "000");
    }


    foreach ($arrayAsciiConvert as $key => $value){
        if($key % 2) {
            $valTemp = $arrayAsciiConvert[$key].$arrayAsciiConvert[$key + 1];
            $arrayAsciiFinal[$key] = (int)$valTemp;
        }
    }




    foreach ($arrayAsciiFinal as $value) {
            $val = potegowanieModulo($value,   $arrPublic[0], $arrPublic[1]);
            array_push($codeTextArray, $val);
        }





    $codeTextArrayToString = implode("," , $codeTextArray);
    $my_file = '../textFiles/text.enc';
    $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
    $data = $codeTextArrayToString;
    fwrite($handle, $data);

    $myObj["codeText"] = $codeTextArrayToString;


    header('Content-Type: application/json');
    echo json_encode($myObj);


?>



