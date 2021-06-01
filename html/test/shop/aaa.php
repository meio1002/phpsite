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
<script src="../teto/sketch.js">