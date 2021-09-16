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
    <title>ショップ</title>
</head>
<body>
    
<?php 

try
{
    $name = $_SESSION['login_name'];
    $pass = $_SESSION['login_pass'];

$dsn= 'mysql:dbname=teto;host=mysql;charset=utf8';
$user ='root';
$password = 'testaaa';
$dbh  = new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// $sql = 'SELECT name FROM player ';
$sql = 'SELECT name,point,item1,item2,item3 FROM player where name = ? and password = ?';
$stmt = $dbh->prepare($sql);
$data[] = $name;
$data[] = $pass;
$stmt->execute($data);



$dbh = null;

echo '<h1>プレイヤー情報</h1>';

$rec = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<div>
    <div class="possession-list">
        <h1>所持ポイント：<?php echo $rec['point']?></h1>
        <div　class="possession-item-list">
            <h2>所持アイテム</h2>
            <p>バニッシュ[S]：<?php echo $rec['item1']?>個</p>
            <p>チェンジ[D]：<?php echo $rec['item2']?>個</p>
            <p>カット[F]：<?php echo $rec['item3']?>個</p>
        </div>
    </div>
    <div class="shop-list">
        <h1>SHOP</h1>
        <div class="shop-item-list">

        </div>
    </div>
</div>

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