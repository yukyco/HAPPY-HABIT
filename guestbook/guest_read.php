<?php require_once '../Encode.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>Art Box Guest Book</title>
</head>
<body>
<h3>Guest Book(Veiwer)</h3>
<?php
$file = @fopen('guest.dat', 'rb')
  or die('The file could not open.');
flock($file, LOCK_SH);
print('<dl>');
while ($data = fgets($file)) {
  $row = explode("\t", $data);
?>
  <dt><?php print(e($row[1])); ?>
    （<?php print(e($row[0])); ?>）</dt>
  <dd>MESSAGE:<?php print(e($row[2])); ?><hr /></dd>
<?php
}
print('</dl>');
flock($file, LOCK_UN);
fclose($file);
?>
<br />
<br />
<a href="guest_input.php"><font color="red" size="3">Go To Entry Page</font></a>
</body>
</html>
