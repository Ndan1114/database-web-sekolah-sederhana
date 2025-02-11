<?php
include "../database/konek.php";

$absen = $_GET['absen']; 
$query = "SELECT * FROM nilai WHERE absen = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $absen);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='nilai.php';</script>";
    exit;
}

if (isset($_POST['submit'])) {
    $nilai = $_POST['nilai'];
    
    // Gunakan prepared statement agar lebih aman
    $stmt = $conn->prepare("UPDATE nilai SET nilai = ? WHERE absen = ?");
    $stmt->bind_param("di", $nilai, $absen);

    if ($stmt->execute()) {
        echo "<script>alert('Nilai berhasil diperbarui!'); window.location.href='nilai.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui nilai!');</script>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nilai</title>
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
            margin: 20px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: left;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn {
            display: block;
            width: 100%;
            background: #28a745;
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
            background: #218838;
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

<h2>Edit Nilai</h2>

<div class="form-container">
    <form method="POST" onsubmit="return validateForm()">
        <label><i class="fas fa-star"></i> Nilai:</label>
        <input type="number" step="0.01" name="nilai" id="nilai" value="<?= htmlspecialchars($row['nilai']); ?>" min="0" max="100" required>

        <button type="submit" name="submit" class="btn"><i class="fas fa-save"></i> Simpan</button>
    </form>
    
    <a href="nilai.php" class="back-btn"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<script>
    function validateForm() {
        let nilai = document.getElementById("nilai").value;
        if (nilai < 0 || nilai > 100) {
            alert("Nilai harus antara 0 - 100.");
            return false;
        }
        return true;
    }
</script>

</body>
</html>