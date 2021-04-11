<?php

$img = $_POST["name"];

$name = explode(";", $img)[0];

$img = explode(";", $img)[2];
$img = explode(",", $img)[1];

$img = str_replace(" ", "+", $img);
$img = base64_decode($img);

$path = '../../../assets/users_certificate';

if(!file_exists($path)) {
    mkdir($path, 0777, true);
}


$name = $path.'/'.$name.'.jpeg';

file_put_contents($name, $img);

