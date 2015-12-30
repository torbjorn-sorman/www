<?php

$last_path = $_GET["last"];
$n = array_map('basename', glob('/uploads/*.*'));
sort($n);
if ($last_path)
return