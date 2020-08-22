<?php

/**
 * 箱
 *  大きさ　10~20
 *  空き容量1以下で発送
 *  100個
 *
 * 荷物
 *  大きさ　1~5
 *  無限で出てくる
 *
 * ストック場
 *  荷物が入らない場合、ここに置く
 *  箱に入れられる荷物がある場合は、最初にここから入れられるだけ入れる
 *
 * 終了条件
 * 　発送数100
 *
 */

$shipping_boxes = [];
$stock_baggages = [];

while (count($shipping_boxes) < 100) {
    $box = [
        'size'     => rand(10, 20),
        'baggages' => [],
    ];

    $box_size = $box['size'];
    foreach ($stock_baggages as $baggage_index => $baggage) {
        if ($baggage <= $box_size) {
            $box['baggages'][] = $baggage;
            $box_size         -= $baggage;
            unset($stock_baggages[$baggage_index]);
            if ($box_size <= 1) {
                break;
            }
        }
    }

    while ($box_size > 1) {
        $baggage = rand(1, 5);
        if ($box_size >= $baggage) {
            $box['baggages'][] = $baggage;
            $box_size         -= $baggage;
        } else {
            $stock_baggages[] = $baggage;
        }
    }
    $shipping_boxes[] = $box;
}

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>Packing</title>
  </head>
  <body>
    <h1>発送結果</h1>
    <?php foreach($shipping_boxes as $index => $box) : ?>
      <p><?php echo $index + 1 ?>個目の箱</p>
      <p>箱の大きさ</p>
        <?php echo $box['size'] ?>
      <p>荷物の大きさ</p>
        <?php foreach ($box['baggages'] as $baggage) : ?>
          <?php echo $baggage ?>
        <?php endforeach ?>
    <?php endforeach ?>
    <h2>ストック場の荷物</h2>
      <?php foreach ($stock_baggages as $baggage) : ?>
        <p><?php echo $baggage ?></p>
      <?php endforeach ?>
  </body>
</html>

