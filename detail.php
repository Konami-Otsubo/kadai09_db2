<?php
$id = $_GET["id"];
include("funcs.php");
$pdo = db_conn();

// データ取得SQL作成
$sql = "SELECT * FROM vegetables WHERE id = :id";  // テーブル名を修正
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
} else {
    $v = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>

<form method="POST" action="update.php">
  <div class="jumbotron">
    <fieldset>
      <legend>野菜分類表 - 更新</legend>
      <label>名前：<input type="text" name="name" value="<?= h($v["name"]) ?>"></label><br>
      <label>科：<input type="text" name="family" value="<?= h($v["family"]) ?>"></label><br>
      <label>説明：<textarea name="description" rows="4" cols="40"><?= h($v["description"]) ?></textarea></label><br>
      <label>画像パス：<input type="text" name="image_path" value="<?= h($v["image_path"]) ?>"></label><br>
      <input type="hidden" name="id" value="<?= h($v["id"]) ?>">
      <input type="submit" value="送信">
    </fieldset>
  </div>
</form>

</body>
</html>
