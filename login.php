<?php
require 'api.php';
require 'heck.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(prettify('{"status":false,"message":"Only POST requests are allowed. Sorry.","data":null}'));
}
$name = cleanFilename($_POST['user']);
if (!file_exists("accounts/$name/password.txt")) {
    die(prettify('{"status":false,"message":"No such user","data":null}'));
}
$password = file_get_contents("accounts/$name/password.txt");
if (!password_verify($_POST['password'], $password)) {
    die(prettify('{"status":false,"message":"Wrong password","data":null}'));
}
$_SESSION['username'] = file_get_contents("accounts/$name/username.txt");
?>
<?php echo prettify('{"status":true,"message":"Logged in successfully","data":{"username":' .  json_encode($_SESSION['username']) . '}}'); ?>