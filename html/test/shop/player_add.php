<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>player登録</title>
    <script type="text/javascript" src="../common/passwordchecker.js"></script>
    <script type="text/javascript" src="../common/common.js"></script>

</head>
<body>
<div>
    
</div>
    <h2>プレイヤー登録</h2>
    <form method="post" action="player_add_check.php">
    <p>プレイヤーネーム</p>
    <input type="text" name="name" class="200">
    <p>パスワード</p>
    <input type="password" name="pass" id="password" class="200" onkeyup="setPasswordLevel(this.value);">
    <div id="pass_message"></div>
    <p>パスワード（確認）</p>
    <input type="password" name="confirm_password" id="confirm_password" class="200" onkeyup="setConfirmMessage(this.value);">
    <div id="pass_confirm_message"></div>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
    </form>
</body>
</html>