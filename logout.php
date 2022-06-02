<?php
define('started', 'true');
require 'heck.php';
require 'prettify.php';
header('Access-Control-Allow-Origin: https://better-weeklyd3-client.weeklyd3.repl.co');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(prettify('{"status":false,"message":"Only POST requests are allowed. Sorry.","data":null}'));
}
session_start();
session_destroy();
die(prettify('{"status":true,"message":"Logged out."}'));