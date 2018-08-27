<?php

if(isset($_POST["image"])){
    $data = $_POST["image"];
    $img_arr1 = explode(";", $data);
    $img_arr2 = explode(",", $img_arr1[1]);
    $data = base64_decode($img_arr2[1]);
    $imageName = "product" . time() . "png";
    file_put_contents($imageName, $data);
    echo '<img src = "' . $imageName . '" class = "thumb" />';
}

?>