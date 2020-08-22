<?php

/**
 * ウルトラソウル
 *
 * ウル / トラ / ソウル の3つの中からランダムに出力しつづける
 * もし、ウルトラソウルの3つが続いたら「ハイ！」と出力する
 * おわり
 */

$lyrics  = ['ウル', 'トラ', 'ソウル'];
$history = [];

while ($lyrics !== $history) {
    $random_index = array_rand($lyrics);
    echo $lyrics[$random_index];
    $history[] = $lyrics[$random_index];

    if (count($history) > count($lyrics)) {
        array_shift($history);
    }
}
echo 'ハイ！';