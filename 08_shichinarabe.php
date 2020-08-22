<?php
/**
 * 七並べをするプログラム
 *
 * トランプが48枚あります
 * 7はすべてゲーム開始時に並べられています
 *
 * 4人でプレイします(1人当たり手札は12枚)
 *
 * プレイヤーは順番にカードを並べていきます
 * 並べられるカードはすでに並べてあるカードの数字と隣り合う数字だけです
 *
 * カードが置けない場合は3回までスキップできます(4回目で失格)
 * 失格になったら手持ちのカードをすべて並べます
 *
 * ゲームを有利に進めるため、カードは7から遠い数字のものを優先的に置いていきます
 *
 * 手札がなくなったらゲームクリアです
 * クリアした順番を出力します
 *
 * 失格の場合は最下位です
 * 失格の時点で、その人の持っていたカードは全て場に置かれます
 * (ただし、7, 8, _, 10 と場にあった時に 11 は置けません)
 * もし、失格が2人以上いた場合は同率最下位です

 * 13の次に1はおけない
 */

$play_field = [];
$cards      = [];
$marks      = ['spade', 'heart', 'diamond', 'club'];
foreach ($marks as $mark) {
    $play_field[$mark] = [];
    for ($number = 1; $number <= 13; $number++) {
        $cards[]                    = ['number' => $number, 'mark' => $mark];
        $play_field[$mark][$number] = false;
    }
}

foreach ($cards as $card_index => $card) {
    if ($card['number'] === 7) {
        $play_field[$card['mark']][$card['number']] = true;
        unset($cards[$card_index]);
    }
}

shuffle($cards);

$player_names   = ['佐藤', '田中', '鈴木', '山本'];
$joined_players_names = $player_names;

$player_hands = [];
while (count($cards) > 0) {
    foreach (array_keys($joined_players_names) as $joined_player_index) {
        if (!isset($player_hands[$joined_player_index])) {
            $player_hands[$joined_player_index] = [];
        }
        $player_hands[$joined_player_index][] = array_shift($cards);
    }
}

$player_skip_counts = [];
foreach (array_keys($joined_players_names) as $joined_player_index) {
    $player_skip_counts[$joined_player_index] = 0;
}

$player_ranks       = [];
$current_rank_order = 1;

while (count($joined_players_names) > 0) {
    foreach (array_keys($joined_players_names) as $joined_player_index) {
        $available_cards = [];
        foreach ($marks as $mark) {
            for ($number = 8; $number <= 13; $number++) {
                if ($play_field[$mark][$number] === false) {
                    $available_cards[] = ['number' => $number, 'mark' => $mark];
                    break;
                }
            }
            for ($number = 6; $number >= 1; $number--) {
                if ($play_field[$mark][$number] === false) {
                    $available_cards[] = ['number' => $number, 'mark' => $mark];
                    break;
                }
            }
        }

        $selectable_cards = [];
        foreach ($player_hands[$joined_player_index] as $player_card) {
            if (in_array($player_card, $available_cards)) {
                $selectable_cards[] = $player_card;
            }
        }

        if (empty($selectable_cards)) {
            $player_skip_counts[$joined_player_index]++;
            if ($player_skip_counts[$joined_player_index] === 3) {
                foreach ($player_hands[$joined_player_index] as $player_hand_index => $player_card) {
                    $play_field[$player_card['mark']][$player_card['number']] = true;
                    unset($player_hands[$joined_player_index][$player_hand_index]);
                }
                $player_ranks[$joined_player_index] = count($player_names);
                unset($joined_players_names[$joined_player_index]);
            }
            continue;
        }

        $selected_card = null;
        foreach ($selectable_cards as $selectable_card) {
            if ($selected_card === null) {
                $selected_card = $selectable_card;
                continue;
            }
            if (abs($selectable_card['number'] - 7) > abs($selected_card['number'] - 7)) {
                $selected_card = $selectable_card;
            }
        }

        $play_field[$selected_card['mark']][$selected_card['number']] = true;
        $selected_card_index                                          = array_search($selected_card, $player_hands[$joined_player_index]);
        unset($player_hands[$joined_player_index][$selected_card_index]);
        if (empty($player_hands[$joined_player_index])) {
            $player_ranks[$joined_player_index] = $current_rank_order;
            $current_rank_order++;
            unset($joined_players_names[$joined_player_index]);
        }
    }
}

asort($player_ranks);

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>Shichinarabe</title>
  </head>
  <body>
    <h1>結果</h1>
    <?php foreach ($player_ranks as $player_index => $player_rank) : ?>
      <p><?php echo $player_names[$player_index] ?>さんは<?php echo $player_rank ?>位です。</p>
    <?php endforeach ?>
  </body>
</html>