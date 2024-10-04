<?php
include("funcs.php");
$pdo = db_conn();

// データ取得SQL作成
$sql = "SELECT * FROM vegetables";  // テーブル名を修正
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

$values = "";
if ($status == false) {
    sql_error($stmt);
} else {
    $values = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($values, JSON_UNESCAPED_UNICODE);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>野菜分類表一覧</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>

<div class="container jumbotron">
  <table>
    <tr>
      <th>ID</th>
      <th>名前</th>
      <th>科</th>
      <th>説明</th>
      <th>画像</th>
      <th>操作</th>
    </tr>
    <?php foreach ($values as $v) { ?>
      <tr>
        <td><?= h($v["id"]) ?></td>
        <td><?= h($v["name"]) ?></td>
        <td><?= h($v["family"]) ?></td>
        <td><?= h($v["description"]) ?></td>
        <td><?= h($v["image_path"]) ?></td>
        <td>
          <a href="detail.php?id=<?= h($v["id"]) ?>">更新</a>
          <a href="delete.php?id=<?= h($v["id"]) ?>">削除</a>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>

<script>
  const json_data = '<?php echo $json; ?>';
  console.log(JSON.parse(json_data));
</script>

</body>
</html>
