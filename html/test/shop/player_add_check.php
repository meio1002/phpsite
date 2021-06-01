<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>player登録</title>
</head>
<body>
    
<?php

require_once('../common/common.php');
$post = sanitize($_POST);

$name = $_POST['name'];
$pass = $_POST['pass'];
$pass2 = $_POST['pass2'];

print$name;
print$pass;
print$pass2;

?>
</body>
</html>