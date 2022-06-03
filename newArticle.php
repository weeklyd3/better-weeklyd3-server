<?php
require 'api.php';
require 'heck.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(prettify('{"status":false,"message":"Only POST requests are allowed. Sorry.","data":null}'));
}
if (!isset($_SESSION['username'])) {
    die(prettify('{"status":false,"message":"You are not logged in.","data":null}'));
}
function uuid() {
    $data = random_bytes(16);
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

$id = uuid();
while (is_dir("articles/$id")) $id = uuid();
if (!isset($_POST['title'], $_POST['contents'])) {
    die(prettify('{"status":false,"message":"Title or contents missing","data":null}'));
}
mkdir("articles/$id", 0777);
$article = new stdClass;
$article->title = $_POST['title'];
$article->contents = $_POST['contents'];
$article->creator = $_SESSION['username'];
$article->creationDate = time();
$article->comments = array();
$article->views = 0;
fwrite(fopen("articles/$id/article.json", "w+"), json_encode($article));
$articles = json_decode(file_get_contents('articles.json'));
array_unshift($articles, $id);
fwrite(fopen('articles.json', 'w+'), json_encode($articles));
$success = new stdClass;
$success->status = true;
$success->message = "Article created.";
$data = new stdClass;
$data->articleObject = $article;
$data->articleId = $id;
$success->data = $data;
echo prettify(json_encode($success));