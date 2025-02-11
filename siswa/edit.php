<?php
include "../database/konek.php";

$id = $_GET['id'];
$query = "SELECT * FROM siswa WHERE id_siswa = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];
    $lahir = $_POST['lahir'];

    $query = "UPDATE siswa SET nama='$nama', nis='$nis', kelas='$kelas', alamat='$alamat', lahir='$lahir' WHERE id_siswa=$id";
    
    if (mysqli_query($conn, $query)) {
        header("Location: siswa.php");
        exit;
    } else {
        echo "<script>alert('Gagal mengedit data!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container {
            width: 90%;
            max-width: 400px;
            background: white;
            padding: 20px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #0056b3;
            margin-bottom: 20px;
        }
        form {
            text-align: left;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        input:focus {
            border-color: #0056b3;
            outline: none;
        }
        button {
            background-color: #ffc107;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            margin-top: 15px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        button:hover {
            background-color: #e0a800;
        }
        .back-link {
            display: block;
            margin-top: 15px;
            color: #0056b3;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            font-size: 14px;
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Siswa</h2>
    <form method="post" onsubmit="return validateForm()">
        <label>Nama:</label>
        <input type="text" name="nama" id="nama" value="<?= $row['nama']; ?>" required>
        <span class="error" id="errorNama">Nama harus lebih dari 3 karakter!</span>

        <label>NIS:</label>
        <input type="text" name="nis" id="nis" value="<?= $row['nis']; ?>" required>
        <span class="error" id="errorNIS">NIS harus berupa angka!</span>

        <label>Kelas:</label>
        <input type="text" name="kelas" id="kelas" value="<?= $row['kelas']; ?>" required>

        <label>Alamat:</label>
        <input type="text" name="alamat" id="alamat" value="<?= $row['alamat']; ?>" required>

        <label>Tanggal Lahir:</label>
        <input type="date" name="lahir" id="lahir" value="<?= $row['lahir']; ?>" required>

        <button type="submit"><i class="fas fa-edit"></i> Update</button>
    </form>
    <a href="siswa.php" class="back-link"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<script>
    function validateForm() {
        let nama = document.getElementById("nama").value;
        let nis = document.getElementById("nis").value;
        let errorNama = document.getElementById("errorNama");
        let errorNIS = document.getElementById("errorNIS");
        let valid = true;

        if (nama.length < 3) {
            errorNama.style.display = "block";
            valid = false;
        } else {
            errorNama.style.display = "none";
        }

        if (isNaN(nis)) {
            errorNIS.style.display = "block";
            valid = false;
        } else {
            errorNIS.style.display = "none";
        }

        return valid;
    }
</script>

</body>
</html>