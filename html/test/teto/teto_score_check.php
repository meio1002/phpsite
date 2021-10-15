<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false)
{
    echo '<p>ログインされていません</p>';
    echo '<a href="../shop/player_login.html">ログイン画面へ</a>';
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
    <title>Document</title>
</head>
<body>
<?php 


    try{
        require_once('../common/common.php');
        $post = sanitize($_POST);
        if(RegularExpressions($post) === true) {
            echo 'ダメ';
            exit();
        }
    
        $name = $_SESSION['login_name'];
        $id = $_SESSION['login_id'];
    
        // 現在の所持ポイントを取得する
        $dsn= 'mysql:dbname=teto;host=mysql;charset=utf8';
        $user ='sample_user';
        $password = 'sample_pass';
        $dbh  = new PDO($dsn,$user,$password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = 'SELECT point FROM player where name = ? and id = ?';
        $stmt = $dbh->prepare($sql);
        $data[] = $name;
        $data[] = $id;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        $dbh = null;

        // データ型が文字列型になっているので整数に変換する
        foreach($post as $key => $val){
            $post[$key] = (int)$val;
            }

        $point = (int)$rec['point'];

        // 所持ポイントにスコアをたす
        $point = $point + $post['score'];

        // 合計したポイントをデータベースに入れる
        $dbh  = new PDO($dsn,$user,$password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = 'UPDATE player SET point = ? WHERE name = ? and id = ?';
        $stmt = $dbh->prepare($sql);
        $data =array();
        $data[] = $point;
        $data[] = $name;
        $data[] = $id;
        $stmt->execute($data);
        
        $dbh = null;
    
        unset($_SESSION['vanish']);
        unset($_SESSION['change']);
        unset($_SESSION['cut']);

        header('Location:../shop/player_home.php');
        exit();
    
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