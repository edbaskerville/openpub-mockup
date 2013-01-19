<?php
require_once 'shared.php';
?>

<html>

<head>
<title>OpenPub</title>

</head>

<body>

<script src="jquery.js"></script>
<script src="jquery-ui.js"></script>

<script src="<?php print($sessionUrl); ?>"></script>

<div id="outer">
  
    <div id="toolbarView">
      <p>OpenPub</p>
    </div>
    
    <div id="papersView">
      <?php
        foreach($PAPERS as $paper)
        {
          $versions = $paper->versions;
          $lastVersion = end($versions);
          
          $title = $lastVersion->title;
          $datetime = $lastVersion->datetime;
          $userName = $USERS[$paper->user_id]->name;
          
          $authorships = $lastVersion->authorships;
          $firstAuthorName = $USERS[$authorships[0]->user_id]->name;
          
          ?>
          <div id="paper<?php echo $paper->id ?>" class="paper">
            <p class="paperTitle">
              <a href="paper.php?id=<?php echo $paper->id ?>"><?php echo $title ?></a>
            <p class="paperAuthors">
              <?php
                echo $firstAuthorName;
                if(count($authorships) == 2) {
                  $secondAuthorName = $USERS[$authorships[1]->user_id]->name;
                  echo " &amp; $secondAuthorName";
                }
                else if(count($authorships) > 2) {
                  echo " et al.";
                }
              ?>
            </p>
          </div>
          <?php
        }
      ?>
    </div> <!--papersView-->
</div> <!--outer-->

</body>

</html>
