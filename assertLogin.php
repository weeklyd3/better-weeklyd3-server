<?php
require 'api.php';
require 'heck.php';
$loggedIn = false;
if (isset($_SESSION['username'])) {
    if (is_dir("accounts/" . cleanFilename($_SESSION['username']))) {
        $loggedIn = $_SESSION['username'];
    }
}
echo json_encode($loggedIn);