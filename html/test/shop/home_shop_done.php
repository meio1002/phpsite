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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test_a</title>
</head>
<body>
    <?php
try {

    $cart = $_SESSION['cart'];
    $balance = $_SESSION['balance'];
    $name = $_SESSION['login_name'];
    $pass = $_SESSION['login_pass'];
    
// 購入前のアイテム所持数を取得
    $dsn= 'mysql:dbname=teto;host=mysql;charset=utf8';
    $user ='root';
    $password = 'testaaa';
    $dbh  = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT item1,item2,item3 FROM player where name = ? and password = ?';
    $stmt = $dbh->prepare($sql);
    $data = array();
    $data[] = $name;
    $data[] = $pass;
    $stmt->execute($data);

    $rec = $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    $stock['vanish'] = $rec['item1'];
    $stock['change'] = $rec['item2'];
    $stock['cut'] = $rec['item3'];

// 現在所持しているアイテム数に購入予定のアイテム数を加える
    foreach($cart as $key => $val){ // $cartの中が存在しているかの確認は必要ない？
        $stock[$key] = $stock[$key] + $val;
    }

// 購入処理 /////////////////////////////////////////////////////////
    $dbh  = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'UPDATE player SET item1 = ? , item2 = ? , item3 = ? , point = ? WHERE name = ? and password = ?';
    $stmt = $dbh->prepare($sql);
    $data = array();
    $data[] = $stock['vanish'];
    $data[] = $stock['change'];
    $data[] = $stock['cut'];
    $data[] = $balance;
    $data[] = $name;
    $data[] = $pass;
    $stmt->execute($data);
    
    $dbh = null;

    unset($_SESSION['cart']);
    unset($_SESSION['balance']);

    echo '<p>購入完了</p>';
    echo '<a href="./player_home.php">ホームへ戻る</a>';
}
catch(Exception $e)
{
    echo '<p>ただいま障害により大変ご迷惑をお掛けしております。</p>';
    exit();
}

    ?>


</body>
</html>