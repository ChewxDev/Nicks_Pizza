<?php

$conn = mysqli_connect('localhost', 'Chewx', 'Nicholas77', 'nick_pizza');

if (!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
}