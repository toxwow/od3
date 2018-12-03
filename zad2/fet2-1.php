<?php
    $_POST = json_decode(file_get_contents("php://input"),true);

    $type = $_POST["type"];
    $valFirst = $_POST["valFirst"];
    $valMod = $_POST["valMod"];

    if($type === "private"){
        $my_file = '../key/private.key';
        $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
        $data = $valFirst."\n".$valMod;
        fwrite($handle, $data);
        echo json_encode(true);

    }

    else{
        $my_file = '../key/public.key';
        $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
        $data = $valFirst."\n".$valMod;
        fwrite($handle, $data);
        echo json_encode(true);
    }





    header('Content-Type: application/json');
//    echo json_encode(true);
//    echo json_encode($valFirst);
//    echo json_encode($valMod);
?>