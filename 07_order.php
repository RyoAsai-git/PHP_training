<?php

/**
 * 製品A
 *   部品A2個と部品B1個からできています。
 * 製品B
 *   部品C3個と部品D2個からできています。
 * 製品C
 *   部品B1個と部品D1個からできています。
 *
 * 製品Aと製品Bと製品Cをランダムで発注します。
 * 部品にはそれぞれ在庫があり製品が作れなくなるまで製造をします。
 *
 * 最後に以下を出力します。
 *
 * 製造前の各部品の在庫数
 * 製品の発注数
 * 製造した製品の個数
 * 製造後の各部品の在庫数
 */

function get_manufacturable_product_ids($product_components, $part_stocks) {
    $manufacturable_product_ids = [];
    foreach ($product_components as $product_component_id => $product_component) {
        $can_manufacture = true;
        foreach ($product_component['part'] as $part_id => $part_count) {
            if ($part_count > $part_stocks[$part_id]['stock']) {
                $can_manufacture = false;
                break;
            }
        }
        if ($can_manufacture) {
            $manufacturable_product_ids[] = $product_component_id;
        }
    }

    return $manufacturable_product_ids;
}

$product_components = [
    1 => [
        'name' => 'A',
        'part' => [
            1 => 2,
            2 => 1,
        ],
    ],
    2 => [
        'name' => 'B',
        'part' => [
            3 => 3,
            4 => 2,
        ],
    ],
    3 => [
        'name' => 'C',
        'part' => [
            2 => 1,
            4 => 1,
        ],
    ],
];

$part_stocks = [
    1 => [
        'name'  => 'A',
        'stock' => 5,
    ],
    2 => [
        'name'  => 'B',
        'stock' => 5,
    ],
    3 => [
        'name'  => 'C',
        'stock' => 5,
    ],
    4 => [
        'name'  => 'D',
        'stock' => 5,
    ],
];
$before_part_stocks = $part_stocks;

$ordered_product_counts      = [];
$manufactured_product_counts = [];

while (true) {
    $manufacturable_product_ids = get_manufacturable_product_ids($product_components, $part_stocks);
    if (count($manufacturable_product_ids) === 0) {
        break;
    }

    $ordered_product_id = array_rand($product_components);
    if (isset($ordered_product_counts[$ordered_product_id])) {
        $ordered_product_counts[$ordered_product_id]++;
    } else {
        $ordered_product_counts[$ordered_product_id] = 1;
    }

    if (in_array($ordered_product_id, $manufacturable_product_ids)) {
        foreach ($product_components[$ordered_product_id]['part'] as $part_id => $part_count) {
            $part_stocks[$part_id]['stock'] -= $part_count;
        }
        if (isset($manufactured_product_counts[$ordered_product_id])) {
            $manufactured_product_counts[$ordered_product_id]++;
        } else {
            $manufactured_product_counts[$ordered_product_id] = 1;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>Document</title>
  </head>
  <body>
    <h1>製造前の各部品の在庫数</h1>
    <?php foreach ($before_part_stocks as $before_part_stock) : ?>
      <p>部品名:<?php echo $before_part_stock['name'] ?> 在庫数:<?php echo $before_part_stock['stock'] ?>個</p>
    <?php endforeach ?>
    <h1>製品の発注数</h1>
    <?php foreach ($ordered_product_counts as $ordered_product_count_id => $ordered_product_count) : ?>
      <p>製品名:<?php echo $product_components[$ordered_product_count_id]['name'] ?> 発注数:<?php echo $ordered_product_count ?>個</p>
    <?php endforeach ?>
    <h1>製造した製品の個数</h1>
    <?php foreach ($manufactured_product_counts as $manufactured_product_count_id => $manufactured_product_count) : ?>
      <p>製品名:<?php echo $product_components[$manufactured_product_count_id]['name'] ?> 製造数:<?php echo $manufactured_product_count ?>個</p>
    <?php endforeach ?>
    <h1>製造後の各部品の在庫数</h1>
    <?php foreach ($part_stocks as $part_stock) : ?>
      <p>部品名:<?php echo $part_stock['name'] ?> 在庫数:<?php echo $part_stock['stock'] ?>個</p>
    <?php endforeach ?>
  </body>
</html>
