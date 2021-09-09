<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プレイヤー登録</title>
</head>
<body>
 <?php

try{

    require_once('../common/common.php');
    $post = sanitize($_POST);

    $name = $post['name'];
    $pass = $post['pass'];

    $dsn= 'mysql:dbname=teto;host=mysql;charset=utf8';
    $user ='root';
    $password = 'testaaa';
    $dbh  = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'INSERT INTO player(name,password,point,item1,item2,item3) VALUES (?,?,0,0,0,0)';
    $stmt = $dbh->prepare($sql);
    $data[] = $name;
    $data[] = $pass;
    $stmt->execute($data);

    $dbh = null;

    echo '<p>プレイヤー'.$name.'を登録しました</p>';
    echo '<a href="player_login.html">ログインへ</a>';
    // echo '<form action="player_home.php" method="post">';
    // echo '<input type="hidden" name="name" value="' .$name. '">';
    // echo '<input type="hidden" name="pass" value="' .$pass. '">';
    // echo '<input type="submit" value="OK">';
    // echo '</form>';

}
catch (Exception $e)
{
    print '<p>エラー発生'.htmlspecialchars($e->getMessage(), ENT_QUOTES,'UTF-8') . '</p>';
    print '<p>ただいま障害により大変ご迷惑をお掛けしております。</p>';
    print '<input type="button" onclick="history.back()" value="戻る">';
}

?>

</body>
</html>