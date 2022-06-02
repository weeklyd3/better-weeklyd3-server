<?php
require 'api.php';
require 'heck.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(prettify('{"status":false,"message":"Only POST requests are allowed. Sorry.","data":null}'));
}
$username = $_POST['username'];
$password = $_POST['password'];
$u = cleanFilename($username);
if (is_dir("accounts/$u")) {
    die(prettify('{"status":false,"message":"Username is taken","data":null}'));
}
mkdir("accounts/$u", 0777);
fwrite(fopen("accounts/$u/username.txt", "w+"), $username);
fwrite(fopen("accounts/$u/password.txt", "w+"), password_hash($password, PASSWORD_DEFAULT));
fwrite(fopen("accounts/$u/creationDate.json", "w+"), time());
$status = new stdClass;
$status->status = true;
$status->message = "User account created";
$status->data = array(
    "username" => $username,
    "sanitizedUsername" => $u
);
exit(json_encode($status, 128));