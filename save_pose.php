<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $motors = [];

    for ($i = 1; $i <= 6; $i++) {
        $key = 'motor' . $i;
        
        // تحقق من وجود القيمة وصلاحيتها
        $value = filter_input(INPUT_POST, $key, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 0, 'max_range' => 180]
        ]);
        
        if ($value === false || $value === null) {
            // القيمة غير صالحة، تعيين قيمة افتراضية 90
            $value = 90;
        }
        
        $motors[$key] = $value;
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO poses (motor1, motor2, motor3, motor4, motor5, motor6)
            VALUES (:motor1, :motor2, :motor3, :motor4, :motor5, :motor6)
        ");
        $stmt->execute($motors);

        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        error_log("خطأ في حفظ الوضعية: " . $e->getMessage());
        echo "حدث خطأ أثناء حفظ الوضعية.";
    }
} else {
    echo "طلب غير صالح.";
}
?>
