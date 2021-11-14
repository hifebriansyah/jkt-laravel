<?php

$data = json_decode($_POST['data']);
$db = [];

$output = fopen('fb.csv', 'w') or die("Can't open file");
$output2 = fopen('db.json', 'w') or die("Can't open file");

fputcsv($output, array('id','title','description','availability','condition','price','link','image_link','mpn'));

foreach($data as $value) {
    fputcsv($output, $value);
    $db[] = $value[8];
}

file_put_contents("db.json", json_encode($db));

fclose($output) or die("Can't close file");
fclose($output2) or die("Can't close file");

//echo "<script>window.close();</script>";
