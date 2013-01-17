<?php
date_default_timezone_set('UTC');

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
$COMMENTS = loadObjects('comments');

?>
