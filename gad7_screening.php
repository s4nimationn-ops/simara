<?php
// FILE: gad7_screening.php

/*
================================================================================
BAGIAN 1: LOGIKA PHP UNTUK MEMPROSES FORM
================================================================================
Kode di bawah ini hanya akan berjalan SETELAH pengguna menekan tombol "Submit".
Ia akan memeriksa apakah metode request adalah 'POST', yang berarti form telah dikirim.
*/

// Inisialisasi variabel awal. Variabel ini akan kita gunakan nanti.
$total_score = 0;       // Untuk menyimpan total skor dari jawaban.
$result_text = '';      // Untuk menyimpan teks interpretasi hasil.
$is_submitted = false;  // Penanda apakah form sudah disubmit atau belum.

// Mengecek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $is_submitted = true; // Set penanda menjadi true karena form sudah disubmit.

    // Daftar pertanyaan GAD-7. Kita simpan dalam array agar mudah diakses.
    // Ini juga berguna agar kita tidak perlu menulis ulang pertanyaan di bagian HTML.
    $questions = [
        1 => "Merasa gugup, cemas, atau tegang?",
        2 => "Tidak mampu menghentikan atau mengontrol rasa khawatir?",
        3 => "Terlalu mengkhawatirkan berbagai hal?",
        4 => "Sulit untuk santai?",
        5 => "Sangat gelisah sehingga sulit untuk diam?",
        6 => "Menjadi mudah kesal atau lekas marah?",
        7 => "Merasa takut seolah-olah sesuatu yang mengerikan akan terjadi?"
    ];

    // Menghitung total skor
    // Kita akan melakukan loop sebanyak jumlah pertanyaan (7 kali).
    foreach ($questions as $i => $question) {
        // 'q'.$i akan menghasilkan nama input seperti 'q1', 'q2', dst.
        $input_name = 'q' . $i;

        // Mengecek apakah jawaban untuk pertanyaan ke-$i ada di data POST.
        // `isset()` digunakan untuk memastikan tidak ada error jika salah satu jawaban kosong.
        if (isset($_POST[$input_name])) {
            // Menambahkan nilai jawaban (0, 1, 2, atau 3) ke total skor.
            // `(int)` digunakan untuk memastikan nilainya adalah angka (integer).
            $total_score += (int)$_POST[$input_name];
        }
    }

    // Menentukan interpretasi hasil berdasarkan total skor
    if ($total_score >= 0 && $total_score <= 4) {
        $result_text = "Tingkat kecemasan minimal. Ini adalah tingkat kecemasan yang normal.";
    } elseif ($total_score >= 5 && $total_score <= 9) {
        $result_text = "Tingkat kecemasan ringan. Anda mungkin merasakan beberapa gejala kecemasan, tetapi masih terkendali.";
    } elseif ($total_score >= 10 && $total_score <= 14) {
        $result_text = "Tingkat kecemasan sedang. Gejala kecemasan yang Anda rasakan cukup signifikan. Disarankan untuk memonitor kondisi Anda dan mempertimbangkan konsultasi jika gejala berlanjut.";
    } elseif ($total_score >= 15 && $total_score <= 21) {
        $result_text = "Tingkat kecemasan berat. Gejala kecemasan yang Anda rasakan sangat signifikan dan mungkin mengganggu aktivitas sehari-hari. Sangat disarankan untuk mencari bantuan profesional dari psikolog atau psikiater.";
    }
}

