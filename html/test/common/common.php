<?php
// サニタイズ
function sanitize($before)
{
    
    foreach($before as $key => $value)
    {
        $after[$key] = htmlspecialchars($value,ENT_QUOTES,'UTF-8');
    }
    return $after;
}

// 正規表現チェック
function RegularExpressions($before){
foreach($before as $val) {
    if(preg_match("/\A[0-9]+\z/",$val)==0)
    {
        echo'<p>数量に誤りがあります。</p>';
        echo '<input type="button" onclick="history.back()" value="戻る">';
        exit(); 
    }
}
}
?>