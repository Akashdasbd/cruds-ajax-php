<?php

function fille_upload(array $files, string $path="media/"){
    $tmp_name = $files["tmp_name"];
    $files_name =  $files["name"];
    // get file extension

    $files_arr =  explode(".", $files_name);
    $files_ext = strtolower(end($files_arr));
    // unique files name
    $unique_files_name =  time().'_'. rand(10000,1000000).'_'. str_shuffle("123456789").'.'.$files_ext;
    move_uploaded_file($tmp_name, $path.$unique_files_name);
    return $unique_files_name;
}