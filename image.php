<?php

function str_to_microtime($str) {
    $l = explode('.', $str);
    return floatval($l[0] . $l[1]);
}

function get_latest() {
    $n = glob('uploads/*');
    sort($n);
    $time = 1800;
    $tmp = array();
    while (count($tmp) < 30 && count($tmp) != count($n)) {
        $tmp = array_filter($n, function($e) use ($time) {
            return (microtime(TRUE) - str_to_microtime($e)) < $time;
        });
        $time *= 1.5;
    }
    return $tmp;
}

if (isset($_GET["last"])) {
    $last_path = $_GET["last"];    
    $images = get_latest();
    if ($last_path == $images[count($images) - 1]) {
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
} else if (isset($_GET["list"])) {
    $imgs = glob('uploads/*');
    sort($imgs);
    echo json_encode($imgs);
}