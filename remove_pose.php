<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$id) {
        echo "معرّف غير صالح.";
        exit;
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM poses WHERE id = ?");
        $stmt->execute([$id]);

        // إعادة التوجيه إلى الصفحة الرئيسية
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        error_log("خطأ عند حذف الوضعية: " . $e->getMessage());
        echo "حدث خطأ أثناء حذف الوضعية.";
    }
} else {
    echo "طلب غير صالح.";
}
?>
