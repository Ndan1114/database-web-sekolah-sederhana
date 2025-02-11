<?php
include "../database/konek.php";

$id = $_GET['id'];
$query = "SELECT * FROM guru WHERE id_guru = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $mapel = $_POST['mapel'];

    $query = "UPDATE guru SET nama='$nama', nip='$nip', mapel='$mapel' WHERE id_guru=$id";
    if (mysqli_query($conn, $query)) {
        header("Location: guru.php");
    } else {
        echo "Gagal mengedit data!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Guru</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Gaya Umum */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #333;
        }

        /* Form */
        .form-container {
            background: white;
            width: 90%;
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: 0.3s;
        }
        input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        /* Tombol */
        .submit-btn {
            width: 100%;
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 15px;
            cursor: pointer;
            transition: 0.3s;
        }
        .submit-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<h2>Edit Guru</h2>
<div class="form-container">
    <form method="post" onsubmit="return validateForm()">
        <label>Nama:</label>
        <input type="text" name="nama" id="nama" value="<?= $row['nama']; ?>" required>
        
        <label>NIP:</label>
        <input type="text" name="nip" id="nip" value="<?= $row['nip']; ?>" required>
        
        <label>Mata Pelajaran:</label>
        <input type="text" name="mapel" id="mapel" value="<?= $row['mapel']; ?>" required>
        
        <button type="submit" class="submit-btn"><i class="fas fa-save"></i> Update</button>
    </form>
    <br>
    <a href="guru.php" class="back-link"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<script>
    function validateForm() {
        let nama = document.getElementById("nama").value.trim();
        let nip = document.getElementById("nip").value.trim();
        let mapel = document.getElementById("mapel").value.trim();
        
        if (nama === "" || nip === "" || mapel === "") {
            alert("Semua bidang harus diisi!");
            return false;
        }
        return true;
    }
</script>

</body>
</html>