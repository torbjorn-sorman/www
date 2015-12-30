<?php

function str_to_microtime($str) {
    $l = explode('.', basename($str));
    $tm = floatval(substr($l[0], 0, strlen($l[0]) - 1) . '.' . $l[1]);
    return $tm;
}

function get_latest(&$num) {
    $n = glob('uploads/*');
    sort($n);
    $time = 1200;
    $tmp = array();
    while (count($tmp) < 30 && count($tmp) < count($n)) {
        $tmp = array_filter($n, function($e) use ($time) {
            $current = microtime(TRUE);
            $old = str_to_microtime($e);
            $lapsed = ($current - $old); 
            return $lapsed < $time;
        });
        $time += 600;
    }
    $num = count($tmp);
    return array_values($tmp);
}

if (isset($_GET["last"])) {
    $last_path = $_GET["last"];
    $cnt = 0;
    $images = get_latest($cnt);
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