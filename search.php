<?php
require 'api.php';
require 'heck.php';
$minQueryLength = 1;
$query = isset($_GET['query']) ? $_GET['query'] : "";
$start = isset($_GET['start']) ? $_GET['start'] : 0;
if (strlen($query) < $minQueryLength) {
    die(prettify('{"status":false,"message":"Enter at least ' . $minQueryLength . ' characters(s)","results":null}'));
}
$query = explode(' ', $query);
$results = array();
class searchResult {
    public function __construct(string $taitl, string $baudy, int $matches, array $q, string $id) {
        require_once 'markdown-parsing/parsedown/parsedown.php';
        $Parsedown = new Parsedown;
        $this->matches = $matches;
        $this->title = $taitl;
        $this->id = $id;
        $original = $baudy;
        $this->blurb = $baudy;
        $regex = array();
        foreach ($q as $term) array_push($regex, preg_quote(htmlspecialchars($term), '/'));
        $r = "/(" . implode('|', $regex) . ')/i';
        $baudy = strip_tags($Parsedown->text($baudy));
        $this->htmlBlurb = $this->processBlurb($baudy, $q);
        $this->titleHtmlBlurbShort = $this->processBlurb($taitl, $q);
        $titleHtmlBlurb = preg_replace($r, "<mark>$0</mark>", htmlspecialchars($taitl));
    }
    public function processBlurb(string $original, array $query): string {
        $earliestIndex = strlen($original);
        $blurbLength = 300;
        foreach ($query as $searchTerm) {
            $pos = stripos($original, $searchTerm);
            if ($pos === false) continue;
            if ($pos < $earliestIndex) $earliestIndex = $pos;
        }
        if ($earliestIndex === strlen($original)) return substr($original, 0, $blurbLength);
        if ($earliestIndex < 2) $earliestIndex = 2;
        $earliestIndex = $earliestIndex - 2;
        $text = substr($original, $earliestIndex, $blurbLength);
        assert(!(strlen($text) > $blurbLength));
        $regex = array();
        foreach ($query as $searchTerm) array_push($regex, preg_quote(htmlspecialchars($searchTerm), '/'));
        $regex = '/(' . implode('|', $regex) . ')/i';
        return preg_replace($regex, "<mark>$0</mark>", htmlspecialchars($text));
    }
}
function addToSearch($taitl, $baudy, $q, $id) {
    $matches = custom_substr_count($q, $baudy);
    $matches += custom_substr_count($q, $taitl);
    return new searchResult($taitl, $baudy, $matches, $q, $id);
}
$articles = scandir("articles/");
foreach ($articles as $article) {
    if (in_array($article, array('.', '..'))) continue;
    $info = json_decode(file_get_contents("articles/$article/article.json"));
    $res = addToSearch($info->title, $info->contents, $query, $article);
    if ($res->matches) array_push($results, $res);
}
function custom_substr_count($searchTerms, $text) {
    $total = 0;
    foreach ($searchTerms as $term) $total += substr_count(strtoupper($text), strtoupper($term));
    return $total;
}
usort($results, function($a, $b) {
    return $b->matches - $a->matches;
});
exit(prettify(json_encode($results)));