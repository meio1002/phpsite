<!DOCTYPE html>
<html lang="ja">
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.10.2/p5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.10.2/addons/p5.sound.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>player登録</title>
</head>
<body>

<?php

$aaa = $_POST['name'];
// print$aaa;
// print$aaa*2;

$aaa_json = json_encode( $aaa );
?>

<script>
    let param = JSON.parse('<?php echo $aaa_json; ?>');
    console.log(param);
    let vanishpoint = param;
</script>
<script src="sketch.js">

</script>
</body>
</html>