<?php
require 'api.php';
require 'heck.php';
require 'markdown-parsing/parsedown/parsedown.php';
$article = isset($_GET['article']) ? $_GET['article'] : 'this_is_not_a_valid_article_id';
$article = cleanFilename($article);
if (!is_dir("articles/$article")) die('false');
$articleJSON = json_decode(file_get_contents("articles/$article/article.json"));
$articleJSON->html = (new Parsedown)->text($articleJSON->contents);
exit(prettify(json_encode($articleJSON)));