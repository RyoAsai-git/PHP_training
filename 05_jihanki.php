<?php

/**
 * エナジードリンク 150円
 * 炭酸飲料水 140円
 * スポーツドリンク 130円
 * 缶コーヒー 120円
 * ミネラルウォーター 110円
 *
 * 投入できるのは1000円札、500円硬貨、100円硬貨、50円硬貨、10円硬貨のみ
 * 10000円札、5000円札、2000円札、5円硬貨、1円硬貨は使用不可
 * 紙幣、硬貨の最大数はX枚とする(X > 0)
 *
 * ランダムで飲料を購入する
 * ただし、飲料の合計金額がNを超えてはならない
 * 各飲料の在庫数はY本とする(Y> 0)
 *
 * 任意の金額N円(1000,500,100,50,10円(の組み合わせで成立する額))を
 * 1回のみ自販機に投入して、
 * ランダムに何か買ってゆく。
 * それが何本でもいいし、何を買ってもいい。
 * まだ何か買えたとしても、どこで打ち切るかもランダム。
 *
 * 購入したら投入金額、各飲料の本数とその合計金額、全飲料の合計金額、おつりを表示する
 */

$drinks = [
    1 => [
        'name'  => 'エナジードリンク',
        'price' => 150,
        'stock' => 5,
    ],
    2 => [
        'name'  => '炭酸飲料水',
        'price' => 140,
        'stock' => 5,
    ],
    3 => [
        'name'  => 'スポーツドリンク',
        'price' => 130,
        'stock' => 5,
    ],
    4 => [
        'name'  => '缶コーヒー',
        'price' => 120,
        'stock' => 5,
    ],
    5 => [
        'name'  => 'ミネラルウォーター',
        'price' => 110,
        'stock' => 5,
    ],
];

$money_types = [1000, 500, 100, 50, 10];
$input_money = 0;
foreach ($money_types as $money) {
    $input_money += $money * rand(1, 10);
}
$remaining_money = $input_money;

$bought_drink_counts = [];
while (rand(0, 1) === 0) {
    $available_drink_ids = [];
    foreach ($drinks as $drink_id => $drink) {
        if ($drink['stock'] > 0 && $input_money >= $drink['price']) {
            $available_drink_ids[] = $drink_id;
        }
    }
    if (empty($available_drink_ids)) {
        break;
    }
    $buy_drink_id = $available_drink_ids[array_rand($available_drink_ids)];
    $input_money -= $drinks[$buy_drink_id]['price'];
    $drinks[$buy_drink_id]['stock']--;
    if (isset($bought_drink_counts[$buy_drink_id])) {
        $bought_drink_counts[$buy_drink_id]++;
    } else {
        $bought_drink_counts[$buy_drink_id] = 1;
    }
}

$total_bought_drink_price = 0;
foreach ($bought_drink_counts as $drink_id => $bought_drink_count) {
    $total_bought_drink_price += $bought_drink_count * $drinks[$drink_id]['price'];
}

?>

<!DOCTYPE html>
<html lang="ja"> 
  <head>
    <meta charset="UTF-8">
    <title>Bought some drinks</title>
  </head>
  <body>
    <p>投入金額は<?php echo $remaining_money ?>円です</p>
    <?php foreach ($bought_drink_counts as $bought_drink_id => $bought_drink_count) : ?> 
      <p><?php echo $drinks[$bought_drink_id]['name'] ?>を<?php echo $bought_drink_count ?>本購入しました</p>
      <p><?php echo $drinks[$bought_drink_id]['name'] ?>の合計金額は<?php echo  $bought_drink_count * $drinks[$bought_drink_id]['price'] ?>円です</p>
    <?php endforeach ?>
    <p>購入した飲み物の合計金額は<?php echo $total_bought_drink_price ?>円です</p>
    <p>お釣りは<?php echo $input_money ?>円です</p>
  </body>
</html>
