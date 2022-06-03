<?php
require 'api.php';
require 'heck.php';
require 'markdown-parsing/parsedown/parsedown.php';
$Parsedown = new Parsedown;
$articles = json_decode(file_get_contents('articles.json'));
$offset = $_GET['start'] ?? 0; 
$limit = $_GET['limit'] ?? 10;
$blurbLength = $_GET['blurbLength'] ?? 300;
$start = $offset;
$end = $offset + $limit - 1;
$newarticles = array();
foreach ($articles as $article) {
    $obj = new stdClass;
    $obj->id = $article;
    $obj->data = json_decode(file_get_contents("articles/$article/article.json"));
    $obj->blurb = substr(strip_tags($Parsedown->text($obj->data->contents)), 0, $blurbLength);
    array_push($newarticles, $obj);
}
exit(prettify(json_encode($newarticles)));