/*
================================================================================
BAGIAN 2: KODE HTML DAN TAMPILAN
================================================================================
Bagian ini bertanggung jawab untuk menampilkan konten ke pengguna.
Struktur HTML ini berisi CSS sederhana untuk styling dan logika PHP untuk
menampilkan form atau hasil.
*/
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skrining Kecemasan Remaja (GAD-7)</title>
    <style>
        /* CSS sederhana untuk membuat tampilan lebih rapi */
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
        h1, h2 {
            color: #2c3e50;
            text-align: center;
        }
        p {
            font-size: 1.1em;
            margin-bottom: 20px;
        }
        .question-block {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        .question-text {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .options label {
            display: block;
            margin-bottom: 8px;
            cursor: pointer;
        }
        input[type="radio"] {
            margin-right: 10px;
        }
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
        .submit-btn:hover {
            background-color: #2980b9;
        }
        .result-box {
            text-align: center;
            padding: 20px;
            border: 2px solid #3498db;
            border-radius: 8px;
            background-color: #eaf5fc;
        }
        .result-box h2 {
            margin-top: 0;
        }
        .result-box p {
            font-size: 1.2em;
        }
        .try-again-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: #fff;
            background-color: #2ecc71;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .try-again-btn:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Skrining Kecemasan GAD-7</h1>
        <p>Selama <strong>2 minggu terakhir</strong>, seberapa sering kamu terganggu oleh masalah-masalah berikut?</p>
        <hr>

        <?php
        /*
        ========================================================================
        BAGIAN 3: LOGIKA TAMPILAN KONDISIONAL
        ========================================================================
        Di sini kita menggunakan variabel `$is_submitted` yang sudah kita atur di awal.
        - JIKA `true` (form sudah disubmit), kita tampilkan hasilnya.
        - JIKA `false` (halaman baru dibuka), kita tampilkan form kuesioner.
        */
        ?>

        <?php if ($is_submitted): ?>
            
            <div class="result-box">
                <h2>Hasil Skrining Anda</h2>
                <p>Total Skor Anda: <strong><?php echo $total_score; ?></strong></p>
                <p><strong>Interpretasi:</strong><br><?php echo $result_text; ?></p>
                <p style="font-size: 0.9em; color: #555;"><strong>Penting:</strong> Hasil ini bukan diagnosis medis. Jika Anda merasa khawatir dengan kondisi Anda, silakan hubungi profesional kesehatan mental.</p>
                <a href="gad7_screening.php" class="try-again-btn">Coba Lagi</a>
            </div>

        <?php else: ?>

            <form action="gad7_screening.php" method="post">
                <?php
                // Kita gunakan lagi variabel $questions dari bagian PHP di atas.
                // Ini membuat kode lebih bersih karena kita tidak perlu menulis ulang pertanyaan.
                $questions = [
                    1 => "Merasa gugup, cemas, atau tegang?",
                    2 => "Tidak mampu menghentikan atau mengontrol rasa khawatir?",
                    3 => "Terlalu mengkhawatirkan berbagai hal?",
                    4 => "Sulit untuk santai?",
                    5 => "Sangat gelisah sehingga sulit untuk diam?",
                    6 => "Menjadi mudah kesal atau lekas marah?",
                    7 => "Merasa takut seolah-olah sesuatu yang mengerikan akan terjadi?"
                ];

                // Pilihan jawaban beserta skornya
                $options = [
                    "Tidak sama sekali" => 0,
                    "Beberapa hari" => 1,
                    "Lebih dari separuh hari" => 2,
                    "Hampir setiap hari" => 3
                ];

                // Loop untuk menampilkan setiap pertanyaan
                foreach ($questions as $num => $question_text) {
                    echo '<div class="question-block">';
                    echo '<p class="question-text">' . $num . '. ' . $question_text . '</p>';
                    echo '<div class="options">';
                    // Loop untuk menampilkan setiap pilihan jawaban untuk pertanyaan saat ini
                    foreach ($options as $option_text => $value) {
                        echo '<label>';
                        // Input radio button. `name`-nya `q1`, `q2`, dst. `value`-nya 0, 1, 2, atau 3.
                        // `required` memastikan pengguna harus menjawab setiap pertanyaan.
                        echo '<input type="radio" name="q' . $num . '" value="' . $value . '" required> ';
                        echo $option_text;
                        echo '</label>';
                    }
                    echo '</div></div>';
                }
                ?>
                <button type="submit" class="submit-btn">Lihat Hasil</button>
            </form>

        <?php endif; ?>

    </div>

</body>
</html>