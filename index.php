<?php

function path_microtime($path, &$small){
    list($usec, $sec) = explode(" ", microtime());
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $small = './thumbs/uploads/' . $sec . $usec . '.' . $ext;
    return './uploads/' . $sec . $usec . '.' . $ext;
}

function make_thumbnail($path, $path_thumb) {
    $thumbnail_width = 300;
    $thumbnail_height = 200;
    $arr_image_details = getimagesize($path);
    $original_width = $arr_image_details[0];
    $original_height = $arr_image_details[1];
    if ($original_width > $original_height) {
        $new_width = $thumbnail_width;
        $new_height = intval($original_height * $new_width / $original_width);
    } else {
        $new_height = $thumbnail_height;
        $new_width = intval($original_width * $new_height / $original_height);
    }
    $dest_x = intval(($thumbnail_width - $new_width) / 2);
    $dest_y = intval(($thumbnail_height - $new_height) / 2);
    if ($arr_image_details[2] == 1) {
        $imgt = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    }
    if ($arr_image_details[2] == 2) {
        $imgt = "ImageJPEG";
        $imgcreatefrom = "ImageCreateFromJPEG";
    }
    if ($arr_image_details[2] == 3) {
        $imgt = "ImagePNG";
        $imgcreatefrom = "ImageCreateFromPNG";
    }
    if ($imgt) {
        $old_image = $imgcreatefrom($path);
        $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
        imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
        $imgt($new_image, $path_thumb);
    }
}

function store_file($target_file, $target_file_small) { 
    $success = move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file);
    make_thumbnail($target_file, $target_file_small);
    return $success;
}

if(isset($_POST['submit'])) {
    if (empty($_FILES['fileToUpload']['name'])) {
        echo file_get_contents("./views/error.php");
        exit();
    }
    $target_dir = 'uploads/';
    $target_file_small = '';
    $target_file = path_microtime($_FILES['fileToUpload']['name'], $target_file_small);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST['submit'])) {
        $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
        $uploadOk = ($check !== false);
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES['fileToUpload']['size'] > 10000000) {
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' ) {        
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1 && store_file($target_file, $target_file_small)) {
        echo file_get_contents("./views/success.php");
    } else {
        echo file_get_contents("./views/error.php");
    }
} else {
    echo file_get_contents("./views/main.php");
}