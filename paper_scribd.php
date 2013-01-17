<?php
require_once "scribd_php_client/scribd.php";
require_once "shared.php";
?>

<html>

<head>
<title>OpenPub</title>

<style type="text/css">
body {
  margin: 0;
  padding: 0;
}

#outer {
  width: 100%;
  max-width: 100px;
  height: 100%;
}

#docView {
  position: absolute;
  top: 0%;
  left: 0%;
  width: 100%;
  height: 400px;
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

<script type='text/javascript'
  src='http://www.scribd.com/javascripts/scribd_api.js'>
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

<script type="text/javascript">
  var scribdDoc = scribd.Document.getDoc(120722793, 'key-25y7g4ptk7uddz2duvbl');
  
  var onDocReady = function(e){
  }
  
  scribdDoc.addParam('jsapi_version', 2);
  scribdDoc.addParam('height', 400);
  scribdDoc.addEventListener('docReady', onDocReady);
  scribdDoc.write('docView');
</script>

</body>

</html>
