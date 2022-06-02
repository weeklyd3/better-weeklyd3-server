<?php
require 'api.php';
require 'heck.php';
require 'markdown-parsing/parsedown/parsedown.php';
$p = new Parsedown;
if (isset($_POST['text'])) {
    echo json_encode($p->text($_POST['text']));
} else {
    die('null');
}