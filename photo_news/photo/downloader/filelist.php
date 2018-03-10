<?php require_once '../Encode.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../img/favicon.png" />

    <title>Admin Artist</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/game.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="css/assets/js/ie-emulation-modes-warning.js"></script>
    <link rel="shortcut icon" href="img/favicon.png" type="image/vnd.microsoft.icon" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
      </div>
	</nav>
  
<h3>File List</h3>
<table border="1">
<tr>
  <th>File</th><th>SIZE</th><th>The last day which was accessed.</th><th>The last update.</th>
</tr>
<?php
const DOC_ROOT = '../doc/';
clearstatcache();
$o_dir = @opendir(DOC_ROOT)
  or die('フォルダが開けませんでした。');
while ($file = readdir($o_dir)) {
  if (is_file(DOC_ROOT.$file)) {
    $path = DOC_ROOT.$file;
    $file = mb_convert_encoding($file, 'UTF-8', 'SJIS-WIN');
?>
    <tr>
      <td><a href="download.php?path=<?php print(urlencode($file)); ?>">
	      <?php print(e($file)); ?></a></td>
      <td><?php print(round(filesize($path) / 1024)); ?>KB</td>
      <td><?php print(date('Y/m/d H:i:s', fileatime($path))); ?></td>
      <td><?php print(date('Y/m/d H:i:s', filemtime($path))); ?></td>
    </tr>
<?php
  }
}
closedir($o_dir);
?>
</table>
</body>
</html>
