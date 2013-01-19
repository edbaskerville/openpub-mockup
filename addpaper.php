<?php
require_once 'shared.php';

$userId = $_GET['user_id'];
$user = $USERS[$userId]
?>

<html>

<head>
<title>OpenPub</title>

</head>

<body>

<script src="jquery.js"></script>

<div id="outer">
  <div id="addNewView">
    <form enctype="multipart/form-data" action="uploadpaper.php?user_id=<?php echo $userId; ?>" method="POST">
      <div>
        <label>
          <span>Title</span>
          <input type="text" id="titleField" name="title" />
        </label>
      </div>
      
      <?php
      for($i = 0; $i < 5; $i++) {
      ?>
        <div>
          <label>
            <span>Author <?php echo $i+1; ?></span>
            <select id="author<?php echo $i; ?>">
              <?php if($i == 0) {
              ?>
                <option selected="selected" value="<?php echo $userId; ?>">
                  <?php echo $user->name; ?>
                </option>
              <?php
              } 
              ?>
              <?php if($i != 0) { ?>
                <option selected="selected" value="0">(None)</option>
              <?php } ?>
              <?php foreach($USERS as $u) {
                if($u == $user) continue;
              ?>
                <option value="<?php echo $u->id ?>"><?php echo $u->name; ?></option>
              <?php } ?>
            </select>
          </label>
          <label>
            <input type="checkbox" name="primary<?php echo $i; ?>" value="0" />
            <span>Primary</span>
          </label>
          <label>
            <input type="checkbox" name="senior<?php echo $i; ?>" value="0" />
            <span>Senior</span>
          </label>
        </div>
      <?php
      }
      ?>
      
      <div>
        <span>File:</span>
        <input type="file" name="upload">
      </div>
      
      <div>
        <input type="submit" id="sendButton" value="Send" class="sendButton" />
      </div>
    </form>
  </div> <!--addNewView-->
</div> <!--outer-->

</body>

</html>
