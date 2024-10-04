<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>野菜登録表管理</title>
  <style>
    body {
      background-image: url('img/haikei2.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    .container {
      max-width: 1100px; /* 横幅を1100pxに設定 */
      margin: 80px auto 0;
      background: rgba(255, 255, 255, 0.8);
      padding: 20px;
      border-radius: 15px;
    }

    .form-container {
      display: flex;
      flex-direction: column;
      gap: 15px; /* 各フィールド間のスペース */
      width: 100%;
    }

    .form-row {
      display: flex;
      justify-content: space-between;
      gap: 10px; /* 名前と科の間のスペースを狭く */
      width: 100%;
    }

    .form-row label {
      width: 20%; /* 名前と科の入力幅を揃える */
    }

    #vegDescription {
      width: 100%; /* 説明欄の幅を最大限に */
      height: 60px;
    }

    input, textarea {
      padding: 10px;
      border-radius: 10px;
      border: 1px solid #ccc;
      width: 100%;
    }

    .file-save-container {
      display: flex;
      gap: 10px; /* ボタン間のスペースを調整 */
      justify-content: flex-end; /* ファイル選択と保存ボタンを右寄せ */
    }

    button, input[type="file"] {
      padding: 10px 15px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      width: 120px;
    }

    button:hover {
      background-color: #45a049;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      border-radius: 10px;
      overflow: hidden;
    }

    table, th, td {
      border: 1px solid #000;
    }

    th, td {
      padding: 10px;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
    }

    td img.veg-image {
      max-width: 100px;
      height: auto;
      border-radius: 10px;
    }

    .description-cell {
      height: 80px;
      vertical-align: middle;
      text-align: center;
    }

    td.description-cell {
      width: 50%;
    }
  </style>
</head>
<body>

<div class="container">
  <form id="vegForm" method="POST" action="insert.php" enctype="multipart/form-data">
    <div class="form-container">
      <div class="form-row">
        <label>名前：<input type="text" id="vegName" name="name" required></label>
        <label>科：<input type="text" id="vegFamily" name="family" required></label>
        <input type="file" id="vegImageInput" name="image">
        <button type="submit">保存</button>
      </div>
      <label>説明：<textarea id="vegDescription" name="description"></textarea></label>
    </div>
  </form>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>名前</th>
        <th>科</th>
        <th>説明</th>
        <th>画像</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include('funcs.php');
      $pdo = db_conn();

      // データ取得
      $sql = 'SELECT * FROM vegetables';
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($result as $row) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['family']) . '</td>';
        echo '<td class="description-cell">' . htmlspecialchars($row['description']) . '</td>';
        echo '<td><img src="img/' . htmlspecialchars($row['image_path']) . '" alt="' . htmlspecialchars($row['name']) . '" class="veg-image"></td>';
        echo '<td>
                <a href="edit.php?id=' . htmlspecialchars($row['id']) . '">編集</a> |
                <a href="delete.php?id=' . htmlspecialchars($row['id']) . '">削除</a>
              </td>';
        echo '</tr>';
      }
      ?>
    </tbody>
  </table>
</div>

</body>
</html>

