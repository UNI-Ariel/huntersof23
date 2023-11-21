<?php
session_start();

$uid = $name = '';
$username = 'Invitado';
$userimage = 'images/default/user.png';
$authenticated = $admin = false;
if (isset($_SESSION['id'])) {
    $uid = $_SESSION['id'];
    $username = $_SESSION['username'];
    $admin = $_SESSION['admin'];
    $name = $_SESSION['name'];
    $userimage = !empty($_SESSION['userimage']) ? $_SESSION['userimage'] : $userimage;
    $authenticated = true;
}
