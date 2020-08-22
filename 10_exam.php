<?php

/**
 * n人の生徒がいます
 * 年にn回(3回)テストが開催されます
 * 教科はn個(算数、国語、理科、社会、英語)あります
 * 点数はランダムで0〜100点
 * ランクを適当に定義する（300〜250=A,249〜200=B,...など）
 *
 * 結果を表示してください
 * 各テストごとの生徒ごとの教科ごとの点数を表で表示
 * 生徒ごとの教科ごとの年間合計点数を表示
 * 上記年間合計点数によるランク表示も合わせて表示
 *
 * 表の形式はいい感じで（見たときに分かりやすく）
 */

function get_rank($student_total_subject_score) {
    if ($student_total_subject_score <= 99) {
        return 'D';
    }
    if ($student_total_subject_score <= 149) {
        return 'C';
    }
    if ($student_total_subject_score <= 199) {
        return 'B';
    }
    if ($student_total_subject_score <= 249) {
        return 'A';
    }
    return 'S';
}

$student_names        = ['佐藤', '田中', '鈴木'];
$subjects             = ['国語', '算数', '理科', '社会', '英語'];
$test_results         = [];
$total_subject_scores = [];
$annual_test_counts   = 3;
for ($test_counts = 1; $test_counts <= $annual_test_counts; $test_counts++) {
    $test_results[$test_counts] = [];
    foreach (array_keys($student_names) as $student_index) {
        $test_results[$test_counts][$student_index] = [];
        if (!isset($total_subject_scores[$student_index])) {
            $total_subject_scores[$student_index] = [];
        }
        foreach (array_keys($subjects) as $subject_index) {
            $test_results[$test_counts][$student_index][$subject_index] = rand(0, 100);
            if (!isset($total_subject_scores[$student_index][$subject_index])) {
                $total_subject_scores[$student_index][$subject_index] = 0;
            }
            $total_subject_scores[$student_index][$subject_index] += $test_results[$test_counts][$student_index][$subject_index];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>Exam</title>
  </head>
  <body>
    <h1>テスト結果</h1>
    <table border="1">
      <?php foreach ($test_results as $test_count => $test_result) : ?>
        <tr>
          <th><?php echo $test_count ?>回目のテスト</th>
          <?php foreach ($subjects as $subject) :?>
            <th><?php echo $subject ?></th>
          <?php endforeach ?>
        </tr>
        <?php foreach ($student_names as $student_index => $student_name) : ?>
          <tr>
            <td><?php echo $student_name ?></td>
            <?php foreach (array_keys($subjects) as $subject_index) : ?>
              <td><?php echo $test_result[$student_index][$subject_index] ?>点</td>
            <?php endforeach ?>
          </tr>
        <?php endforeach ?>
      <?php endforeach ?>
    </table>

    <h1>年間合計得点(科目別)</h1>
    <table border="1">
      <tr>
        <th></th>
        <?php foreach ($subjects as $subject) : ?>
          <th><?php echo $subject ?></th>
        <?php endforeach ?>
      </tr>
      <?php foreach ($student_names as $student_index => $student_name) : ?>
        <tr>
          <td><?php echo $student_name ?></td>
          <?php foreach (array_keys($subjects) as $subject_index) : ?>
            <td><?php echo $total_subject_scores[$student_index][$subject_index] ?>点</td>
          <?php endforeach ?>
        </tr>
      <?php endforeach ?>
    </table>

    <h1>科目別評価(年間合計得点)</h1>
    <table border="1">
      <tr>
        <th></th>
        <?php foreach ($subjects as $subject) : ?>
          <th><?php echo $subject ?></th>
        <?php endforeach ?>
      </tr>
      <?php foreach ($student_names as $student_index => $student_name) : ?>
        <tr>
          <td><?php echo $student_name ?></td>
          <?php foreach (array_keys($subjects) as $subject_index) : ?>
            <td><?php echo get_rank($total_subject_scores[$student_index][$subject_index]) ?></td>
          <?php endforeach ?>
        </tr>
      <?php endforeach ?>
    </table>
  </body>
</html>
