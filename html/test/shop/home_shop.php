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
    <title>ショップ</title>
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


$sql = 'SELECT name,value,gazou FROM item';
$stmt = $dbh->prepare($sql);
$stmt->execute();


while(true) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rec === false) {
        break;
    }
    $shopitem[] = $rec;

}

$sql = 'SELECT name,point,item1,item2,item3 FROM player where name = ? and id = ?';
$stmt = $dbh->prepare($sql);
$data[] = $name;
$data[] = $id;
$stmt->execute($data);


$dbh = null;

$rec = $stmt->fetch(PDO::FETCH_ASSOC);

$henkan['バニッシュ'] = 'vanish';
$henkan['チェンジ'] = 'change';
$henkan['カット'] = 'cut';

?>

<h1>プレイヤー情報</h1>
<div class="flex">
    <div class="possession-list rm">
            <h1>所持ポイント：<?php echo $rec['point']?></h1>
            <div　class="possession-item-list">
                <h2>所持アイテム</h2>
                <p>バニッシュ[S]：<?php echo $rec['item1']?>個</p>
                <p>チェンジ[D]：<?php echo $rec['item2']?>個</p>
                <p>カット[F]：<?php echo $rec['item3']?>個</p>
            </div>
        <div class="shop-list">
            <h1>SHOP</h1>
            <div class="shop-item-list">
                <form action="./home_shop_check.php" method="post">
    <?php

                foreach($shopitem as $val){
                    echo '<div class="item">';
                    echo '<img src="../images/'.$val['gazou'].'" alt="'.$val['name'].'">';
                    echo '<label for="'.$henkan[$val['name']].'value">'.$val['name'].'：'.$val['value'].'</label>';
                    echo '<input type="number" name="'.$henkan[$val['name']].'" id="'.$henkan[$val['name']].'value" min="0" max="10" value="0">';
                    echo '</div>';
                }
    ?>
                <input type="submit" value="購入へ">
                </form>
            </div>
        </div>
    </div>
</div>

<input type="button" onclick="history.back()" value="戻る">

<?php
}
catch(Exception $e)
{
    echo '<p>ただいま障害により大変ご迷惑をお掛けしております。</p>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    exit();
}

?>

</body>
</html>