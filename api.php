<?php
define('started', 'true');
require 'prettify.php';
header('Access-Control-Allow-Origin: https://better-weeklyd3-client.weeklyd3.repl.co');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
function cleanFilename($stuff) {
	$illegal = array(" ","?","/","\\","*","|","<",">",'"');
	// legal characters
	$legal = array("-","_","_","_","_","_","_","_","_");
	$cleaned = str_replace($illegal,$legal,$stuff);
	return $cleaned;
}
session_set_cookie_params(array('samesite' => 'None', 'secure' => true));
session_start();