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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.10.2/p5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.10.2/addons/p5.sound.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8" />
    <title>テトリス</title>
  </head>
  <body>
    <div id="test" class="test">

    </div>

    <?php

$aaa = $_SESSION['vanish'];
$bbb = $_SESSION['cut'];
// print$aaa;
// print$aaa*2;

$aaa_json = json_encode( $aaa );
$bbb_json = json_encode( $bbb );
?>

<script>

    let param = JSON.parse('<?php echo $aaa_json; ?>');
    console.log(param);
    let vanishpoint = param;
    let param2 = JSON.parse('<?php echo $bbb_json; ?>');
    console.log(param2);
    let cutpoint = param2;

</script>

    <script src="../common/sketch2.js"></script>
  </body>
</html>
