<?php

function str_to_microtime($str) {
    $l = explode('.', $str);
    return floatval($l[0] . $l[1]);
}

function get_latest() {
    $n = glob('uploads/*');
    sort($n);
    $tmp = array_filter($n, function($e) {
        return (microtime(TRUE) - str_to_microtime($e)) < 3600;
    });
    if (count($tmp) > 30)
        return $tmp;
    return $n;
}

$last_path = $_GET["last"];

$images = get_latest();
if ($last_path == end($images)) {
    echo $images[0]; 
} else {
    for($i = 0; $i < count($images) - 1; ++$i) {
        if ($last_path == $images[$i]) {
            echo $images[$i + 1];
            exit();
        }
    }
    echo end($images);
}
