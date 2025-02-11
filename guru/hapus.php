<?php
include "../database/konek.php";

$id = $_GET['id'];
$query = "SELECT * FROM guru WHERE id_guru = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href = 'guru.php';</script>";
    exit;
}

if (isset($_POST['hapus'])) {
    $deleteQuery = "DELETE FROM guru WHERE id_guru = $id";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href = 'guru.php';</script>";
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
    <title>Hapus Guru</title>
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

        /* Card Box */
        .card {
            background: white;
            width: 90%;
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Tombol */
        .btn {
            display: inline-block;
            width: 45%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin: 10px;
            transition: 0.3s;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>

<h2>Konfirmasi Hapus</h2>
<div class="card">
    <p>Apakah Anda yakin ingin menghapus guru berikut?</p>
    <p><strong><?= $row['nama']; ?></strong> (<?= $row['nip']; ?>)</p>

    <form method="post" onsubmit="return confirmDelete()">
        <button type="submit" name="hapus" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
        <a href="guru.php" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
    </form>
</div>

<script>
    function confirmDelete() {
        return confirm("Yakin ingin menghapus data ini?");
    }
</script>

</body>
</html>