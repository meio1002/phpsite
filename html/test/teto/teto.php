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
    <link rel="stylesheet" href="./style.css">
    <meta charset="utf-8" />
    <title>テトリス</title>
  </head>
  <body>
    <div id="test" class="test">

    </div>
  <input type="hidden" name="0" class="fff">
    <?php


$vanish = $_SESSION['vanish'];
$change = $_SESSION['change'];
$cut = $_SESSION['cut'];


$vanish_json = json_encode($vanish);
$change_json = json_encode($change);
$cut_json = json_encode($cut);

?>

<script>

  let vanish = JSON.parse('<?php echo $vanish_json; ?>');
  let vanishpoint = 1 + vanish;

  let change = JSON.parse('<?php echo $change_json; ?>');
  let changepoint = 2 + change;

  let cut = JSON.parse('<?php echo $cut_json; ?>');
  let cutpoint = 3 + cut;

</script>

    <script src="../common/sketch2.js"></script>
  </body>
</html>
