<?php
require_once 'shared.php';
require_once 'crocodoc-php/Crocodoc.php';
?>

<?php
$apiToken = getApiToken();

$paperId = $_GET['id'];
$paper = $PAPERS[$paperId];
$comments = $paper->comments;
$version = $paper->versions[0];

$uuid = $version->crocodocUuid;
Crocodoc::setApiToken($apiToken);
$sessionKey = CrocodocSession::create($uuid);
$sessionUrl = sprintf("https://crocodoc.com/webservice/document.js?session=%s", $sessionKey);
error_log(sprintf("sessionUrl: %s", $sessionUrl));
?>

<html>

<head>
<title>OpenPub</title>

<link rel="stylesheet" type="text/css" href="paper.css"/>

</head>

<body>

<script src="jquery.js"></script>
<script src="jquery-ui.js"></script>
<script src="jquery.layout.js"></script>
<script src="http://static-v2.crocodoc.com/core/docviewer.js"></script>

<script src="<?php print($sessionUrl); ?>"></script>

<script type="text/javascript">
var docViewer = null;

jumpToPage = function(page) {
  docViewer.scrollTo(page);
}

$(document).ready(function(){
  layout = $('#outer').layout({
    "resizable" : true,
    "livePaneResizing" : true,
    "spacing_open" : 0,
    "south__spacing_open" : 5,
    "north__resizable" : false,
    "north__size" : 20,
    "south__size" : 80
  });
  
  docViewer = new DocViewer({ "id": "docView" });
});
</script>

<div id="outer">
  
    <div id="docView" class="ui-layout-center">
    </div>
    
    <div id="toolbarView" class="ui-layout-north">
      <p>OpenPub</p>
    </div>
    
    <div id="commentView" class="ui-layout-south">
      <?php
        foreach($comments as $comment)
        {
          $text = insertLinks($comment->text);
          $datetime = $comment->datetime;
          $name = $USERS[$comment->user_id]->name;
          
          ?>
          <div id="comment<?php echo $comment->id ?>" class="comment">
            <p class="commentHeadline">
              <?php echo $comment->headline ?>
            </p>
            <p class="commentText">
              <?php echo $text ?>
            </p>
            <p class="commentAuthorDate">
              &mdash; <?php echo $name ?> (<?php echo $datetime ?>)
            </p>
            
            <div class="arrows">
              <div class="arrowUp"></div>
              <div class="arrowDown"></div>
              <div class="score">
                <?php echo $comment->score ?>
              </div>
            </div>
          </div>
          <?php
        }
      ?>
    </div> <!--commentView-->
</div> <!--outer-->

</body>

</html>
