<?php
$host = 'localhost';
$dbname = 'robot_arm';
$user = 'root';
$pass = 'mypassword';

// تشغيل إدارة الأخطاء بشكل آمن
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // تسجيل الخطأ في ملف سجل الأخطاء بدلاً من عرضه للمستخدم
    error_log('Database connection error: ' . $e->getMessage());
    die('حدث خطأ أثناء الاتصال بقاعدة البيانات. يرجى المحاولة لاحقًا.');
}
?>
