<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false)
{
    echo '<p>ログインされていません</p>';
    echo '<a href="./player_login.html">ログイン画面へ</a>';
    exit();
}

try{
    require_once('../common/common.php');
    $post = sanitize($_POST);
    if(RegularExpressions($post) === true){
        echo'<p>数量に誤りがあります。</p>';
        echo '<input type="button" onclick="history.back()" value="戻る">';
        exit(); 
    }

    $name = $_SESSION['login_name'];
    $id = $_SESSION['login_id'];

    $dsn= 'mysql:dbname=teto;host=mysql;charset=utf8';
    $user ='sample_user';
    $password = 'sample_pass';
    $dbh  = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT item1,item2,item3 FROM player where name = ? and id = ?';
    $stmt = $dbh->prepare($sql);
    $data[] = $name;
    $data[] = $id;
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    $dbh = null;


// データベースから持ってきたアイテム所持情報$recを比較できるように$itemに変換
    $item = array();
    foreach ($rec as $key => $val){
        switch($key){
            case 'item1':
                $item['vanish'] = $val;
                break;
            case 'item2':
                $item['change'] = $val;
                break;
            case 'item3':
                $item['cut'] = $val;
                break;
        }
    }

// $itemと$postを比較して問題がなければ購入後の残りアイテム数を$stockに記録
    $stock = array();
    foreach($item as $itemkey => $itemval){
        foreach($post as $postkey => $postval){
            if ($itemkey === $postkey){ // $key判定
                if($itemval < $postval){ // 購入判定
                    echo '<p>アイテムが不足しています</p>';
                    echo '<input type="button" onclick="history.back()" value="戻る">';
                    exit();
                } else {
                    // 購入後の残りアイテム数
                    $stock[$itemkey] = $itemval - $postval;
                } // 購入判定 end
            } // $key判定 end
        } // $postループ end
    } // $itemループend
    

    $dbh  = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'UPDATE player SET item1 = ? , item2 = ? , item3 = ? WHERE name = ? and id = ?';
    $stmt = $dbh->prepare($sql);
    $data =array();
    $data[] = $stock['vanish'];
    $data[] = $stock['change'];
    $data[] = $stock['cut'];
    $data[] = $name;
    $data[] = $id;
    $stmt->execute($data);
    
    $dbh = null;

foreach($post as $key => $val){
    $_SESSION[$key] = (int)$val;
}
    header('Location:teto.php');
    exit();

}
catch(Exception $e)
{
    echo '<p>ただいま障害により大変ご迷惑をお掛けしております。</p>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    exit();
}


