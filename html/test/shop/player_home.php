<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false)
{
    echo '<p>ログインされていません</p>';
    echo '<a href="./player_login.html">ログイン画面へ</a>';
    exit();
}
else
{
    echo '<p>プレイヤー<strong>'.$_SESSION['login_name'].'</strong> ログイン中</p>';

}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>プレイヤー情報</title>
</head>
<body>
    
<?php 

try
{

    $name = $_SESSION['login_name'];
    $id = $_SESSION['login_id'];

$dsn= 'mysql:dbname=teto;host=mysql;charset=utf8';
$user ='sample_user';
$password = 'sample_pass';
$dbh  = new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'SELECT name,point,item1,item2,item3 FROM player where name = ? and id = ?';
$stmt = $dbh->prepare($sql);
$data[] = $name;
$data[] = $id;
$stmt->execute($data);

$dbh = null;

echo '<h1>プレイヤー情報</h1>';

$rec = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<div class="flex bm">

<div class="home_shop rm">
    <h1>プレイヤーネーム：<?php echo $rec['name']; ?></h1>
    <p>所持ポイント：<?php echo $rec['point']?></p>
    <p>バニッシュ[S]：<?php echo $rec['item1']?>個</p>
    <p>チェンジ[D]：<?php echo $rec['item2']?>個</p>
    <p>カット[F]：<?php echo $rec['item3']?>個</p>

    <a href="./home_shop.php">ショップへ</a>
    
</div>

<div class="home_post">


<h1>持ち込みアイテム</h1>
<form method="post" action="../teto/teto_item_check.php">
    <div class="teto-item"><label for="vanish">バニッシュ[S]<input type="number" name="vanish" id="vanish" value="0" min="0" max="<?php echo $rec['item1']; ?>">個</label></div>
    <div class="teto-item"><label for="change">チェンジ[D]<input type="number" name="change" id="change" value="0" min="0" max="<?php echo $rec['item2']; ?>">個</label></div>
    <div class="teto-item"><label for="cut">カット[F]<input type="number" name="cut" id="cut" value="0" min="0" max="<?php echo $rec['item3']; ?>">個</label></div>
    <input type="submit" value="テトリスをプレイする">
</form>
</div>

</div>
<a href="player_logout.php">ログアウト</a>
<?php

}
catch(Exception $e)
{
    echo '<p>ただいま障害により大変ご迷惑をお掛けしております。</p>';
    exit();
}

?>

</body>
</html>