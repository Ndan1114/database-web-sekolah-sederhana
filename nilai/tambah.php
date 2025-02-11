<?php
include "../database/konek.php";

if (isset($_POST['submit'])) {
    $absen    = $_POST['absen'];
    $id_siswa = $_POST['id_siswa'];
    $id_mapel = $_POST['id_mapel'];
    $nilai    = $_POST['nilai'];

    $query = "INSERT INTO nilai (absen, id_siswa, id_mapel, nilai) VALUES ('$absen','$id_siswa', '$id_mapel', '$nilai')";
    if (mysqli_query($conn, $query)) {
        header("Location: nilai.php");
    } else {
        echo "Gagal menambahkan nilai.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Nilai</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            text-align: center;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        .form-container {
            width: 90%;
            max-width: 400px;
            background: white;
            padding: 20px;
            margin: 0 auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: left;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn {
            display: block;
            width: 100%;
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 15px;
            font-size: 16px;
            transition: 0.3s;
        }
        .btn:hover {
            background: #0056b3;
        }
        .back-btn {
            display: block;
            width: 100%;
            background: #6c757d;
            text-align: center;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
            transition: 0.3s;
        }
        .back-btn:hover {
            background: #545b62;
        }
    </style>
</head>
<body>

<h2>Tambah Nilai</h2>

<div class="form-container">
    <form method="POST" onsubmit="return validateForm()">
        <label><i class="fas fa-list-ol"></i> No :</label>
        <input type="number" name="absen" id="absen" min="1" required>

        <label><i class="fas fa-user"></i> Siswa:</label>
        <select name="id_siswa" required>
            <option value="">-- Pilih Siswa --</option>
            <?php
            $siswa = mysqli_query($conn, "SELECT * FROM siswa");
            while ($row = mysqli_fetch_assoc($siswa)) {
                echo "<option value='{$row['id_siswa']}'>{$row['nama']}</option>";
            }
            ?>
        </select>

        <label><i class="fas fa-book"></i> Mata Pelajaran:</label>
        <select name="id_mapel" required>
            <option value="">-- Pilih Mata Pelajaran --</option>
            <?php
            $mapel = mysqli_query($conn, "SELECT * FROM mapel");
            while ($row = mysqli_fetch_assoc($mapel)) {
                echo "<option value='{$row['id_mapel']}'>{$row['nama']}</option>";
            }
            ?>
        </select>

        <label><i class="fas fa-star"></i> Nilai:</label>
        <input type="number" name="nilai" id="nilai" min="0" max="100" required>

        <button type="submit" name="submit" class="btn"><i class="fas fa-save"></i> Simpan</button>
    </form>
    
    <a href="nilai.php" class="back-btn"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<script>
    function validateForm() {
        let absen = document.getElementById("absen").value;
        let nilai = document.getElementById("nilai").value;

        if (absen <= 0) {
            alert("Nomor absensi tidak boleh kurang dari 1.");
            return false;
        }
        if (nilai < 0 || nilai > 100) {
            alert("Nilai harus antara 0 - 100.");
            return false;
        }
        return true;
    }
</script>

</body>
</html>