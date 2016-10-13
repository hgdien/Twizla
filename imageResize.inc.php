<?php

    function imageResize($width, $height, $targetH, $targetW) {

    //takes the larger size of the width and height and applies the
//    formula accordingly...this is so this script will work
//    dynamically with any size image

//    if ($width > $height) {
    if($targetH > $targetW)
    {
        $percentage = ($targetW / $width);
    }
    else
    {
        $percentage = ($targetH / $height);
    }

    //gets the new value and applies the percentage, then rounds the value
    $width = round($width * $percentage);
    $height = round($height * $percentage);

    //final check if the  new width and height fit on the box
    if($width > $targetW)
    {
        $percentage = ($targetW / $width);
        $width = round($width * $percentage);
        $height = round($height * $percentage);
    }
    else if($height > $targetH)
    {
        $percentage = ($targetH / $height);
        $width = round($width * $percentage);
        $height = round($height * $percentage);
    }
    //returns the new sizes in html image tag format...
    $returnString = "width=\"$width\" height=\"$height\"";

    //if the picture is in landscape format, add the margin top
    if($width > $height)
    {
        $marginTop = round(($targetH - $height)/2) ;
        $returnString .= " style=\"margin-top:".$marginTop."px;\"";
    }

    return $returnString;

    }

?>