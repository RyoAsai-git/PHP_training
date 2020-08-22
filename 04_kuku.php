<?php

/**
 * 九九の表をHTMLで作ってください。
 */
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>Multiplication Table</title>
  </head>
  <body>
    <table border="1">
      <?php for ($i = 1; $i <= 9; $i++) : ?>
        <tr>
          <?php for ($j = 1; $j <= 9; $j++) : ?>
            <td><?php echo $i * $j ?></td>
          <?php endfor ?>
        </tr>
      <?php endfor ?>
    </table>
  </body>
</html>