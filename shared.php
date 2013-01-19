<?php
date_default_timezone_set('UTC');

function getApiToken() {
  return json_decode(file_get_contents('api_keys/crocodoc.json'))->apiToken;
}

function loadObjects($dirname) {
  $filenames = scandir($dirname);
  
  $objs = array();
  foreach($filenames as $filename) {
    if(substr($filename, -5) == '.json') {
      $obj = json_decode(file_get_contents(sprintf('%s/%s', $dirname, $filename)));
      $objs[$obj->id] = $obj;
    }
  }
  
  return $objs;
}

$USERS = loadObjects('users');
$PAPERS = loadObjects('papers');

function insertLinks($text) {
  $patterns = array();
  $patterns[0] = '/(^|\s+)((page|p{1,2})\.*\s*)(\d+)/';
  
  $replacements = array();
  $replacements[0] = '\1<a href="javascript:void(0)" onclick="jumpToPage(\4);">\2\4</a>';
  
  return preg_replace($patterns, $replacements, $text);
}

?>
