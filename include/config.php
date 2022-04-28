<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'animal_details';

$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn) {
    //echo 'connected';
} else {
    // echo 'connection problem';
}

function validateinput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}
