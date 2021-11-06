<?php

$img_src = $_GET['img'];

$img = imagecreatefromjpeg($img_src);
$color = imagecolorallocate($img, 3, 172, 14);
$borderThickness =  8;

drawBorder($img, $color, $borderThickness);


    function drawBorder(&$img, &$color, $thickness)
    {
        $x1 = 0;
        $y1 = 0;
        $x2 = imagesx($img) - 1;
        $y2 = imagesy($img) - 1;

        for($i = 0; $i < $thickness; $i++)
        {
            imagerectangle($img, $x1++, $y1++, $x2--, $y2--, $color);
        }

    }

header('Content-type: image/jpeg');
imagejpeg($img);
