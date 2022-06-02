<?php
define('started', 'true');
require 'prettify.php';
header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
// You can't use multiple domains.
// Not a whit. I have a device to make
// all well. Write me a header, and
// let the header seem to say, we will
// do the action for all domains, and that
// Pyramus is not killed indeed. And, for
// the more better assurance, tell them 
// that Pyramus is not actually Pyramus,
// but Bottom the weaver. That will
// put them out of fear.
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