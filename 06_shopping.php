<?php
/**
 * ある商品群があります
 * 商品は名前と金額
 *
 * ある買う人がいます
 * 名前と都道府県
 *
 * その人が商品をN個買います
 * 買う商品はランダムで購入数もランダム 1個以上
 *
 * 送料は500円です
 * ただ、購入数が5以上の場合は1000円になります
 * また、都道府県が沖縄県と北海道はプラス1000円になります
 *
 * 買った商品ごとの商品名、個数と、金額
 * 小計、消費税、送料（消費税かからない）、合計金額を表示してください
 *
 * 消費税が変わる事を考慮しましょう
 */

$products = [
    1 => [
        'name'  => 'マスク',
        'price' => 1000,
    ],
    2 => [
        'name'  => '食器',
        'price' => 2000,
    ],
    3 => [
        'name'  => 'Tシャツ',
        'price' => 3000,
    ],
];

$customers = [
    1 => [
        'name'       => '田中',
        'prefecture' => '東京',
    ],
    2 => [
        'name'       => '佐藤',
        'prefecture' => '北海道',
    ],
    3 => [
        'name'       => '鈴木',
        'prefecture' => '大阪',
    ],
];

$customer              = $customers[array_rand($customers)];
$bought_product_counts = [];
$do_buy                = true;
while ($do_buy) {
    $product_id = array_rand($products);
    if (isset($bought_product_counts[$product_id])) {
        $bought_product_counts[$product_id]++;
    } else {
        $bought_product_counts[$product_id] = 1;
    }

    $do_buy = (rand(0, 1) === 0);
}

$delivery_fee = 500;
if (array_sum($bought_product_counts) >= 5) {
    $delivery_fee += 500;
}
$additional_delivery_fee_prefectures = ['北海道', '沖縄県'];
if (in_array($customer['prefecture'], $additional_delivery_fee_prefectures)) {
    $delivery_fee += 1000;
}

$subtotal = 0;
foreach ($bought_product_counts as $product_id => $count) {
    $subtotal += $products[$product_id]['price'] * $count;
}

$tax_rate    = 0.1;
$sales_tax   = (int) floor($subtotal * $tax_rate);
$total_price = $subtotal + $sales_tax + $delivery_fee;

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>Shopping</title>
  </head>
  <body>
    <p>購入者:<?php echo $customer['name'] ?>様</p>
    <p>発送先:<?php echo $customer['prefecture']?></p>
    <?php foreach ($bought_product_counts as $bought_product_id => $bought_product_count) : ?>
      <p><?php echo $products[$bought_product_id]['name'] ?>を<?php echo $bought_product_count ?>個購入しました</p>
      <p><?php echo $products[$bought_product_id]['price'] * $bought_product_count ?>円です</p>
    <?php endforeach ?>
    <p>小計:<?php echo $subtotal ?>円</p>
    <p>消費税:<?php echo $sales_tax ?>円</p>
    <p>送料:<?php echo $delivery_fee ?>円</p>
    <p>合計金額:<?php echo $total_price ?>円</p>
  </body>
</html>