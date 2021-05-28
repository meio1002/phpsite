<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>player登録</title>
</head>
<body>
    <h2>プレイヤー登録</h2>
    <form method="post" action="player_add_check.php">
    <p>プレイヤーネーム</p>
    <input type="text" name="name" class="200">
    <p>パスワード</p>
    <input type="password" name="pass" class="200">
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
    </form>
</body>
</html>