<?php
include('funcs.php');
$pdo = db_conn();

// POSTデータ取得
$id = $_POST['id'];
$name = $_POST['name'];
$family = $_POST['family'];
$description = $_POST['description'];

// 画像アップロード処理
$target_dir = "uploads/";
if (!empty($_FILES["image"]["name"])) {
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    $image_path = basename($_FILES["image"]["name"]);
} else {
    // 画像が変更されていない場合は既存の画像をそのまま使用
    $image_path = $_POST['existing_image'];
}

// SQL更新
$sql = "UPDATE vegetables SET name = :name, family = :family, description = :description, image_path = :image_path WHERE id = :id";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':family', $family, PDO::PARAM_STR);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);
$stmt->bindValue(':image_path', $image_path, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status === false) {
    sql_error($stmt);
} else {
    header('Location: index.php');
}
?>
