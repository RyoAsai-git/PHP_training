<?php

/**
 * プレイヤーはN人(N>1)
 * トランプ52枚を順番に2枚ずつめくる
 * 同じ数字だったらもう一度めくる
 * めくるカードが無くなったら終了
 * 違う数字だったら次の人
 * N人目の次の人は1人目
 * J,Q,kは11,12,13でいい
 * 2枚めくって同じ数字だったらめくる対象から除外する
 * 各プレイヤーが取った組の数を出力する
 *
 * 神経衰弱です
 */

$cards = [];
$marks = ['spade', 'heart', 'diamond', 'club'];
foreach ($marks as $mark) {
    for ($number = 1; $number <= 13; $number++) {
        $cards[] = ['number' => $number, 'mark' => $mark];
    }
}

shuffle($cards);

$players       = ['player1', 'player2', 'player3'];
$player_scores = [];
foreach (array_keys($players) as $player_index) {
    $player_scores[$player_index] = 0;
}

while (!empty($cards)) {
    foreach (array_keys($players) as $current_player_index) {
        while (true) {
            $flipped_cards_indexes = array_rand($cards, 2);
            $card1                 = $cards[$flipped_cards_indexes[0]];
            $card2                 = $cards[$flipped_cards_indexes[1]];
            if ($card1['number'] === $card2['number']) {
                $player_scores[$current_player_index]++;
                unset($cards[$flipped_cards_indexes[0]], $cards[$flipped_cards_indexes[1]]);
            } else {
                break;
            }
            if (empty($cards)) {
                break 3;
            }
        }
    }
}

foreach ($players as $player_index => $player) {
    echo $player . 'は' . $player_scores[$player_index] . '組みです。<br>'; 
}