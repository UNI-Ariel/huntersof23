<?php
// Database connection base
$conn = mysqli_connect('localhost', 'root', '', 'myspotplayy');

mysqli_set_charset($conn, "utf8");

if (!$conn) {
    echo mysqli_connect_error();
}