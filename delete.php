<?php
include('funcs.php');
$pdo = db_conn();

$id = $_GET['id'];

// データ削除
$sql = "DELETE FROM vegetables WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status === false) {
    sql_error($stmt);
} else {
    header('Location: index.php');
}
?>
