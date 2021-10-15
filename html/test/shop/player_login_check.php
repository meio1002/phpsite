<?php

try
{
    require_once('../common/common.php');
    $post = sanitize($_POST);

    $login_name =$post['name'];
    $login_pass =$post['pass'];

    $dsn= 'mysql:dbname=teto;host=mysql;charset=utf8';
    $user ='sample_user';
    $password = 'sample_pass';
    $dbh  = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT id,name,password FROM player where name=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $login_name;

    $stmt->execute($data);

    $dbh = null;

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
        session_start();
        $_SESSION['login']=1;
        $_SESSION['login_name']=$login_name;
        $_SESSION['login_id']=$rec['id'];
        header('Location: player_home.php');
        exit();
        // break;
    }

}

    exit();

}

catch (Exception $e)
{
    echo '<p>障害発生</p>';
    echo '<a href="./player_login.html">戻る</a>';
    exit();
}
