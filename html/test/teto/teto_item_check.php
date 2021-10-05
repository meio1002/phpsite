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
    RegularExpressions($post);

    $name = $_SESSION['login_name'];
    $pass = $_SESSION['login_pass'];

    $dsn= 'mysql:dbname=teto;host=mysql;charset=utf8';
    $user ='root';
    $password = 'testaaa';
    $dbh  = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT item1,item2,item3 FROM player where name = ? and password = ?';
    $stmt = $dbh->prepare($sql);
    $data[] = $name;
    $data[] = $pass;
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    // $sql = 'SELECT name,item1,item2,item3 FROM player where name = ? and password = ?';
    // $stmt = $dbh->prepare($sql);
    // $stmt->execute($data);
    // $rec = $stmt->fetch(PDO::FETCH_ASSOC);

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

// $itemと$postを比較して問題がなければ購入後の残りアイテム数を$hhhに記録
    $hhh = array();
    foreach($item as $itemkey => $itemval){
        foreach($post as $postkey => $postval){
            if ($itemkey === $postkey){ // $key判定
                if($itemval < $postval){ // 購入判定
                    echo '<p>アイテムが不足しています</p>';
                    echo '<input type="button" onclick="history.back()" value="戻る">';
                    exit();
                } else {
                    // 購入後の残りアイテム数
                    $hhh[$itemkey] = $itemval - $postval;
                } // 購入判定 end
            } // $key判定 end
        } // $postループ end
    } // $itemループend
    

    // $post配列が順番が入れ替わっていた場合に備えて$hhhをなにかしらの手段で整列させてからデータべースに格納しなければいけない必要がある
    var_dump($hhh);
// 変換したアイテム所持情報と$postを比較

//     if ($item !== $post){
        
//     }else {
//         echo '<p>アイテムが不足しています</p>';
//         echo '<input type="button" onclick="history.back()" value="戻る">';
//         // exit();
//     }
// $test = array_diff($post,$item);
// var_dump($test);

    // if($item == $post) {
    //     echo '1';
    // }else{echo '2';}
    // $test = array_diff($item,$post);
    // $test = array_diff($rec,$post);
    // $dbh  = new PDO($dsn,$user,$password);
    // $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $sql = 'SELECT name,item1,item2,item3 FROM player where name = ? and password = ?';
    // $stmt = $dbh->prepare($sql);
    // $stmt->execute($data);
    // $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    // $dbh = null;

    // var_dump($test);
    // var_dump($rec);
    // var_dump($item);
}
catch(Exception $e)
{
    echo '<p>ただいま障害により大変ご迷惑をお掛けしております。</p>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    exit();
}


