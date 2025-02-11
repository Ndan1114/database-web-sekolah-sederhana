<?php
include "../database/konek.php";

// Ambil ID dari parameter
$id = $_GET['id'];
$query = "SELECT * FROM siswa WHERE id_siswa = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Proses hapus jika tombol diklik
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $queryDelete = "DELETE FROM siswa WHERE id_siswa = $id";
    if (mysqli_query($conn, $queryDelete)) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location.href = 'siswa.php';
              </script>";
    } else {
        echo "<script>alert('Gagal menghapus data!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Siswa</title>
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
            color: #d9534f;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            color: #333;
        }
        .buttons {
            margin-top: 20px;
        }
        .btn {
            border: none;
            padding: 12px;
            width: 45%;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-danger {
            background-color: #d9534f;
            color: white;
        }
        .btn-danger:hover {
            background-color: #c9302c;
        }
        .btn-secondary {
            background-color: #5bc0de;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #31b0d5;
        }
    </style>
</head>
<body>

<div class="container">
    <h2><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h2>
    <p>Apakah Anda yakin ingin menghapus data siswa <strong><?= $row['nama']; ?></strong>?</p>

    <form method="post">
        <div class="buttons">
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
            <a href="siswa.php" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
        </div>
    </form>
</div>

</body>
</html>