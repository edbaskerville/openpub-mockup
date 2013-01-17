<?php
require_once 'shared.php';
require_once 'crocodoc-php/Crocodoc.php';
?>

<?php
$apiToken = json_decode(file_get_contents('api_keys/crocodoc.json'))->apiToken;
$uuid = '7d3ae771-7510-4358-9036-1e2226729df9';
Crocodoc::setApiToken($apiToken);
$sessionKey = CrocodocSession::create($uuid);
$sessionUrl = sprintf("https://crocodoc.com/webservice/document.js?session=%s", $sessionKey);
error_log(sprintf("sessionUrl: %s", $sessionUrl));
?>

<html>

<head>
<title>OpenPub</title>

<style type="text/css">
body
{
  margin: 0;
  padding: 0;
}

#outer
{
  width: 100%;
  max-width: 100px;
  height: 100%;
}

#docView {
  position: absolute;
  top: 0%;
  left: 0%;
  width: 100%;
  height: 80%;
}

#lower {
  width: 100%;
  top: 80%;
  height: 20%;
}

#commentView {
  position: absolute;
  top: 80%;
  height: 20%;
  width: 100%;
  background-color: lightgray;
  overflow-x: hidden;
  overflow-y: auto;
}

.comment {
  position: relative;
  width: 800px;
  margin-left: auto;
  margin-right: auto;
  min-height: 80px;
  
  background-color: gray;
}

.arrows {
  position: absolute;
  top: 0px;
  left: -40px;
  width: 40px;
  height: 80px;
  background-color: teal;
}

.arrowUp {
  position: absolute;
  top: 5px;
  left: 5px;
	width: 0;
	height: 0;
	border-left: 15px solid transparent;
	border-right: 15px solid transparent;
	
	border-bottom: 20px solid black;
}

.arrowDown {
  position: absolute;
  top: 55px;
  left: 5px;
	width: 0;
	height: 0;
	border-left: 15px solid transparent;
	border-right: 15px solid transparent;
	
	border-top: 20px solid black;
}

.score {
  position: absolute;
  top: 30px;
  width: 40px;
  text-align: center;
  font-size: 20px;
  font-family: Helvetica;
}

p.commentHeadline {
  font-family: Optima, Helvetica, sans-serif;
  font-size: 120%;
  font-weight: bold;
  margin-bottom: 2px;
}

p.commentText {
  font-family: Baskerville, Georgia, serif;
  font-size: 100%;
  margin-top: 2px;
}

</style>

</head>

<body>

<script src="jquery-1.8.3.min.js"></script>
<script src="http://static-v2.crocodoc.com/core/docviewer.js"></script>

<script src="<?php print($sessionUrl); ?>"></script>

<script type="text/javascript">
$(document).ready(function(){
  var docViewer = new DocViewer({ "id": "docView" });
  
});
</script>

<div id="outer">
  <div id="docView">
  </div>
  
  <div id="lower">
  <div id="commentView">
    <?php
      foreach($COMMENTS as $comment)
      {
        $text = $comment->text;
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
  </div>
  </div>
</div>

</body>

</html>
