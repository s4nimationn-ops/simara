<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
require_once '../config/db.php';
require_once '../config/session.php';

// pastikan user login sebagai remaja
cek_role(['remaja']);
$user_id = $_SESSION['user_id'];

// ================================
// Variabel awal
// ================================
$total_score = 0;
$kategori = '';
$result_text = '';
$is_submitted = false;
$success_message = '';
$error_message = '';
$wait_message = '';
$can_screen = true;

// ================================
// Batasi screening ulang 20 menit
// ================================
$limit_minutes = 20;
$query_last = $conn->prepare("SELECT tanggal_input FROM data_gad7 WHERE user_id = ? ORDER BY tanggal_input DESC LIMIT 1");
$query_last->bind_param("i", $user_id);
$query_last->execute();
$result_last = $query_last->get_result();

if ($row_last = $result_last->fetch_assoc()) {
    $last_time = strtotime($row_last['tanggal_input']);
    $current_time = time();
    $diff_minutes = floor(($current_time - $last_time) / 60);

    if ($diff_minutes < $limit_minutes) {
        $can_screen = false;
        $wait_message = "Tunggu " . ($limit_minutes - $diff_minutes) . " menit lagi ⏳";
    }
}
$query_last->close();

// ================================
// Daftar pertanyaan GAD-7
// ================================
$questions = [
    1 => "Merasa gugup, cemas, atau tegang?",
    2 => "Tidak mampu menghentikan atau mengontrol rasa khawatir?",
    3 => "Terlalu mengkhawatirkan berbagai hal?",
    4 => "Sulit untuk santai?",
    5 => "Sangat gelisah sehingga sulit untuk diam?",
    6 => "Menjadi mudah kesal atau lekas marah?",
    7 => "Merasa takut seolah-olah sesuatu yang mengerikan akan terjadi?"
];

// ================================
// Saat form disubmit
// ================================
if ($_SERVER["REQUEST_METHOD"] === "POST" && $can_screen) {
    $is_submitted = true;
    $answers = [];

    foreach ($questions as $i => $q) {
        $input = 'q' . $i;
        $answers[$i] = isset($_POST[$input]) ? (int)$_POST[$input] : 0;
        $total_score += $answers[$i];
    }

    // Tentukan kategori
    if ($total_score >= 0 && $total_score <= 4) {
        $kategori = "Minimal";
        $result_text = "Tingkat kecemasan minimal. Ini adalah tingkat kecemasan yang normal.";
    } elseif ($total_score >= 5 && $total_score <= 9) {
        $kategori = "Ringan";
        $result_text = "Tingkat kecemasan ringan. Anda mungkin merasakan beberapa gejala kecemasan, tetapi masih terkendali.";
    } elseif ($total_score >= 10 && $total_score <= 14) {
        $kategori = "Sedang";
        $result_text = "Tingkat kecemasan sedang. Gejala cukup signifikan. Disarankan memonitor kondisi Anda dan mempertimbangkan konsultasi jika berlanjut.";
    } elseif ($total_score >= 15 && $total_score <= 21) {
        $kategori = "Berat";
        $result_text = "Tingkat kecemasan berat. Gejala sangat signifikan dan mungkin mengganggu aktivitas sehari-hari. Disarankan untuk mencari bantuan profesional.";
    }

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO data_gad7 
        (user_id, q1, q2, q3, q4, q5, q6, q7, total_skor, kategori, tanggal_input) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param(
        "iiiiiiiiis",
        $user_id,
        $answers[1],
        $answers[2],
        $answers[3],
        $answers[4],
        $answers[5],
        $answers[6],
        $answers[7],
        $total_score,
        $kategori
    );

    if ($stmt->execute()) {
        $success_message = "✅ Hasil skrining GAD-7 Anda telah berhasil disimpan.";
        $can_screen = false; // supaya setelah submit langsung dibatasi lagi
    } else {
        $error_message = "❌ Gagal menyimpan hasil: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skrining Kecemasan GAD-7</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            color: #333;
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            width: 100%;
        }
        h1, h2 { color: #2c3e50; text-align: center; }
        p { font-size: 1.1em; margin-bottom: 20px; }
        .question-block { margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #e0e0e0; }
        .question-text { font-weight: bold; margin-bottom: 10px; }
        .options label { display: block; margin-bottom: 8px; cursor: pointer; }
        input[type="radio"] { margin-right: 10px; }
        .submit-btn {
            display: block;
            width: 100%;
            padding: 15px;
            font-size: 1.2em;
            font-weight: bold;
            color: #fff;
            background-color: #3498db;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .submit-btn:hover { background-color: #2980b9; }
        .result-box {
            text-align: center;
            padding: 20px;
            border: 2px solid #3498db;
            border-radius: 8px;
            background-color: #eaf5fc;
        }
        .result-box h2 { margin-top: 0; }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: #fff;
            background-color: #95a5a6;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-back:hover { background-color: #7f8c8d; }
        .alert-success { color: green; font-weight: bold; text-align: center; margin-bottom: 15px; }
        .alert-error { color: red; font-weight: bold; text-align: center; margin-bottom: 15px; }
        .alert-wait {
            background: #dbeafe;
            color: #1e3a8a;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Skrining Kecemasan GAD-7</h1>

    <?php if ($success_message): ?>
        <div class="alert-success"><?= $success_message; ?></div>
    <?php endif; ?>
    <?php if ($error_message): ?>
        <div class="alert-error"><?= $error_message; ?></div>
    <?php endif; ?>
    <?php if ($wait_message): ?>
        <div class="alert-wait"><?= $wait_message; ?></div>
    <?php endif; ?>

    <?php if ($is_submitted): ?>
        <div class="result-box">
            <h2>Hasil Skrining Anda</h2>
            <p><strong>Total Skor:</strong> <?= $total_score; ?></p>
            <p><strong>Kategori:</strong> <?= htmlspecialchars($kategori); ?></p>
            <p><?= htmlspecialchars($result_text); ?></p>
            <p style="font-size: 0.9em; color: #555;">
                <strong>Penting:</strong> Hasil ini bukan diagnosis medis. Jika Anda merasa khawatir, silakan hubungi profesional kesehatan mental.
            </p>
            <a href="dashboard.php" class="btn-back">← Kembali ke Dashboard</a>
        </div>
    <?php elseif (!$can_screen): ?>
        <div class="result-box">
            <p>⏳ Anda sudah melakukan screening baru-baru ini.</p>
            <a href="dashboard.php" class="btn-back">← Kembali ke Dashboard</a>
        </div>
    <?php else: ?>
        <form action="gad7_screening.php" method="post">
            <?php
            $options = [
                "Tidak sama sekali" => 0,
                "Beberapa hari" => 1,
                "Lebih dari separuh hari" => 2,
                "Hampir setiap hari" => 3
            ];
            foreach ($questions as $num => $question_text) {
                echo '<div class="question-block">';
                echo '<p class="question-text">' . $num . '. ' . $question_text . '</p>';
                echo '<div class="options">';
                foreach ($options as $option_text => $value) {
                    echo '<label>';
                    echo '<input type="radio" name="q' . $num . '" value="' . $value . '" required> ';
                    echo $option_text;
                    echo '</label>';
                }
                echo '</div></div>';
            }
            ?>
            <button type="submit" class="submit-btn">Lihat Hasil & Simpan</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
