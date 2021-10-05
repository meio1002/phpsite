<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false)
{
    echo '<p>ログインされていません</p>';
    echo '<a href="./player_login.html">ログイン画面へ</a>';
    exit();
}

try {

    require_once('../common/common.php');
    $post = sanitize($_POST);

    $name = $_SESSION['login_name'];
    $pass = $_SESSION['login_pass'];

    $dsn= 'mysql:dbname=teto;host=mysql;charset=utf8';
    $user ='root';
    $password = 'testaaa';
    $dbh  = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    $sql = 'SELECT point FROM player where name = ? and password = ?';
    $stmt = $dbh->prepare($sql);
    $data[] = $name;
    $data[] = $pass;
    $stmt->execute($data);
    
    $dbh = null;
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $point = $rec['point'];


// $post選別 /////////////////////////////////////////////////////////////////
foreach($post as $key => $val){
    if ($val > 0){
    $buy[$key] = $val;
    } 
 }// $post選別 end

// 商品有無判定 /////////////////////////////////////////////////////////////
if (isset($buy) === true){
// 値段合計 /////////////////////////////////////////////////////////////////
 $value = 0;
 foreach ($buy as $key => $val){
    // バニッシュ
    if ($key === 'vanish'){
        $value += $val * 2000;
    }
    // チェンジ
    if ($key === 'change'){
        $value += $val * 1500;
    }
    // カット
    if ($key === 'cut'){
        $value += $val * 1000;
    }

} // 値段合計 end

// 購入判定 //////////////////////////////////////////////////////////////
$balance = $point - $value;
if ($balance >= 0){
    foreach ($buy as $key => $val){
        $cart[$key] = $val;
    }
    $_SESSION['cart'] = $cart;
    $_SESSION['balance'] = $balance;
    header('Location:test_c.php');
    exit();
}else{
    echo '<p>購入できませんでした</p>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
} // 購入判定 end

}else {
    echo '<p>商品が選択されていません</p>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
} // 商品有無判定 end



}
catch(Exception $e)
{
    echo '<p>ただいま障害により大変ご迷惑をお掛けしております。</p>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    exit();
}

    ?>

