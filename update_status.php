<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$id) {
        echo "معرّف غير صالح.";
        exit;
    }

    try {
        $stmt = $pdo->prepare("UPDATE poses SET status = 1 WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        error_log("خطأ في تحديث الحالة: " . $e->getMessage());
        echo "حدث خطأ أثناء تحديث الحالة.";
    }
} else {
    echo "طلب غير صالح.";
}
?>
