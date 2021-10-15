<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>player登録</title>
</head>
<body>
    
<?php

require_once('../common/common.php');
$post = sanitize($_POST);

$name = $post['name'];
$pass = $post['pass'];
$pass2 = $post['pass2'];

if($name ==''){
    echo '<p class="alart">名前が入力されていません</p>';
}else{
    if(mb_strlen($name) > 30){
        echo '<p>プレイヤーネームは30文字以内で入力してください</p>';
    }else {
        echo '<p>プレーヤーネーム：'.$name.'</p>';
    }
}

if($pass ==''){
    echo '<p>パスワードが入力されていません</p>';
}

if($pass != $pass2){
    echo '<p>パスワードが一致しません</p>';
}

if($name =='' || $pass =='' || $pass != $pass2){
    echo '<form>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '</form>';
}else{
    $pass = password_hash($pass,PASSWORD_DEFAULT);
    echo '<form method="post" action="player_add_done.php">';
    echo '<div class="box1">';
    echo '<input type="hidden" name="name" value="'.$name.'">';
    echo '<input type="hidden" name="pass" value="'.$pass.'">';
    echo '</div>';
    echo '<input type="button" onclick="history.back()" value="戻る">';
    echo '<input type="submit" value="OK">';
    echo '</form>';
}
?>
</body>
</html>