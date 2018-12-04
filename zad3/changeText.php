<?php
$dataPost = json_decode(file_get_contents("php://input"),true);

$text = $dataPost["text"];

$my_file = '../textFiles/text.txt';
$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
$data = $text;
fwrite($handle, $data);

$myObj["textChange"] = true;



header('Content-Type: application/json');
echo json_encode($myObj);

?>