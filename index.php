<?php
require 'db.php';

// جلب الوضعيات المحفوظة
$poses = $pdo->query("SELECT * FROM poses ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم في الذراع</title>
    <!-- تحميل خط عربي جميل -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <style>
        /* خلفية مائية ناعمة */
        body {
            margin: 0;
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
            min-height: 100vh;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 20px;
        }

        h2 {
            margin-bottom: 20px;
            color: #014f86;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.15);
            font-weight: 700;
            font-size: 2.4rem;
        }

        form#controlForm {
            background: rgba(255, 255, 255, 0.9);
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 350px;
            margin-bottom: 40px;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            color: #014f86;
            user-select: none;
        }

        input[type="range"] {
            width: 100%;
            margin-bottom: 18px;
            -webkit-appearance: none;
            height: 8px;
            border-radius: 5px;
            background: #b6d0e2;
            outline: none;
            transition: background 0.3s ease;
        }
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: #014f86;
            cursor: pointer;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: background 0.3s ease;
        }
        input[type="range"]:hover::-webkit-slider-thumb {
            background: #0288d1;
        }

        button {
            background-color: #0288d1;
            border: none;
            color: white;
            padding: 12px 22px;
            margin: 5px 8px 0 0;
            font-size: 1rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 136, 204, 0.3);
            user-select: none;
        }
        button:hover {
            background-color: #0277bd;
        }

        hr {
            width: 90%;
            border: none;
            border-top: 2px solid #0288d1;
            margin: 40px 0 20px 0;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
        }

        h3 {
            color: #014f86;
            margin-bottom: 15px;
            font-weight: 700;
            font-size: 1.8rem;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
        }

        table {
            width: 90%;
            max-width: 900px;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            font-size: 1rem;
        }

        th, td {
            padding: 14px 18px;
            border-bottom: 1px solid #d0d7de;
            text-align: center;
            color: #014f86;
        }
        th {
            background-color: #0288d1;
            color: #fff;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        tr:hover:not(:first-child) {
            background-color: #e1f0ff;
            transition: background-color 0.3s ease;
        }

        .ready {
            color: #2e7d32; /* أخضر */
            font-weight: 700;
        }
        .done {
            color: #757575; /* رمادي */
            font-weight: 600;
        }

        form {
            display: inline-block;
            margin: 0;
        }

        /* زر تحميل */
        td > button {
            background-color: #6a8caf;
            box-shadow: 0 3px 6px rgba(106,140,175,0.4);
        }
        td > button:hover {
            background-color: #547a9a;
        }

        /* تأكيد الحذف */
        form button[type="submit"] {
            background-color: #d32f2f;
            box-shadow: 0 3px 6px rgba(211,47,47,0.5);
        }
        form button[type="submit"]:hover {
            background-color: #b71c1c;
        }

        @media (max-width: 700px) {
            body {
                padding: 20px 10px;
            }
            form#controlForm {
                width: 100%;
                padding: 20px;
            }
            table {
                width: 100%;
                font-size: 0.9rem;
            }
            button {
                padding: 10px 18px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

    <h2>التحكم في الذراع الإلكترونية</h2>

    <form id="controlForm" method="POST" action="save_pose.php">
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <label for="motor<?= $i ?>">محرك <?= $i ?>:</label>
            <input type="range" id="motor<?= $i ?>" name="motor<?= $i ?>" min="0" max="180" value="90" step="1" aria-valuemin="0" aria-valuemax="180" aria-valuenow="90"><br>
        <?php endfor; ?>

        <button type="submit" title="حفظ الوضعية">💾 حفظ الوضعية</button>
        <button type="button" onclick="resetSliders()" title="إعادة تعيين المحركات">🔄 إعادة تعيين</button>
    </form>

    <hr>

    <h3>الوضعيات المحفوظة</h3>
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>المحركات</th>
            <th>الحالة</th>
            <th>تشغيل / تحميل</th>
            <th>حذف</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($poses as $pose): ?>
            <tr>
                <td><?= htmlspecialchars($pose['id']) ?></td>
                <td>
                    <?= htmlspecialchars(implode(" | ", [
                        $pose['motor1'], $pose['motor2'], $pose['motor3'],
                        $pose['motor4'], $pose['motor5'], $pose['motor6']
                    ])) ?>
                </td>
                <td>
                    <span class="<?= $pose['status'] == 1 ? 'ready' : 'done' ?>">
                        <?= $pose['status'] == 1 ? 'جاهز' : 'تم تشغيله' ?>
                    </span>

                    <?php if ($pose['status'] == 0): ?>
                        <form method="POST" action="update_status.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($pose['id']) ?>">
                            <button type="submit" title="إعادة تعيين الحالة">🔁 إعادة التعيين</button>
                        </form>
                    <?php endif; ?>
                </td>
                <td>
                    <form method="POST" action="get_run_pose.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($pose['id']) ?>">
                        <button type="submit" title="تشغيل الوضعية">تشغيل</button>
                    </form>
                    <button onclick='loadPose(<?= json_encode([
                        (int)$pose["motor1"], (int)$pose["motor2"], (int)$pose["motor3"],
                        (int)$pose["motor4"], (int)$pose["motor5"], (int)$pose["motor6"]
                    ]) ?>)' title="تحميل الوضعية">تحميل</button>
                </td>
                <td>
                    <form method="POST" action="remove_pose.php" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذه الوضعية؟');">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($pose['id']) ?>">
                        <button type="submit" title="حذف الوضعية">❌ حذف</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<script>
    function resetSliders() {
        const sliders = document.querySelectorAll('input[type="range"]');
        sliders.forEach(slider => slider.value = 90);
    }

    function loadPose(values) {
        const sliders = document.querySelectorAll('input[type="range"]');
        sliders.forEach((slider, i) => {
            slider.value = values[i];
        });
    }
</script>

</body>
</html>
