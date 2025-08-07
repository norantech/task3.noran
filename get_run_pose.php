<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$id) {
        echo "معرّف غير صالح.";
        exit;
    }

    try {
        // جلب الوضعية من قاعدة البيانات
        $stmt = $pdo->prepare("SELECT * FROM poses WHERE id = ?");
        $stmt->execute([$id]);
        $pose = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($pose) {
            // تغيير الحالة إلى 0
            $update = $pdo->prepare("UPDATE poses SET status = 0 WHERE id = ?");
            $update->execute([$id]);

            // مستقبلاً: إرسال البيانات إلى الذراع الإلكترونية

            // عرض البيانات
            echo "<h3>تم تشغيل الوضعية رقم $id:</h3>";
            echo "<ul>";
            echo "<li>محرك 1: {$pose['motor1']}</li>";
            echo "<li>محرك 2: {$pose['motor2']}</li>";
            echo "<li>محرك 3: {$pose['motor3']}</li>";
            echo "<li>محرك 4: {$pose['motor4']}</li>";
            echo "<li>محرك 5: {$pose['motor5']}</li>";
            echo "<li>محرك 6: {$pose['motor6']}</li>";
            echo "</ul>";
            echo "<a href='index.php'>العودة إلى الصفحة الرئيسية</a>";
        } else {
            echo "لم يتم العثور على الوضعية.";
        }
    } catch (PDOException $e) {
        error_log("خطأ في قاعدة البيانات: " . $e->getMessage());
        echo "حدث خطأ أثناء معالجة الطلب.";
    }
} else {
    echo "طلب غير صالح.";
}
?>
