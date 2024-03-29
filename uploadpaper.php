<?php
require_once 'shared.php';
require_once 'crocodoc-php/Crocodoc.php';

$userId = $_GET['user_id'];
$user = $USERS[$userId];

$apiToken = getApiToken();

$tmpFilename = $_FILES['upload']['tmp_name'];
$fileId = uniqid();
$permFilename = 'files/' . $fileId . '.pdf';

$error = move_uploaded_file($tmpFilename, $permFilename);
error_log($srcFilename);

// Upload file to Crocodoc
Crocodoc::setApiToken($apiToken);
$file = fopen($permFilename, 'r');
$uuid = CrocodocDocument::upload($file);
fclose($file);

// Get available paper id
for($paperId = 1; ; $paperId++) {
  if(!array_key_exists($paperId, $PAPERS)) {
    break;
  }
}

// Make new paper object
$paper = array();
$paper['id'] = $paperId;
$paper['user_id'] = intval($userId);

$version = array();
$version['title'] = $_POST['title'];
$version['fileId'] = $fileId;
$version['crocodocUuid'] = $uuid;
$paper['comments'] = array();
$paper['versions'] == array();
$paper['versions'][0] = $version;

$paperJson = json_encode($paper);
$paperFilename = "papers/{$paperId}.json";
file_put_contents($paperFilename, $paperJson);
?>

<html>

<head>
<title>OpenPub</title>

</head>

<body>

<script type="text/javascript">
  window.location = "paper.php?id=<?php echo $paperId; ?>";
</script>

</body>

</html>
