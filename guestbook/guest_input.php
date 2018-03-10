<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>Art Box Guest Book</title>
</head>
<body>
<h3>Guest Book (Entry Board)</h3>
<form method="POST" action="guest_write.php">
  <div id="container">
    <label for="name">Name：</label>
    <input type="text" id="name" name="name"
      size="20" maxlength="30" />
  </div>
  <div id="container"> 
    <label for="message">Message：</label>
    <input type="text" id="message" name="message"
      size="70" maxlength="255" />
  </div>
  <input type="submit" value="SEND" />
</form>
<br />
<br />
<a href="guest_read.php"><font color="red" size="3">Go To View Page</font></a>

</body>
</html>