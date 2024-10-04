<?php
include('funcs.php');
$pdo = db_conn();

// POSTデータ取得
$name = $_POST['name'];
$family = $_POST['family'];
$description = $_POST['description'];

// 画像アップロード
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

// SQL文を準備
$sql = "INSERT INTO vegetables (name, family, description, image_path) VALUES (:name, :family, :description, :image_path)";
$stmt = $pdo->prepare($sql);

// バインド変数に値を割り当て
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':family', $family, PDO::PARAM_STR);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);
$stmt->bindValue(':image_path', basename($_FILES["image"]["name"]), PDO::PARAM_STR);

// SQL実行
$status = $stmt->execute();

if ($status === false) {
    sql_error($stmt);
} else {
    header('Location: index.php');
}
?>
