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

$privateKey = getFile("../key/private.key");
$arrPrivate = explode("\n", $privateKey);
$text = getFile("../textFiles/text.enc");

$textToArray = explode(",", $text);

$arrPreDecode = [];
$arrDecode = [];

$textDecode = "";

foreach ($textToArray as $key => $value) {
    $val = potegowanieModulo((int)$value ,$arrPrivate[0],$arrPrivate[1]);
    array_push($arrPreDecode, $val);
}

foreach ($arrPreDecode as $key => $value){
    if(strlen($value)%2){
        $valString = (string)$value;
        $valTemp = substr($valString, 0,2);
        $valTemp2 = substr($valString, 2,5);
        array_push($arrDecode, (int)$valTemp);
        array_push($arrDecode, (int)$valTemp2);
    }
    else{
        $valString = (string)$value;
        $valTemp = substr($valString, 0,3);
        $valTemp2 = substr($valString, 3,6);
        array_push($arrDecode, (int)$valTemp);
        array_push($arrDecode, (int)$valTemp2);
    }
}

foreach ($arrDecode as $value){
    $textDecode .= chr($value);
}

$my_file = '../textFiles/text.dec';
$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
$data = $textDecode;
fwrite($handle, $data);

$myObj["decodeText"] = $textDecode;


header('Content-Type: application/json');
echo json_encode($myObj);


?>



