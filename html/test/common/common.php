<?php

function sanitize($before)
{
    
    foreach($before as $key => $value)
    {
        $after[$key] = htmlspecialchars($value,ENT_QUOTES,'UTF-8');
    }
    return $after;
}

// function henkan($before){

//     switch($before){

//         // バニッシュ
//         case 'バニッシュ':
//             $before = 'vanish';
//             echo $before;
//             break;
//         case 'vanish':
//             $before = 'バニッシュ';
//             echo $before;
//             break;
//         // チェンジ
//         case 'チェンジ':
//             $before = 'change';
//             echo $before;
//             break;
//         case 'change':
//             $before = 'チェンジ';
//             echo $before;
//             break;
//         // カット
//         case 'カット':
//             $before = 'cut';
//             echo $before;
//             break;
//         case 'cut':
//             $before = 'カット';
//             echo $before;
//             break;
//         }

// }

?>