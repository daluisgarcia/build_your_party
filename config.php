<?php

define('IMG_FOLDER', 'img/');

function SANITIZE_STRING($string){
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    $string = filter_var($string, FILTER_SANITIZE_STRING);
    return $string;
}

function SANITIZE_EMAIL($email){
    $email = trim($email);
    $email = stripslashes($email);
    $email = htmlspecialchars($email);
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    return $email;
}

function ENCRYPT($input){
    return hash('sha512', $input);
}
