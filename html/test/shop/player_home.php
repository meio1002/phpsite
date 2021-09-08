<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プレイヤー情報</title>
</head>
<body>
    
<?php 

try
{
    require_once('../common/common.php');
    $post = sanitize($_POST);

    $name = $post['name'];
    $pass = $post['pass'];

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
<h1>プレイヤーネーム：<?php echo $rec['name']; ?></h1>
<p>所持ポイント：<?php echo $rec['point']?></p>
<p>アイテム1：<?php echo $rec['item1']?>個</p>
<p>アイテム2：<?php echo $rec['item2']?>個</p>
<p>アイテム3：<?php echo $rec['item3']?>個</p>

<div class="home_post">
<form method="post" action="teto_shop.php">
    
    <input type="submit" value="ショップへ">
</form>
<form method="post" action="test_b.php">
    <input type="text" name="test_b">
    <input type="submit" value="test_b">
</form>
</div>
<?php
// foreach ($rec as $value) {
//     echo '<p>'.$value.'</p>';
// }

// while(true)
// {
    // $rec = $stmt->fetch(PDO::FETCH_ASSOC);
//     if($rec==false)
//     {
//         break;
//     }
    // foreach ($rec as $value) {
    //     echo '<p>'.$value.'</p>';
    // }
//     // echo '<p>'.$rec['name'].'</p>';
// }

}
catch(Exception $e)
{
    echo '<p>ただいま障害により大変ご迷惑をお掛けしております。</p>';
    exit();
}

?>

</body>
</html>