<?php

try
{
    require_once('../common/common.php');
    $post = sanitize($_POST);

    $login_name =$post['name'];
    $login_pass =$post['pass'];

    $dsn= 'mysql:dbname=teto;host=mysql;charset=utf8';
    $user ='root';
    $password = 'testaaa';
    $dbh  = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT name,password FROM player where name=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $login_name;
    // $stmt->execute();
    $stmt->execute($data);

    $dbh = null;
    // $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    

    // if ($rec['password'] == '$2y$10$NZ29U9x5MvufvfO4x7oKi.wCq95sX21LSHimzNQFb.Pz7vwaW6tqy'){
    //     echo 'OK';
    // }
    // else {
    //     echo 'NG';
    // }

    // foreach ($rec as $v){
    //     print $v;
    // }

while(true)
{
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if($rec==false)
    {
        echo '<p>ログインできませんでした</p>';
        echo '<a href="player_login.html">戻る</a>';
        break;
    }

    if(password_verify($login_pass, $rec['password'])){
        // print '認証成功';
        header('Location: test_a.php');
        exit();
        // break;
    }
    // }else{
    //     print '認証失敗';
    // }
    // if ($rec['password'] == '$2y$10$NZ29U9x5MvufvfO4x7oKi.wCq95sX21LSHimzNQFb.Pz7vwaW6tqy'){
    //     echo 'OK';
    // }
    // else {
    //     echo 'NG';
    // }
    // foreach ($rec as $value) {
    //     echo '<p>'.$value.'</p>';
    // }
}


//     foreach ($rec as $value) {
//         echo '<p>'.$value.'</p>';
//     }
//     // echo '<p>'.$rec['name'].'</p>';
// }
    exit();

}

catch (Exception $e)
{
    print'障害';
    echo $e;
    exit();
}


?>
