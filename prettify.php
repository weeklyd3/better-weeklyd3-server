<?php
function prettify($json) {
    return json_encode(json_decode($json), 128);
}
function minify($json) {
    return json_encode(json_decode($json));
}