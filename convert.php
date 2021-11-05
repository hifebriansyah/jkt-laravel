<?php

$data = json_decode($_POST['data'], true);

$output = fopen('fb.csv', 'a') or die("Can't open file");

fputcsv($output, array('id','title','description','availability','condition','price','link','image_link','mpn'));
foreach($data as $value) {
    fputcsv($output, $value);
}
fclose($output) or die("Can't close file");
echo "<script>window.close();</script>";
